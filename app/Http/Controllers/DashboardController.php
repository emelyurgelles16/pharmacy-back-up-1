<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductBatch;
use App\Models\StockQueue;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $userRole = $user->roles->first()->name ?? 'cashier';
        $today = Carbon::today();
        $cashierId = $user->id;

        // ==================== PHARMACIST DATA ====================
        if ($userRole === 'Pharmacist') {
            // Total Products
            $totalProducts = DB::table('products')->count();

            // Low Stock Count
            $lowStockCount = DB::table('product_batches')
                ->where('pieces_left', '>', 0)
                ->where('pieces_left', '<=', 30)
                ->distinct('product_id')
                ->count('product_id');

            // Near Expiry Count
            $nearExpiryCount = DB::table('product_batches')
                ->where('expiry_date', '<=', Carbon::now()->addDays(30))
                ->where('expiry_date', '>', Carbon::now())
                ->where('pieces_left', '>', 0)
                ->distinct('product_id')
                ->count('product_id');

            // Out of Stock Count
            $outOfStockCount = DB::table('product_batches')
                ->where('pieces_left', 0)
                ->distinct('product_id')
                ->count('product_id');

            // Sales Today (all users - Pharmacist can see all)
            $transactionsToday = DB::table('sales')->whereDate('created_at', $today)->count();
            $salesToday = DB::table('sales')->whereDate('created_at', $today)->sum('total_amount') ?? 0;
            $itemsSoldToday = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->whereDate('sales.created_at', $today)
                ->sum('sale_items.quantity') ?? 0;

            // Top Selling Products
            $topProductsRaw = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->join('products', 'sale_items.product_id', '=', 'products.id')
                ->whereDate('sales.created_at', $today)
                ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(5)
                ->get();

            $topProducts = [];
            foreach ($topProductsRaw as $item) {
                $topProducts[] = (object)[
                    'name' => $item->name,
                    'total_sold' => $item->total_sold,
                ];
            }

            // Recent Transactions
            $recentTransactions = Sale::with('user')
                ->orderByDesc('created_at')
                ->limit(10)
                ->get();

            // Stock Levels
            $stockLevelsRaw = DB::table('products')
                ->leftJoin('product_batches', 'products.id', '=', 'product_batches.product_id')
                ->select('products.name', DB::raw('SUM(product_batches.pieces_left) as total_stock'))
                ->where('product_batches.pieces_left', '>', 0)
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_stock')
                ->limit(10)
                ->get();

            $stockLevels = [];
            foreach ($stockLevelsRaw as $item) {
                $stockLevels[] = (object)[
                    'name' => $item->name,
                    'total_stock' => (int)$item->total_stock
                ];
            }

            // Inventory Status
            $inventoryStatus = [
                'in_stock' => DB::table('product_batches')->where('pieces_left', '>', 30)->sum('pieces_left'),
                'low_stock' => DB::table('product_batches')->where('pieces_left', '>', 0)->where('pieces_left', '<=', 30)->sum('pieces_left'),
                'out_of_stock' => DB::table('product_batches')->where('pieces_left', 0)->sum('pieces_left')
            ];

            return view('dashboard', compact(
                'totalProducts',
                'lowStockCount',
                'nearExpiryCount',
                'outOfStockCount',
                'transactionsToday',
                'salesToday',
                'itemsSoldToday',
                'topProducts',
                'recentTransactions',
                'stockLevels',
                'inventoryStatus',
                'userRole'
            ));
        }

        // ==================== PHARMACY ASSISTANT DATA ====================
        // Total Products
        $totalProducts = DB::table('products')->count();

        // Low Stock Count (products with batches <= 30 pcs) - DAPAT PRODUCT COUNT, HINDI BATCH COUNT
        $lowStockCount = DB::table('product_batches')
            ->where('pieces_left', '>', 0)
            ->where('pieces_left', '<=', 30)
            ->distinct('product_id')
            ->count('product_id');

        // Near Expiry Count (products with batches expiring within 30 days)
        $nearExpiryCount = DB::table('product_batches')
            ->where('expiry_date', '<=', Carbon::now()->addDays(30))
            ->where('expiry_date', '>', Carbon::now())
            ->where('pieces_left', '>', 0)
            ->distinct('product_id')
            ->count('product_id');

        // Out of Stock Count (products with zero stock)
        $outOfStockCount = DB::table('product_batches')
            ->where('pieces_left', 0)
            ->distinct('product_id')
            ->count('product_id');

        // Stock Levels per Product (Top 10 for bar graph) - KUHAIN ANG MGA PRODUCTS NA MAY STOCK
        $stockLevelsRaw = DB::table('products')
            ->leftJoin('product_batches', 'products.id', '=', 'product_batches.product_id')
            ->select('products.name', DB::raw('SUM(product_batches.pieces_left) as total_stock'))
            ->where('product_batches.pieces_left', '>', 0)
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_stock')
            ->limit(10)
            ->get();

        $stockLevels = [];
        foreach ($stockLevelsRaw as $item) {
            $stockLevels[] = (object)[
                'name' => $item->name,
                'total_stock' => (int)$item->total_stock
            ];
        }

        // Inventory Status Distribution (In Stock, Low Stock, Out of Stock)
        $inStockCount = DB::table('product_batches')
            ->where('pieces_left', '>', 30)
            ->sum('pieces_left');

        $lowStockTotal = DB::table('product_batches')
            ->where('pieces_left', '>', 0)
            ->where('pieces_left', '<=', 30)
            ->sum('pieces_left');

        $outOfStockTotal = DB::table('product_batches')
            ->where('pieces_left', 0)
            ->sum('pieces_left');

        // Low Stock Products Table (with product details)
        $lowStockProductsTable = DB::table('products')
            ->join('product_batches', 'products.id', '=', 'product_batches.product_id')
            ->select('products.name', 'products.category', DB::raw('SUM(product_batches.pieces_left) as total_stock'))
            ->where('product_batches.pieces_left', '>', 0)
            ->where('product_batches.pieces_left', '<=', 30)
            ->groupBy('products.id', 'products.name', 'products.category')
            ->orderBy('total_stock', 'asc')
            ->limit(20)
            ->get();

        // Out of Stock Products Table
        $outOfStockProductsTable = DB::table('products')
            ->join('product_batches', 'products.id', '=', 'product_batches.product_id')
            ->select('products.name', 'products.category')
            ->where('product_batches.pieces_left', 0)
            ->groupBy('products.id', 'products.name', 'products.category')
            ->limit(20)
            ->get();

        // Expiring Soon Products Table
        $expiringSoonTable = DB::table('products')
            ->join('product_batches', 'products.id', '=', 'product_batches.product_id')
            ->select(
                'products.name',
                'products.category',
                'product_batches.expiry_date',
                DB::raw('DATEDIFF(product_batches.expiry_date, NOW()) as days_left'),
                DB::raw('SUM(product_batches.pieces_left) as total_stock')
            )
            ->where('product_batches.expiry_date', '<=', Carbon::now()->addDays(30))
            ->where('product_batches.expiry_date', '>', Carbon::now())
            ->where('product_batches.pieces_left', '>', 0)
            ->groupBy('products.id', 'products.name', 'products.category', 'product_batches.expiry_date')
            ->orderBy('days_left', 'asc')
            ->limit(20)
            ->get();

        $inventoryStatus = [
            'in_stock' => $inStockCount,
            'low_stock' => $lowStockTotal,
            'out_of_stock' => $outOfStockTotal
        ];

        // ==================== CASHIER DATA ====================
        // DIRECT DB QUERIES - FORCE TO WORK
        $transactionsToday = DB::table('sales')
            ->where('user_id', $cashierId)
            ->whereDate('created_at', $today)
            ->count();

        $salesToday = DB::table('sales')
            ->where('user_id', $cashierId)
            ->whereDate('created_at', $today)
            ->sum('total_amount') ?? 0;

        $itemsSoldToday = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->where('sales.user_id', $cashierId)
            ->whereDate('sales.created_at', $today)
            ->sum('sale_items.quantity') ?? 0;

        // Sales per hour
        $salesPerHourRaw = DB::table('sales')
            ->where('user_id', $cashierId)
            ->whereDate('created_at', $today)
            ->selectRaw('HOUR(created_at) as hour, SUM(total_amount) as total')
            ->groupBy('hour')
            ->orderBy('hour', 'asc')
            ->get();

        $hours = range(8, 20);
        $salesPerHour = [];
        foreach ($hours as $hour) {
            $found = $salesPerHourRaw->firstWhere('hour', $hour);
            $salesPerHour[] = [
                'hour' => $hour,
                'label' => date('g A', mktime($hour, 0, 0)),
                'total' => $found ? (float)$found->total : 0
            ];
        }

        // Top products
        $topProductsRaw = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->join('products', 'sale_items.product_id', '=', 'products.id')
            ->where('sales.user_id', $cashierId)
            ->whereDate('sales.created_at', $today)
            ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_sold'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $topProducts = [];
        foreach ($topProductsRaw as $item) {
            $topProducts[] = (object)[
                'name' => $item->name,
                'total_sold' => $item->total_sold,
            ];
        }

        // Recent transactions (with user relationship)
        $recentTransactions = Sale::with('user')
            ->where('user_id', $cashierId)
            ->whereDate('created_at', $today)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Stock alerts - Low Stock, Expired, Near Expiry (for Cashier) 
        $outOfStockProducts = [];
        $lowStockProducts = [];
        $expiredProducts = [];
        $nearExpiryProducts = [];

        // ========== SLOW MOVING ITEMS for Cashier (last 30 days) ==========
        $thirtyDaysAgo = Carbon::now()->subDays(30);
        $slowMovingItemsCashier = [];

        $cashierSlowMoving = DB::table('products')
            ->leftJoin('sale_items', 'products.id', '=', 'sale_items.product_id')
            ->leftJoin('sales', function ($join) use ($cashierId) {
                $join->on('sale_items.sale_id', '=', 'sales.id')
                    ->where('sales.user_id', '=', $cashierId);
            })
            ->leftJoin('product_batches', 'products.id', '=', 'product_batches.product_id')
            ->select(
                'products.id',
                'products.name',
                'products.category',
                DB::raw('COALESCE(SUM(CASE WHEN sales.created_at >= "' . $thirtyDaysAgo . '" THEN sale_items.quantity ELSE 0 END), 0) as sold_last_30_days'),
                DB::raw('COALESCE(SUM(product_batches.pieces_left), 0) as current_stock')
            )
            ->groupBy('products.id', 'products.name', 'products.category')
            ->having('current_stock', '>', 0)
            ->get();

        foreach ($cashierSlowMoving as $item) {
            $soldLast30Days = $item->sold_last_30_days;
            $currentStock = $item->current_stock;

            $totalAvailable = $soldLast30Days + $currentStock;
            $turnoverRate = $totalAvailable > 0 ? ($soldLast30Days / $totalAvailable) * 100 : 0;

            if ($soldLast30Days == 0) {
                $status = 'No Movement';
                $statusClass = 'danger';
            } elseif ($turnoverRate < 5) {
                $status = 'Slow Moving';
                $statusClass = 'warning';
            } elseif ($turnoverRate > 20) {
                $status = 'Fast Moving';
                $statusClass = 'success';
            } else {
                $status = 'Normal';
                $statusClass = 'info';
            }

            $slowMovingItemsCashier[] = (object)[
                'name' => $item->name,
                'category' => $item->category ?? 'N/A',
                'sold_last_30_days' => $soldLast30Days,
                'current_stock' => $currentStock,
                'turnover_rate' => round($turnoverRate, 1),
                'status' => $status,
                'status_class' => $statusClass
            ];
        }

        $slowMovingItemsCashier = collect($slowMovingItemsCashier)->sortBy('sold_last_30_days')->take(20);

        // ========== ACTIVE PROMOS for Cashier ==========
        $activePromos = DB::table('promos')
            ->join('products', 'promos.product_id', '=', 'products.id')
            ->select(
                'products.name as product_name',
                'products.price as original_price',
                'promos.discount_percent',
                'promos.reason as promo_reason',
                'promos.end_date'
            )
            ->where('promos.is_active', true)
            ->whereDate('promos.start_date', '<=', Carbon::now())
            ->whereDate('promos.end_date', '>=', Carbon::now())
            ->orderBy('promos.end_date', 'asc')
            ->get()
            ->map(function ($item) {
                $item->discounted_price = $item->original_price - (($item->original_price * $item->discount_percent) / 100);
                return $item;
            });

        $products = DB::table('products')->get();

        foreach ($products as $product) {
            // Get all batches for this product
            $batches = DB::table('product_batches')
                ->where('product_id', $product->id)
                ->get();

            foreach ($batches as $batch) {
                $expiryDate = Carbon::parse($batch->expiry_date);
                $daysUntilExpiry = $today->diffInDays($expiryDate, false);
                $piecesLeft = $batch->pieces_left;

                // EXPIRED - expired na at may stock pa
                if ($expiryDate < $today && $piecesLeft > 0) {
                    $expiredProducts[] = (object)[
                        'name' => $product->name,
                        'expiry_date' => $batch->expiry_date,
                        'pieces_left' => $piecesLeft
                    ];
                }
                // NEAR EXPIRY - within 30 days at may stock pa
                elseif ($daysUntilExpiry <= 30 && $daysUntilExpiry >= 0 && $piecesLeft > 0) {
                    $nearExpiryProducts[] = (object)[
                        'name' => $product->name,
                        'expiry_date' => $batch->expiry_date,
                        'days_left' => $daysUntilExpiry,
                        'pieces_left' => $piecesLeft
                    ];
                }
                // LOW STOCK - stock <= 30 pcs
                elseif ($piecesLeft <= 30 && $piecesLeft > 0) {
                    $existing = collect($lowStockProducts)->firstWhere('name', $product->name);
                    if (!$existing) {
                        $lowStockProducts[] = (object)[
                            'name' => $product->name,
                            'pieces_left' => $piecesLeft
                        ];
                    }
                }
                // OUT OF STOCK - zero stock
                elseif ($piecesLeft == 0) {
                    $existing = collect($outOfStockProducts)->firstWhere('name', $product->name);
                    if (!$existing) {
                        $outOfStockProducts[] = (object)[
                            'name' => $product->name,
                            'category' => $product->category ?? 'N/A'
                        ];
                    }
                }
            }
        }

        // ==================== ADMIN DATA (full system) ====================
        if ($userRole === 'Admin') {
            // TOTAL SALES (all users, today)
            $totalSales = DB::table('sales')->whereDate('created_at', $today)->count();
            $totalRevenue = DB::table('sales')->whereDate('created_at', $today)->sum('total_amount') ?? 0;
            $totalTransactions = DB::table('sales')->whereDate('created_at', $today)->count();

            // SALES TREND (Last 7 days - Line Graph)
            $salesTrend = DB::table('sales')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
                ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy('date', 'asc')
                ->get();

            // TOP SELLING PRODUCTS (all users, last 7 days - Bar Chart)
            $topProductsAll = DB::table('sale_items')
                ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
                ->join('products', 'sale_items.product_id', '=', 'products.id')
                ->whereDate('sales.created_at', '>=', Carbon::now()->subDays(7))
                ->select('products.name', DB::raw('SUM(sale_items.quantity) as total_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(10)
                ->get();

            // INVENTORY STATUS DISTRIBUTION (Pie Chart) - using sums
            $inStockSum = DB::table('product_batches')->where('pieces_left', '>', 30)->sum('pieces_left');
            $lowStockSum = DB::table('product_batches')->where('pieces_left', '>', 0)->where('pieces_left', '<=', 30)->sum('pieces_left');
            $outOfStockSum = DB::table('product_batches')->where('pieces_left', 0)->sum('pieces_left');

            $inventoryStatusAdmin = [
                'in_stock' => $inStockSum,
                'low_stock' => $lowStockSum,
                'out_of_stock' => $outOfStockSum
            ];

            // PEAK SALES HOURS (all users - Line Graph)
            $peakHours = DB::table('sales')
                ->selectRaw('HOUR(created_at) as hour, SUM(total_amount) as total')
                ->whereDate('created_at', $today)
                ->groupBy('hour')
                ->orderBy('hour', 'asc')
                ->get();

            $peakHoursData = [];
            foreach ($hours as $hour) {
                $found = $peakHours->firstWhere('hour', $hour);
                $peakHoursData[] = [
                    'hour' => $hour,
                    'label' => date('g A', mktime($hour, 0, 0)),
                    'total' => $found ? (float)$found->total : 0
                ];
            }

            // RECENT TRANSACTIONS (all users)
            $recentTransactionsAll = Sale::with('user')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            // LOW STOCK PRODUCTS LIST (for Admin table)
            $lowStockProductsList = DB::table('products')
                ->join('product_batches', 'products.id', '=', 'product_batches.product_id')
                ->select('products.name', 'products.category', DB::raw('SUM(product_batches.pieces_left) as total_stock'))
                ->where('product_batches.pieces_left', '>', 0)
                ->where('product_batches.pieces_left', '<=', 30)
                ->groupBy('products.id', 'products.name', 'products.category')
                ->orderBy('total_stock', 'asc')
                ->limit(20)
                ->get();

            // OUT OF STOCK PRODUCTS LIST (for Admin table)
            $outOfStockList = DB::table('products')
                ->join('product_batches', 'products.id', '=', 'product_batches.product_id')
                ->select('products.name', 'products.category')
                ->where('product_batches.pieces_left', 0)
                ->groupBy('products.id', 'products.name', 'products.category')
                ->limit(20)
                ->get();

            // EXPIRING SOON LIST (for Admin table)
            $expiringSoonList = DB::table('products')
                ->join('product_batches', 'products.id', '=', 'product_batches.product_id')
                ->select(
                    'products.name',
                    'products.category',
                    'product_batches.expiry_date',
                    DB::raw('DATEDIFF(product_batches.expiry_date, NOW()) as days_left'),
                    DB::raw('SUM(product_batches.pieces_left) as total_stock')
                )
                ->where('product_batches.expiry_date', '<=', Carbon::now()->addDays(30))
                ->where('product_batches.expiry_date', '>', Carbon::now())
                ->where('product_batches.pieces_left', '>', 0)
                ->groupBy('products.id', 'products.name', 'products.category', 'product_batches.expiry_date')
                ->orderBy('days_left', 'asc')
                ->limit(20)
                ->get();
        }

        // ==================== DATA ARRAY ====================
        $data = [
            'userRole' => $userRole,
            // Cashier Data
            'transactionsToday' => $transactionsToday,
            'salesToday' => $salesToday,
            'itemsSoldToday' => $itemsSoldToday,
            'salesPerHour' => $salesPerHour,
            'topProducts' => $topProducts,
            'recentTransactions' => $recentTransactions,
            'outOfStockProducts' => collect($outOfStockProducts)->take(10),
            'lowStockProducts' => collect($lowStockProducts)->take(10),
            'expiredProducts' => collect($expiredProducts)->take(10),
            'nearExpiryProducts' => collect($nearExpiryProducts)->take(10),
            'slowMovingItemsCashier' => $slowMovingItemsCashier,
            'activePromos' => $activePromos,
            // Pharmacy Assistant Data
            'totalProducts' => $totalProducts,
            'lowStockCount' => $lowStockCount,
            'nearExpiryCount' => $nearExpiryCount,
            'outOfStockCount' => $outOfStockCount,
            'stockLevels' => $stockLevels,
            'inStockCount' => $inStockCount,
            'lowStockTotal' => $lowStockTotal,
            'outOfStockTotal' => $outOfStockTotal,
            'lowStockProductsTable' => $lowStockProductsTable,
            'outOfStockProductsTable' => $outOfStockProductsTable,
            'expiringSoonTable' => $expiringSoonTable,
            'inventoryStatus' => $inventoryStatus,
        ];

        // Add admin data if role is Admin
        if ($userRole === 'Admin') {
            $data['totalSales'] = $totalSales ?? 0;
            $data['totalRevenue'] = $totalRevenue ?? 0;
            $data['totalTransactions'] = $totalTransactions ?? 0;
            $data['salesTrend'] = $salesTrend ?? collect();
            $data['topProductsAll'] = $topProductsAll ?? collect();
            $data['inventoryStatus'] = $inventoryStatusAdmin ?? ['in_stock' => 0, 'low_stock' => 0, 'out_of_stock' => 0];
            $data['peakHoursData'] = $peakHoursData ?? [];
            $data['recentTransactionsAll'] = $recentTransactionsAll ?? collect();
            $data['lowStockProductsList'] = $lowStockProductsList ?? collect();
            $data['outOfStockList'] = $outOfStockList ?? collect();
            $data['expiringSoonList'] = $expiringSoonList ?? collect();
        }

        return view('dashboard', $data);
    }
}
