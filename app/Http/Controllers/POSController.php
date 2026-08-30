<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::whereHas('batches', function($query) {
            $query->where('pieces_left', '>', 0);
        })
        ->with(['batches' => function($query) {
            $query->orderBy('expiry_date', 'asc');
        }, 'activePromo'])
        ->get();
        
        $products->each(function($product) {
            $availableBatches = $product->batches->filter(function($batch) {
                return $batch->pieces_left > 0;
            });
            
            $expiredBatches = $product->batches->filter(function($batch) {
                return $batch->expiry_date < now() && $batch->pieces_left > 0;
            });
            
            $product->available_batches = $availableBatches;
            $product->total_pieces_left = $availableBatches->sum('pieces_left');
            $product->earliest_expiry = $availableBatches->min('expiry_date');
            $product->pieces_per_box = $availableBatches->first()->pieces_per_box ?? 1;
            $product->has_expired_batch = $expiredBatches->isNotEmpty();
            $product->expired_stock_count = $expiredBatches->sum('pieces_left');
            $product->has_promo = $product->hasActivePromo;
            $product->promo_discount_percent = $product->currentDiscountPercent;
            $product->promo_reason = $product->has_promo ? $product->activePromo->reason : null;
            $product->discounted_price = $product->has_promo ? $product->discountedPrice : $product->price;
        });
        
        $discountTypes = \App\Models\DiscountType::where('is_active', true)->get();
        
        return view('pos.index', compact('products', 'discountTypes'));
    }
    
    public function checkout(Request $request)
    {
        date_default_timezone_set('Asia/Manila');

        DB::beginTransaction();

        try {
            $cart = $request->cart_items;
            
            if (is_string($cart)) {
                $cart = json_decode($cart, true);
            }
            
            $discount = $request->discount ?? 0;
            $cashTendered = $request->cash_tendered ?? 0;
            $discountTypeId = $request->discount_type_id ?? null;
            $discountPercent = $request->discount_percent ?? 0;
            $idNumber = $request->id_number ?? null;
            $customerTypeName = $request->customer_type_name ?? null;
            $prescriptionId = $request->prescription_id ?? null;

            if (!$cart || !is_array($cart) || count($cart) == 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart is empty.'
                ], 400);
            }

            $prescription = null;
            $prescriptionItemsMap = [];
            
            if ($prescriptionId) {
                $prescription = \App\Models\Prescription::with('items')->find($prescriptionId);
                
                if (!$prescription) {
                    throw new \Exception("Prescription not found.");
                }
                
                if ($prescription->status !== 'active') {
                    throw new \Exception("Prescription is not active.");
                }
                
                if ($prescription->valid_until && $prescription->valid_until < now()) {
                    throw new \Exception("Prescription has expired on " . $prescription->valid_until->format('M d, Y'));
                }
                
                foreach ($prescription->items as $item) {
                    $prescriptionItemsMap[$item->product_id] = $item;
                }
                
                foreach ($cart as $item) {
                    if (isset($prescriptionItemsMap[$item['id']])) {
                        $prescItem = $prescriptionItemsMap[$item['id']];
                        $remaining = $prescItem->quantity_remaining;
                        
                        if ($item['qty'] > $remaining) {
                            throw new \Exception(
                                "Prescription limit exceeded for {$prescItem->product_name}. " .
                                "Only {$remaining} remaining out of {$prescItem->quantity_prescribed} prescribed."
                            );
                        }
                    }
                }
            }

            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['subtotal'];
            }

            $discountAmount = $discount;
            $totalAmount = $subtotal - $discountAmount;

            if ($cashTendered < $totalAmount) {
                throw new \Exception("Insufficient payment. Need ₱" . number_format($totalAmount - $cashTendered, 2) . " more.");
            }

            $customerType = 'regular';
            $discountTypeName = null;
            if ($discountTypeId) {
                $discountType = \App\Models\DiscountType::find($discountTypeId);
                if ($discountType) {
                    $customerType = strtolower(str_replace(' ', '_', $discountType->name));
                    $discountTypeName = $discountType->name;
                }
            }

            $invoiceNo = 'INV-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);

            $saleData = [
                'invoice_no' => $invoiceNo,
                'user_id' => auth()->id(),
                'subtotal' => $subtotal,
                'discount' => $discountAmount,
                'total_amount' => $totalAmount,
                'cash_tendered' => $cashTendered,
                'change' => $cashTendered - $totalAmount,
                'discount_type_id' => $discountTypeId,
                'discount_percent' => $discountPercent,
                'customer_type' => $customerType,
                'created_at' => now(),
                'updated_at' => now()
            ];
            
            if ($idNumber && $customerTypeName) {
                $saleData['id_number'] = $idNumber;
                $saleData['customer_type_name'] = $customerTypeName;
            }
            
            if ($prescriptionId) {
                $saleData['prescription_id'] = $prescriptionId;
            }

            $saleId = DB::table('sales')->insertGetId($saleData);

            foreach ($cart as $item) {
                if ($prescriptionId && isset($prescriptionItemsMap[$item['id']])) {
                    $prescItem = $prescriptionItemsMap[$item['id']];
                    $prescItem->quantity_remaining -= $item['qty'];
                    $prescItem->quantity_dispensed = ($prescItem->quantity_dispensed ?? 0) + $item['qty'];
                    $prescItem->save();
                    
                    if ($prescItem->quantity_remaining == 0) {
                        ActivityLog::log(
                            auth()->id(),
                            auth()->user()->username,
                            'update_prescription_item',
                            'Prescription',
                            "Prescription item {$prescItem->product_name} fully dispensed",
                            'Success'
                        );
                    }
                }
                
                $product = Product::with(['batches' => function($query) {
                    $query->where('pieces_left', '>', 0)
                          ->orderBy('expiry_date', 'asc')
                          ->orderBy('arrival_date', 'asc');
                }])->find($item['id']);
                
                if (!$product) {
                    throw new \Exception("Product not found: " . $item['id']);
                }

                $piecesToDeduct = $item['qty'];

                $totalAvailable = $product->batches->sum('pieces_left');
                if ($totalAvailable < $piecesToDeduct) {
                    throw new \Exception("Insufficient stock for: " . $product->name . 
                        ". Available: " . $totalAvailable . ", Needed: " . $piecesToDeduct);
                }

                $remainingPieces = $piecesToDeduct;
                foreach ($product->batches as $batch) {
                    if ($remainingPieces <= 0) break;
                    
                    $deductFromBatch = min($batch->pieces_left, $remainingPieces);
                    
                    $batch->pieces_left -= $deductFromBatch;
                    $batch->quantity = ceil($batch->pieces_left / $batch->pieces_per_box);
                    $batch->save();
                    
                    $remainingPieces -= $deductFromBatch;
                }
                
                DB::table('sale_items')->insert([
                    'sale_id' => $saleId,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['unitPrice'],
                    'original_price' => isset($item['originalPrice']) ? $item['originalPrice'] : $item['unitPrice'],
                    'total_price' => $item['subtotal'],
                    'discount_percent' => isset($item['discountPercent']) ? $item['discountPercent'] : 0,
                    'discount_amount' => isset($item['discountAmount']) ? $item['discountAmount'] : 0,
                    'sell_type' => $item['type'] ?? 'piece',
                    'pieces_per_box' => $item['piecesPerBox'] ?? 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            if ($prescriptionId && $prescription) {
                $prescription->load('items');
                $allItemsDispensed = $prescription->items->every(function($item) {
                    return $item->quantity_remaining <= 0;
                });
                
                if ($allItemsDispensed) {
                    $prescription->status = 'used';
                    $prescription->save();
                    
                    ActivityLog::log(
                        auth()->id(),
                        auth()->user()->username,
                        'use_prescription',
                        'Prescription',
                        "Prescription #{$prescription->prescription_number} fully used and marked as used",
                        'Success'
                    );
                }
            }

            DB::commit();

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'process_sale',
                'POS',
                "Processed sale: Invoice #{$invoiceNo} | Total: ₱" . number_format($totalAmount, 2) . " | Items: " . count($cart),
                'Success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Checkout successful!',
                'sale_id' => $saleId,
                'total_amount' => $totalAmount,
                'change' => $cashTendered - $totalAmount,
                'invoice_no' => $invoiceNo,
                'receipt_url' => route('receipts.print', $saleId)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Checkout failed: ' . $e->getMessage()
            ], 500);
        } 
    }

    public function findByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();
        
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found']);
        }
        
        $totalPiecesLeft = $product->total_pieces_left;
        
        if ($totalPiecesLeft <= 0) {
            return response()->json(['success' => false, 'message' => 'Product out of stock']);
        }
        
        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'discounted_price' => $product->discounted_price,
                'has_promo' => $product->hasActivePromo,
                'promo_percent' => $product->currentDiscountPercent,
                'pieces_left' => $totalPiecesLeft,
                'barcode' => $product->barcode,
            ]
        ]);   
    }

    public function searchPrescription(Request $request)
    {
        $search = $request->get('search');
        
        $prescriptions = \App\Models\Prescription::with(['items.product'])
            ->where('status', 'active')
            ->where(function($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('prescription_number', 'like', "%{$search}%");
            })
            ->where(function($q) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>=', now());
            })
            ->get();
        
        foreach ($prescriptions as $prescription) {
            foreach ($prescription->items as $item) {
                $item->quantity_remaining = $item->quantity_remaining ?? $item->quantity_prescribed;
            }
        }
        
        return response()->json([
            'success' => true,
            'data' => $prescriptions
        ]);
    }

    public function getPrescription($id)
    {
        $prescription = \App\Models\Prescription::with(['items.product'])->findOrFail($id);
        
        if ($prescription->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'This prescription is no longer active.'
            ], 400);
        }
        
        if ($prescription->valid_until && $prescription->valid_until < now()) {
            return response()->json([
                'success' => false,
                'message' => 'This prescription has expired.'
            ], 400);
        }
        
        foreach ($prescription->items as $item) {
            $item->quantity_remaining = $item->quantity_remaining ?? $item->quantity_prescribed;
        }
        
        return response()->json([
            'success' => true,
            'data' => $prescription
        ]);
    }
}