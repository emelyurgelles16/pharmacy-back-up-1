<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductBatch;
use App\Models\DosageForm;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        // ============================================================
        // 1. STATS & CHARTS - BASE SA LAHAT NG PRODUCTS (WALANG FILTER)
        // ============================================================
        $allProducts = Product::with(['batches' => function($q) {
            $q->orderBy('expiry_date', 'asc');
        }, 'dosageForm'])->get();

        // Summary statistics (para sa stat cards)
        $totalMedicines = $allProducts->count();
        $totalStock = $allProducts->sum(function($p) {
            return $p->batches->sum('pieces_left');
        });

        $lowStockCount = 0;
        $outOfStockCount = 0;
        $nearExpiryCount = 0;
        $expiredCount = 0;
        $lowStockItems = [];
        $nearExpiryItems = [];
        $expiredItems = [];
        $outOfStockItems = [];

        foreach ($allProducts as $product) {
            foreach ($product->batches as $batch) {
                // ===== OUT OF STOCK =====
                if ($batch->pieces_left <= 0) {
                    $outOfStockCount++;
                    $outOfStockItems[] = (object)[
                        'name' => $product->name,
                        'pieces_left' => $batch->pieces_left,
                        'batch_number' => $batch->batch_number ?? 'Batch 1'
                    ];
                }
                // ===== LOW STOCK =====
                elseif ($batch->pieces_left <= 100) {
                    $lowStockCount++;
                    $lowStockItems[] = (object)[
                        'name' => $product->name,
                        'total_pieces_left' => $batch->pieces_left,
                        'earliest_expiry_date' => $batch->expiry_date
                    ];
                }
                
                // ===== EXPIRED (CHECK MUNA BAGO NEAR EXPIRY) =====
                if ($batch->expiry_date && $batch->expiry_date < now() && $batch->pieces_left > 0) {
                    $expiredCount++;
                    $expiredItems[] = (object)[
                        'name' => $product->name,
                        'total_pieces_left' => $batch->pieces_left,
                        'earliest_expiry_date' => $batch->expiry_date
                    ];
                }
                // ===== NEAR EXPIRY (ELSEIF PARA HINDI MA-DUPLICATE) =====
                elseif ($batch->expiry_date && $batch->expiry_date < now()->addDays(30) && $batch->pieces_left > 0) {
                    $nearExpiryCount++;
                    $nearExpiryItems[] = (object)[
                        'name' => $product->name,
                        'total_pieces_left' => $batch->pieces_left,
                        'earliest_expiry_date' => $batch->expiry_date
                    ];
                }
            }
        }

        // Chart data (para sa charts)
        $inventoryByCategory = $allProducts->groupBy('category')->map(function($items, $category) {
            return $items->sum(function($p) {
                return $p->batches->sum('pieces_left') * $p->price;
            });
        })->map(function($value, $key) {
            return (object)['category' => $key, 'value' => $value];
        })->values();

        $inventoryByDosageForm = $allProducts->groupBy(function($p) {
            return $p->dosageForm ? $p->dosageForm->name : 'Unknown';
        })->map(function($items, $form) {
            return $items->sum(function($p) {
                return $p->batches->sum('pieces_left') * $p->price;
            });
        })->map(function($value, $key) {
            return (object)['dosage_form' => $key, 'value' => $value];
        })->values();

        $statusDistribution = [
            'Available' => $allProducts->sum(function($p) {
                return $p->batches->filter(function($b) {
                    return $b->pieces_left > 0 && (!$b->expiry_date || $b->expiry_date > now());
                })->count();
            }),
            'Low Stock' => $lowStockCount,
            'Out of Stock' => $outOfStockCount,
            'Near Expiry' => $nearExpiryCount,
            'Expired' => $expiredCount
        ];

        // Remove duplicates from items
        $lowStockItems = collect($lowStockItems)->unique('name')->values()->all();
        $nearExpiryItems = collect($nearExpiryItems)->unique('name')->values()->all();
        $expiredItems = collect($expiredItems)->unique('name')->values()->all();
        $outOfStockItems = collect($outOfStockItems)->unique('name')->values()->all();

        // ============================================================
        // 2. STOCK MOVEMENT DATA (LAST 7 DAYS)
        // ============================================================
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $last7Days->push(now()->subDays($i)->format('Y-m-d'));
        }

        $stockMovement = $last7Days->map(function($date) {
            // ✅ Stock Added - mula sa product_batches (arrival_date)
            $added = ProductBatch::whereDate('arrival_date', $date)
                ->sum('total_pieces');
            
            // ✅ Stock Deducted - mula sa sale_items (created_at)
            $deducted = SaleItem::whereDate('created_at', $date)
                ->sum('quantity');
            
            return [
                'date' => \Carbon\Carbon::parse($date)->format('M d'),
                'added' => (int) $added,
                'deducted' => (int) $deducted,
                'net' => (int) ($added - $deducted)
            ];
        });

        $stockMovementData = [
            'labels' => $stockMovement->pluck('date')->toArray(),
            'added' => $stockMovement->pluck('added')->toArray(),
            'deducted' => $stockMovement->pluck('deducted')->toArray(),
            'net' => $stockMovement->pluck('net')->toArray(),
        ];

        // ============================================================
        // 3. INVENTORY LIST - MAY FILTER, ALPHABETICAL, PAGINATION
        // ============================================================
        $query = Product::with(['batches' => function($q) use ($request) {
            $q->orderBy('expiry_date', 'asc');
            
            // Filter by expiry date from
            if ($request->has('expiry_from') && $request->expiry_from != '') {
                $q->where('expiry_date', '>=', $request->expiry_from);
            }
            
            // Filter by expiry date to
            if ($request->has('expiry_to') && $request->expiry_to != '') {
                $q->where('expiry_date', '<=', $request->expiry_to);
            }
            
            // Filter by batch number
            if ($request->has('batch_no') && $request->batch_no != '') {
                $q->where('batch_number', 'LIKE', '%' . $request->batch_no . '%');
            }
        }, 'dosageForm']);

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            $query->whereHas('batches', function($q) use ($status, $request) {
                // Apply expiry filters to status query too
                if ($request->has('expiry_from') && $request->expiry_from != '') {
                    $q->where('expiry_date', '>=', $request->expiry_from);
                }
                if ($request->has('expiry_to') && $request->expiry_to != '') {
                    $q->where('expiry_date', '<=', $request->expiry_to);
                }
                if ($request->has('batch_no') && $request->batch_no != '') {
                    $q->where('batch_number', 'LIKE', '%' . $request->batch_no . '%');
                }

                if ($status == 'available') {
                    $q->where('pieces_left', '>', 0)
                      ->where(function($sq) {
                          $sq->where('expiry_date', '>', now())
                             ->orWhereNull('expiry_date');
                      });
                } elseif ($status == 'lowstock') {
                    $q->where('pieces_left', '>', 0)
                      ->where('pieces_left', '<=', 100);
                } elseif ($status == 'outofstock') {
                    $q->where('pieces_left', '=', 0);
                } elseif ($status == 'nearexpired') {
                    $q->where('pieces_left', '>', 0)
                      ->where('expiry_date', '>', now())
                      ->where('expiry_date', '<', now()->addDays(30));
                } elseif ($status == 'expired') {
                    $q->where('pieces_left', '>', 0)
                      ->where('expiry_date', '<', now());
                }
            });
        }

        // ✅ ALPHABETICAL SORTING + PAGINATION (50 per page)
        $products = $query->orderBy('name', 'asc')->paginate(50);

        // ============================================================
        // 4. RETURN VIEW
        // ============================================================
        $categories = Category::all();
        $dosageForms = DosageForm::where('is_active', true)->orderBy('name')->get();

        return view('inventory-report', compact(
            'products',
            'allProducts',
            'categories',
            'dosageForms',
            'totalMedicines',
            'totalStock',
            'lowStockCount',
            'outOfStockCount',
            'nearExpiryCount',
            'expiredCount',
            'lowStockItems',
            'nearExpiryItems',
            'expiredItems',
            'outOfStockItems',
            'inventoryByCategory',
            'inventoryByDosageForm',
            'statusDistribution',
            'stockMovementData'
        ));
    }

    public function print(Request $request)
    {
        $query = Product::with(['batches' => function($q) use ($request) {
            $q->orderBy('expiry_date', 'asc');
            
            if ($request->has('expiry_from') && $request->expiry_from != '') {
                $q->where('expiry_date', '>=', $request->expiry_from);
            }
            if ($request->has('expiry_to') && $request->expiry_to != '') {
                $q->where('expiry_date', '<=', $request->expiry_to);
            }
            if ($request->has('batch_no') && $request->batch_no != '') {
                $q->where('batch_number', 'LIKE', '%' . $request->batch_no . '%');
            }
        }, 'dosageForm']);

        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            $query->whereHas('batches', function($q) use ($status, $request) {
                if ($request->has('expiry_from') && $request->expiry_from != '') {
                    $q->where('expiry_date', '>=', $request->expiry_from);
                }
                if ($request->has('expiry_to') && $request->expiry_to != '') {
                    $q->where('expiry_date', '<=', $request->expiry_to);
                }
                if ($request->has('batch_no') && $request->batch_no != '') {
                    $q->where('batch_number', 'LIKE', '%' . $request->batch_no . '%');
                }

                if ($status == 'available') {
                    $q->where('pieces_left', '>', 0)
                      ->where(function($sq) {
                          $sq->where('expiry_date', '>', now())
                             ->orWhereNull('expiry_date');
                      });
                } elseif ($status == 'lowstock') {
                    $q->where('pieces_left', '>', 0)
                      ->where('pieces_left', '<=', 100);
                } elseif ($status == 'outofstock') {
                    $q->where('pieces_left', '=', 0);
                } elseif ($status == 'nearexpired') {
                    $q->where('pieces_left', '>', 0)
                      ->where('expiry_date', '>', now())
                      ->where('expiry_date', '<', now()->addDays(30));
                } elseif ($status == 'expired') {
                    $q->where('pieces_left', '>', 0)
                      ->where('expiry_date', '<', now());
                }
            });
        }

        // ✅ ALPHABETICAL SORTING
        $products = $query->orderBy('name', 'asc')->get();

        $totalMedicines = $products->count();
        $totalStock = $products->sum(function($p) {
            return $p->batches->sum('pieces_left');
        });

        return view('inventory-report-print', compact('products', 'totalMedicines', 'totalStock'));
    }

    public function export(Request $request)
    {
        $query = Product::with(['batches' => function($q) use ($request) {
            $q->orderBy('expiry_date', 'asc');
            
            if ($request->has('expiry_from') && $request->expiry_from != '') {
                $q->where('expiry_date', '>=', $request->expiry_from);
            }
            if ($request->has('expiry_to') && $request->expiry_to != '') {
                $q->where('expiry_date', '<=', $request->expiry_to);
            }
            if ($request->has('batch_no') && $request->batch_no != '') {
                $q->where('batch_number', 'LIKE', '%' . $request->batch_no . '%');
            }
        }, 'dosageForm']);

        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            $query->whereHas('batches', function($q) use ($status, $request) {
                if ($request->has('expiry_from') && $request->expiry_from != '') {
                    $q->where('expiry_date', '>=', $request->expiry_from);
                }
                if ($request->has('expiry_to') && $request->expiry_to != '') {
                    $q->where('expiry_date', '<=', $request->expiry_to);
                }
                if ($request->has('batch_no') && $request->batch_no != '') {
                    $q->where('batch_number', 'LIKE', '%' . $request->batch_no . '%');
                }

                if ($status == 'available') {
                    $q->where('pieces_left', '>', 0)
                      ->where(function($sq) {
                          $sq->where('expiry_date', '>', now())
                             ->orWhereNull('expiry_date');
                      });
                } elseif ($status == 'lowstock') {
                    $q->where('pieces_left', '>', 0)
                      ->where('pieces_left', '<=', 100);
                } elseif ($status == 'outofstock') {
                    $q->where('pieces_left', '=', 0);
                } elseif ($status == 'nearexpired') {
                    $q->where('pieces_left', '>', 0)
                      ->where('expiry_date', '>', now())
                      ->where('expiry_date', '<', now()->addDays(30));
                } elseif ($status == 'expired') {
                    $q->where('pieces_left', '>', 0)
                      ->where('expiry_date', '<', now());
                }
            });
        }

        // ✅ ALPHABETICAL SORTING
        $products = $query->orderBy('name', 'asc')->get();

        $csv = "Product Name,Barcode,Brand,Dosage Form,Category,Price,Total Stock,Inventory Value,Status\n";
        foreach ($products as $product) {
            $totalStock = $product->batches->sum('pieces_left');
            $inventoryValue = $totalStock * $product->price;
            $status = $totalStock > 0 ? 'In Stock' : 'Out of Stock';
            $dosageForm = $product->dosageForm ? $product->dosageForm->name : '';

            $csv .= "\"{$product->name}\",";
            $csv .= "\"{$product->barcode}\",";
            $csv .= "\"{$product->brand}\",";
            $csv .= "\"{$dosageForm}\",";
            $csv .= "\"{$product->category}\",";
            $csv .= "{$product->price},";
            $csv .= "{$totalStock},";
            $csv .= "{$inventoryValue},";
            $csv .= "\"{$status}\"\n";
        }

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="inventory_report_' . date('Y-m-d') . '.csv"');
    }
}