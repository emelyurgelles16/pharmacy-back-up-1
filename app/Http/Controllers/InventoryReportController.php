<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductBatch;
use App\Models\DosageForm;
use Illuminate\Support\Facades\DB;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['batches' => function($q) {
            $q->orderBy('expiry_date', 'asc');
        }, 'dosageForm']);

        // Filter by category
        if ($request->has('category') && $request->category != 'all' && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Filter by dosage form
        if ($request->has('dosage_form') && $request->dosage_form != 'all' && $request->dosage_form != '') {
            $query->where('dosage_form_id', $request->dosage_form);
        }

        // Filter by brand
        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand', 'LIKE', '%' . $request->brand . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            $query->whereHas('batches', function($q) use ($status) {
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

        $products = $query->get();

        // Summary statistics
        $totalMedicines = $products->count();
        $totalStock = $products->sum(function($p) {
            return $p->batches->sum('pieces_left');
        });

        $lowStockCount = 0;
        $outOfStockCount = 0;
        $nearExpiryCount = 0;
        $expiredCount = 0;
        $lowStockItems = [];
        $nearExpiryItems = [];

        foreach ($products as $product) {
            foreach ($product->batches as $batch) {
                if ($batch->pieces_left <= 0) {
                    $outOfStockCount++;
                } elseif ($batch->pieces_left <= 100) {
                    $lowStockCount++;
                    $lowStockItems[] = (object)[
                        'name' => $product->name,
                        'total_pieces_left' => $batch->pieces_left,
                        'earliest_expiry_date' => $batch->expiry_date
                    ];
                }
                if ($batch->expiry_date && $batch->expiry_date < now()->addDays(30) && $batch->pieces_left > 0) {
                    $nearExpiryCount++;
                    $nearExpiryItems[] = (object)[
                        'name' => $product->name,
                        'total_pieces_left' => $batch->pieces_left,
                        'earliest_expiry_date' => $batch->expiry_date
                    ];
                }
                if ($batch->expiry_date && $batch->expiry_date < now() && $batch->pieces_left > 0) {
                    $expiredCount++;
                }
            }
        }

        // Chart data
        $inventoryByCategory = $products->groupBy('category')->map(function($items, $category) {
            return $items->sum(function($p) {
                return $p->batches->sum('pieces_left') * $p->price;
            });
        })->map(function($value, $key) {
            return (object)['category' => $key, 'value' => $value];
        })->values();

        $inventoryByDosageForm = $products->groupBy(function($p) {
            return $p->dosageForm ? $p->dosageForm->name : 'Unknown';
        })->map(function($items, $form) {
            return $items->sum(function($p) {
                return $p->batches->sum('pieces_left') * $p->price;
            });
        })->map(function($value, $key) {
            return (object)['dosage_form' => $key, 'value' => $value];
        })->values();

        $statusDistribution = [
            'Available' => $products->sum(function($p) {
                return $p->batches->filter(function($b) {
                    return $b->pieces_left > 0 && (!$b->expiry_date || $b->expiry_date > now());
                })->count();
            }),
            'Low Stock' => $lowStockCount,
            'Out of Stock' => $outOfStockCount,
            'Near Expiry' => $nearExpiryCount,
            'Expired' => $expiredCount
        ];

        $categories = Category::all();
        $dosageForms = DosageForm::where('is_active', true)->orderBy('name')->get();

        // Remove duplicates from lowStockItems and nearExpiryItems
        $lowStockItems = collect($lowStockItems)->unique('name')->values()->all();
        $nearExpiryItems = collect($nearExpiryItems)->unique('name')->values()->all();

        return view('inventory-report', compact(
            'products',
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
            'inventoryByCategory',
            'inventoryByDosageForm',
            'statusDistribution'
        ));
    }

    public function print(Request $request)
    {
        $query = Product::with(['batches' => function($q) {
            $q->orderBy('expiry_date', 'asc');
        }, 'dosageForm']);

        if ($request->has('category') && $request->category != 'all' && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('dosage_form') && $request->dosage_form != 'all' && $request->dosage_form != '') {
            $query->where('dosage_form_id', $request->dosage_form);
        }

        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand', 'LIKE', '%' . $request->brand . '%');
        }

        $products = $query->get();

        $totalMedicines = $products->count();
        $totalStock = $products->sum(function($p) {
            return $p->batches->sum('pieces_left');
        });

        return view('inventory-report-print', compact('products', 'totalMedicines', 'totalStock'));
    }

    public function export(Request $request)
    {
        $query = Product::with(['batches' => function($q) {
            $q->orderBy('expiry_date', 'asc');
        }, 'dosageForm']);

        if ($request->has('category') && $request->category != 'all' && $request->category != '') {
            $query->where('category', $request->category);
        }

        if ($request->has('dosage_form') && $request->dosage_form != 'all' && $request->dosage_form != '') {
            $query->where('dosage_form_id', $request->dosage_form);
        }

        if ($request->has('brand') && $request->brand != '') {
            $query->where('brand', 'LIKE', '%' . $request->brand . '%');
        }

        $products = $query->get();

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