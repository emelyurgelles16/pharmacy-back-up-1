<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SalesItem;
use App\Models\Product;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SalesReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view sales reports']);
    }
    
    public function index(Request $request)
    {
        $query = Sale::with(['user', 'discountType', 'items']);
        
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        if ($request->customer_type && $request->customer_type != 'all') {
            $query->where('customer_type', $request->customer_type);
        }
        
        $dateFrom = $request->date_from;
        $dateTo = $request->date_to;
        if (!$dateFrom && !$dateTo) {
            $query->whereDate('created_at', Carbon::today());
            $dateFrom = Carbon::today()->format('Y-m-d');
            $dateTo = Carbon::today()->format('Y-m-d');
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();
        
        $totalSales = $query->sum('total_amount');
        $totalTransactions = $query->count();
        $averageSale = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        $totalItemsSold = SalesItem::whereIn('sale_id', $query->pluck('id'))->sum('quantity');
        
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->when($dateFrom, function($q) use ($dateFrom) {
                return $q->whereDate('sales.created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function($q) use ($dateTo) {
                return $q->whereDate('sales.created_at', '<=', $dateTo);
            })
            ->select(
                'products.name', 
                DB::raw('SUM(sale_items.quantity) as total_sold'),
                DB::raw('SUM(sale_items.total_price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        $salesByCustomerType = $query->select('customer_type', DB::raw('SUM(total_amount) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('customer_type')
            ->get();
        
        $salesChart = DB::table('sales')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->when($dateFrom, function($q) use ($dateFrom) {
                return $q->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function($q) use ($dateTo) {
                return $q->whereDate('created_at', '<=', $dateTo);
            })
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();
        
        $hourlySales = DB::table('sales')
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('SUM(total_amount) as total'))
            ->when($dateFrom, function($q) use ($dateFrom) {
                return $q->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($dateTo, function($q) use ($dateTo) {
                return $q->whereDate('created_at', '<=', $dateTo);
            })
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour', 'asc')
            ->get();
        
        $hoursData = [];
        for ($i = 8; $i <= 20; $i++) {
            $found = $hourlySales->firstWhere('hour', $i);
            $hoursData[] = [
                'hour' => $i,
                'label' => date('g A', mktime($i, 0, 0)),
                'total' => $found ? (float)$found->total : 0
            ];
        }
        
        $discountTypes = \App\Models\DiscountType::where('is_active', true)->get();
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'view_sales_report',
            'Sales Reports',
            'Viewed sales report for period: ' . $dateFrom . ' to ' . $dateTo . ' - ' . $totalTransactions . ' transactions',
            'Success'
        );
        
        return view('sales-reports.index', compact(
            'sales', 'totalSales', 'totalTransactions', 'averageSale', 'totalItemsSold',
            'topProducts', 'salesByCustomerType', 'salesChart', 'hoursData',
            'dateFrom', 'dateTo', 'discountTypes'
        ));
    }
    
    public function export(Request $request)
    {
        $query = Sale::with(['user', 'discountType']);
        
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'sales_report_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        fputcsv($handle, ['Invoice No', 'Date', 'Time', 'Cashier', 'Customer Type', 'Subtotal', 'Discount', 'Total', 'Payment', 'Change']);
        
        foreach ($sales as $sale) {
            fputcsv($handle, [
                $sale->invoice_no,
                $sale->created_at->format('m/d/Y'),
                $sale->created_at->format('h:i A'),
                $sale->user->username,
                $sale->customer_type ?? 'Walk-in',
                number_format($sale->subtotal, 2),
                number_format($sale->discount, 2),
                number_format($sale->total_amount, 2),
                number_format($sale->cash_tendered, 2),
                number_format($sale->change, 2)
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
        $dateFrom = $request->date_from ?? Carbon::today()->format('Y-m-d');
        $dateTo = $request->date_to ?? Carbon::today()->format('Y-m-d');
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'export_sales_report',
            'Sales Reports',
            'Exported sales report for period: ' . $dateFrom . ' to ' . $dateTo . ' - ' . $sales->count() . ' transactions',
            'Success'
        );
        
        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
    
    public function print(Request $request)
    {
        $query = Sale::with(['user', 'discountType', 'items.product']);
        
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
            $dateFrom = $request->date_from;
        } else {
            $dateFrom = Carbon::today()->format('Y-m-d');
        }
        
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
            $dateTo = $request->date_to;
        } else {
            $dateTo = Carbon::today()->format('Y-m-d');
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();
        
        $totalSales = $sales->sum('total_amount');
        $totalTransactions = $sales->count();
        $totalItemsSold = SalesItem::whereIn('sale_id', $sales->pluck('id'))->sum('quantity');
        $averageSale = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->when($request->date_from, function($q) use ($request) {
                return $q->whereDate('sales.created_at', '>=', $request->date_from);
            })
            ->when($request->date_to, function($q) use ($request) {
                return $q->whereDate('sales.created_at', '<=', $request->date_to);
            })
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_sold'), DB::raw('SUM(sale_items.total_price) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        $pharmacy = [
            'name' => \App\Models\Setting::get('pharmacy_name', 'AERPHARMACY'),
            'address' => \App\Models\Setting::get('pharmacy_address', ''),
            'contact' => \App\Models\Setting::get('pharmacy_contact', ''),
        ];

        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'print_sales_report',
            'Sales Reports',
            'Printed sales report for period: ' . $dateFrom . ' to ' . $dateTo . ' - ' . $totalTransactions . ' transactions',
            'Success'
        );
        
        return view('sales-reports.print', compact('sales', 'totalSales', 'totalTransactions', 'totalItemsSold', 'averageSale', 'topProducts', 'dateFrom', 'dateTo', 'pharmacy'));
    }
}