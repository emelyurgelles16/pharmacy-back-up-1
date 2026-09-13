<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Product;
use App\Models\ActivityLog;
use App\Models\DiscountType;
use App\Models\Setting;
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
        
        // Date filters
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
        
        // ✅ DEFAULT DATE FILTER (Today) - kung walang date_from at date_to
        if (!$request->date_from && !$request->date_to) {
            $query->whereDate('created_at', Carbon::today());
        }
        
        if ($request->customer_type && $request->customer_type != 'all') {
            $query->where('customer_type', $request->customer_type);
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();
        
        // Statistics
        $totalSales = $sales->sum('total_amount');
        $totalTransactions = $sales->count();
        $averageSale = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        $totalItemsSold = SaleItem::whereIn('sale_id', $sales->pluck('id'))->sum('quantity');
        
        // Top Products
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereIn('sales.id', $sales->pluck('id'))
            ->select(
                'products.name', 
                DB::raw('SUM(sale_items.quantity) as total_sold'),
                DB::raw('SUM(sale_items.total_price) as total_revenue')
            )
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        // Sales by Customer Type
        $salesByCustomerType = $sales->groupBy('customer_type')->map(function($items, $type) {
            return (object)[
                'customer_type' => $type ?: 'walk_in',
                'total' => $items->sum('total_amount'),
                'count' => $items->count()
            ];
        })->values();
        
        // Daily Sales Chart
        $salesChart = DB::table('sales')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();
        
        // Hourly Sales
        $hourlySales = DB::table('sales')
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('SUM(total_amount) as total'))
            ->whereDate('created_at', '>=', $dateFrom)
            ->whereDate('created_at', '<=', $dateTo)
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
        
        $discountTypes = DiscountType::where('is_active', true)->get();
        
        // Log activity
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
        
        // ✅ DEFAULT DATE FILTER (Today) - kung walang date_from at date_to
        if (!$request->date_from && !$request->date_to) {
            $query->whereDate('created_at', Carbon::today());
        }
        
        if ($request->customer_type && $request->customer_type != 'all') {
            $query->where('customer_type', $request->customer_type);
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'sales_report_' . date('Y-m-d') . '.csv';
        $handle = fopen('php://temp', 'w+');
        
        // CSV Headers
        fputcsv($handle, ['Invoice No', 'Date', 'Time', 'Cashier', 'Customer Type', 'Subtotal', 'Discount', 'Total', 'Payment', 'Change']);
        
        foreach ($sales as $sale) {
            // ✅ Check if user exists before accessing username
            $cashier = $sale->user ? $sale->user->username : 'Deleted User';
            
            fputcsv($handle, [
                $sale->invoice_no ?? 'N/A',
                $sale->created_at ? $sale->created_at->format('m/d/Y') : 'N/A',
                $sale->created_at ? $sale->created_at->format('h:i A') : 'N/A',
                $cashier,
                $sale->customer_type ?? 'Walk-in',
                number_format($sale->subtotal ?? 0, 2),
                number_format($sale->discount ?? 0, 2),
                number_format($sale->total_amount ?? 0, 2),
                number_format($sale->cash_tendered ?? 0, 2),
                number_format($sale->change ?? 0, 2)
            ]);
        }
        
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        
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
        
        // ✅ DEFAULT DATE FILTER (Today) - ITO ANG KULANG KANINA!
        if (!$request->date_from && !$request->date_to) {
            $query->whereDate('created_at', Carbon::today());
        }
        
        if ($request->customer_type && $request->customer_type != 'all') {
            $query->where('customer_type', $request->customer_type);
        }
        
        $sales = $query->orderBy('created_at', 'desc')->get();
        
        $totalSales = $sales->sum('total_amount');
        $totalTransactions = $sales->count();
        $totalItemsSold = SaleItem::whereIn('sale_id', $sales->pluck('id'))->sum('quantity');
        $averageSale = $totalTransactions > 0 ? $totalSales / $totalTransactions : 0;
        
        $topProducts = DB::table('sale_items')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereIn('sales.id', $sales->pluck('id'))
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_sold'), DB::raw('SUM(sale_items.total_price) as total_revenue'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();
        
        $pharmacy = [
            'name' => Setting::get('pharmacy_name', 'AERPHARMACY'),
            'address' => Setting::get('pharmacy_address', ''),
            'contact' => Setting::get('pharmacy_contact', ''),
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