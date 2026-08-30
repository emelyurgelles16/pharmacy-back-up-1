@extends('layouts.app')

@section('content')
<style>
    /* ========== DASHBOARD TOPBAR ========== */
    .dashboard-topbar {
        background: white;
        padding: 20px 30px;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        border: 1px solid #f0f0f0;
    }

    .dashboard-topbar-left h1 {
        color: #056b28;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .dashboard-topbar-left h1 i {
        color: #0b7a33;
        background: #e8f5e9;
        padding: 10px;
        border-radius: 12px;
        font-size: 20px;
    }

    .dashboard-date {
        font-size: 14px;
        color: #6c757d;
        margin-top: 4px;
    }

    .dashboard-date i {
        margin-right: 6px;
        color: #0b7a33;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8f9fa;
        padding: 6px 18px 6px 6px;
        border-radius: 50px;
        border: 1px solid #e9ecef;
    }

    .user-initial {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, #1b5e20, #2e7d32);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-weight: 700;
        font-size: 16px;
    }

    .user-photo {
        width: 42px;
        height: 42px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #1b5e20;
    }

    .username {
        font-weight: 600;
        font-size: 15px;
        color: #333;
    }

    .role-badge {
        font-size: 11px;
        color: #fff;
        background: #0b7a33;
        padding: 2px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    /* ========== STATS CARDS ========== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px 22px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border-left: 4px solid #1b5e20;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    .stat-card::after {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(27, 94, 32, 0.03);
        pointer-events: none;
    }

    .stat-card .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .stat-card .stat-icon.green {
        background: #e8f5e9;
        color: #1b5e20;
    }
    .stat-card .stat-icon.blue {
        background: #e3f2fd;
        color: #1565c0;
    }
    .stat-card .stat-icon.orange {
        background: #fff3e0;
        color: #e65100;
    }
    .stat-card .stat-icon.red {
        background: #ffebee;
        color: #c62828;
    }
    .stat-card .stat-icon.purple {
        background: #f3e5f5;
        color: #6a1b9a;
    }
    .stat-card .stat-icon.teal {
        background: #e0f2f1;
        color: #00695c;
    }

    .stat-card .stat-info h3 {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 4px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-card .stat-info .value {
        font-size: 26px;
        font-weight: 700;
        color: #2c3e50;
        margin: 0;
        line-height: 1.2;
    }

    .stat-card .stat-info .value .currency {
        font-size: 16px;
        color: #6c757d;
        font-weight: 500;
    }

    /* ========== CHART BOXES ========== */
    .charts-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 25px;
        margin-bottom: 30px;
    }

    .charts-row-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
        margin-bottom: 30px;
    }

    .chart-box {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
    }

    .chart-box:hover {
        box-shadow: 0 6px 25px rgba(0,0,0,0.08);
    }

    .chart-title {
        font-size: 15px;
        font-weight: 600;
        color: #1b5e20;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 2px solid #f0f0f0;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .chart-title i {
        color: #0b7a33;
        font-size: 18px;
    }

    .chart-title .badge-count {
        background: #e8f5e9;
        color: #1b5e20;
        font-size: 11px;
        padding: 2px 10px;
        border-radius: 20px;
        font-weight: 500;
        margin-left: auto;
    }

    /* ========== TABLES ========== */
    .tables-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        align-items: start;
    }

    .tables-row-3 {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        align-items: start;
        margin-top: 20px;
    }

    .table-box {
        background: white;
        border-radius: 16px;
        padding: 18px;
        box-shadow: 0 2px 12px rgba(0,0,0,0.05);
        border: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        height: 420px;
    }

    .table-box:hover {
        box-shadow: 0 6px 25px rgba(0,0,0,0.08);
    }

    .table-scroll {
        flex: 1;
        overflow-y: auto;
        min-height: 0;
    }

    .table-scroll::-webkit-scrollbar {
        width: 4px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background: #1b5e20;
        border-radius: 10px;
    }

    .table-scroll table {
        width: 100%;
        font-size: 13px;
        border-collapse: collapse;
    }

    .table-scroll th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        padding: 10px 10px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #495057;
        border-bottom: 2px solid #e9ecef;
        text-align: left;
    }

    .table-scroll td {
        padding: 10px 10px;
        font-size: 13px;
        border-bottom: 1px solid #f5f5f5;
        vertical-align: middle;
    }

    .table-scroll tbody tr {
        transition: background 0.2s ease;
    }

    .table-scroll tbody tr:hover {
        background: #f8fdf8 !important;
    }

    /* ========== BADGES ========== */
    .badge-out { background: #e53935; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .badge-low { background: #ff9800; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .badge-expired { background: #d32f2f; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .badge-near { background: #ff9800; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .badge-available { background: #e8f5e9; color: #2e7d32; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }
    .badge-promo { background: #9c27b0; color: white; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 500; }

    /* ========== EMPTY STATE ========== */
    .empty-state {
        text-align: center;
        color: #adb5bd;
        padding: 30px 20px;
    }

    .empty-state i {
        font-size: 36px;
        margin-bottom: 10px;
        opacity: 0.5;
    }

    .empty-state p {
        margin: 0;
        font-size: 14px;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 1200px) {
        .charts-row-3 { grid-template-columns: 1fr 1fr; }
        .tables-row-3 { grid-template-columns: 1fr 1fr; }
    }

    @media (max-width: 992px) {
        .charts-row { grid-template-columns: 1fr; }
        .tables-row { grid-template-columns: 1fr; }
        .charts-row-3 { grid-template-columns: 1fr; }
        .tables-row-3 { grid-template-columns: 1fr; }
        .table-box { height: 350px; }
    }

    @media (max-width: 768px) {
        .dashboard-topbar { padding: 15px; flex-direction: column; align-items: stretch; }
        .dashboard-topbar-left h1 { font-size: 20px; }
        .user-info { padding: 4px 12px 4px 4px; }
        .stats-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
        .stat-card { padding: 15px; }
        .stat-card .stat-info .value { font-size: 20px; }
        .stat-card .stat-icon { width: 40px; height: 40px; font-size: 18px; }
    }

    @media (max-width: 480px) {
        .stats-grid { grid-template-columns: 1fr; }
        .stat-card .stat-info .value { font-size: 18px; }
    }
</style>

{{-- ============================================================ --}}
{{-- DASHBOARD TOPBAR --}}
{{-- ============================================================ --}}
<div class="dashboard-topbar">
    <div class="dashboard-topbar-left">
        <h1>
            <i class="fas fa-chalkboard-user"></i> 
            Dashboard
        </h1>
            <span style="margin: 0 8px; color: #ddd;"></span>

    </div>
</div>

{{-- ============================================================ --}}
{{-- CASHIER DASHBOARD --}}
{{-- ============================================================ --}}
@if($userRole === 'Cashier')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-receipt"></i></div>
        <div class="stat-info">
            <h3>Transactions Today</h3>
            <div class="value">{{ $transactionsToday ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <h3>Total Sales Today</h3>
            <div class="value"><span class="currency">₱</span>{{ number_format($salesToday ?? 0, 2) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-cubes"></i></div>
        <div class="stat-info">
            <h3>Items Sold Today</h3>
            <div class="value">{{ number_format($itemsSoldToday ?? 0) }} <span style="font-size:14px;font-weight:400;color:#6c757d;">pcs</span></div>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-line"></i> Sales Per Hour (Today)
            <span class="badge-count">{{ now()->format('M d, Y') }}</span>
        </div>
        <div style="height: 260px;">
            <canvas id="salesPerHourChart"></canvas>
        </div>
    </div>
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-simple"></i> Top Selling Products (Today)
        </div>
        <div style="height: 260px;">
            <canvas id="topProductsChart"></canvas>
        </div>
    </div>
</div>

{{-- Active Promos --}}
<div class="table-box" style="height: auto; min-height: 200px; margin-bottom: 20px;">
    <div class="chart-title">
        <i class="fas fa-tags" style="color:#9c27b0;"></i> Active Promos & Discounts
        <span class="badge-count">{{ isset($activePromos) ? $activePromos->count() : 0 }}</span>
    </div>
    <div class="table-scroll" style="max-height: 180px;">
        @if(isset($activePromos) && $activePromos->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Original</th>
                    <th>Discount</th>
                    <th>Discounted</th>
                    <th>Valid Until</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activePromos as $promo)
                <tr style="background: #faf5ff;">
                    <td>
                        {{ $promo->product_name }}
                        @if($promo->promo_reason)
                        <br><small style="color:#6c757d;font-size:11px;">{{ $promo->promo_reason }}</small>
                        @endif
                    </td>
                    <td>₱{{ number_format($promo->original_price, 2) }}</td>
                    <td><span class="badge-promo">{{ $promo->discount_percent }}% OFF</span></td>
                    <td><strong style="color:#1b5e20;">₱{{ number_format($promo->discounted_price, 2) }}</strong></td>
                    <td style="font-size:12px;">
                        @php
                            $validUntil = \Carbon\Carbon::parse($promo->end_date);
                            $daysLeft = $validUntil->diffInDays(now(), false);
                        @endphp
                        {{ $validUntil->format('M d, Y') }}
                        @if($validUntil->isFuture() && $daysLeft <= 3 && $daysLeft > 0)
                            <br><small style="color:#e53935;">⚠️ {{ $daysLeft }} days left</small>
                        @elseif($validUntil->isPast())
                            <br><small style="color:#6c757d;">Expired</small>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-tag"></i>
            <p>No active promos at the moment</p>
        </div>
        @endif
    </div>
</div>

{{-- Tables Row --}}
<div class="tables-row">
    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-clock-rotate-left"></i> Recent Transactions
            <span class="badge-count">{{ isset($recentTransactions) ? count($recentTransactions) : 0 }}</span>
        </div>
        <div class="table-scroll">
            @if(isset($recentTransactions) && count($recentTransactions) > 0)
            <table>
                <thead>
                    <tr><th>Invoice #</th><th>Date & Time</th><th>Total</th><th>Cashier</th></tr>
                </thead>
                <tbody>
                    @foreach($recentTransactions as $transaction)
                    <tr>
                        <td><strong>{{ $transaction->invoice_no }}</strong></td>
                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y h:i A') }}</td>
                        <td style="color:#1b5e20;font-weight:700;">₱{{ number_format($transaction->total_amount, 2) }}</td>
                        <td>{{ $transaction->user->username ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-receipt"></i>
                <p>No transactions today</p>
            </div>
            @endif
        </div>
    </div>

    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-exclamation-triangle" style="color:#e53935;"></i> Out of Stock Alerts
            <span class="badge-count">{{ isset($outOfStockProducts) ? $outOfStockProducts->count() : 0 }}</span>
        </div>
        <div class="table-scroll">
            @if(isset($outOfStockProducts) && $outOfStockProducts->count() > 0)
            <table>
                <thead>
                    <tr><th>Product</th><th>Category</th><th>Stock</th></tr>
                </thead>
                <tbody>
                    @foreach($outOfStockProducts as $product)
                    <tr style="background:#ffebee;">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ?? 'N/A' }}</td>
                        <td><span class="badge-out">0 pcs</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-check-circle" style="color:#4caf50;"></i>
                <p style="color:#4caf50;">No out of stock products</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="tables-row" style="margin-top:20px;">
    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-turtle" style="color:#ff9800;"></i> Slow Moving Items (Your Sales - 30 Days)
        </div>
        <div class="table-scroll">
            @if(isset($slowMovingItemsCashier) && count($slowMovingItemsCashier) > 0)
            <table>
                <thead>
                    <tr><th>Product</th><th>Sold</th><th>Stock</th><th>Turnover</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($slowMovingItemsCashier as $item)
                    <tr style="background: {{ $item->status_class == 'danger' ? '#ffebee' : ($item->status_class == 'warning' ? '#fff3e0' : 'white') }};">
                        <td>{{ $item->name }}</td>
                        <td>{{ number_format($item->sold_last_30_days) }} pcs</td>
                        <td>{{ number_format($item->current_stock) }} pcs</td>
                        <td>{{ $item->turnover_rate }}%</td>
                        <td>
                            @if($item->status_class == 'danger')
                                <span class="badge-out">Critical</span>
                            @elseif($item->status_class == 'warning')
                                <span class="badge-low">Slow</span>
                            @else
                                <span class="badge-available">Normal</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-chart-line"></i>
                <p>No slow moving items data available</p>
            </div>
            @endif
        </div>
    </div>

    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-exclamation-triangle" style="color:#ff9800;"></i> Low Stock Alerts (≤30 pcs)
        </div>
        <div class="table-scroll">
            @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
            <table>
                <thead>
                    <tr><th>Product</th><th>Stock Left</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($lowStockProducts as $product)
                    <tr style="background:#fff3e0;">
                        <td>{{ $product->name }}</td>
                        <td style="color:#e65100;font-weight:700;">{{ $product->pieces_left }} pcs</td>
                        <td><span class="badge-low">⚠️ Low Stock</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state">
                <i class="fas fa-check-circle" style="color:#4caf50;"></i>
                <p style="color:#4caf50;">No low stock products</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="table-box" style="margin-top:20px;">
    <div class="chart-title">
        <i class="fas fa-skull-crossbones" style="color:#d32f2f;"></i> Expired Products
        <span class="badge-count">{{ isset($expiredProducts) ? $expiredProducts->count() : 0 }}</span>
    </div>
    <div class="table-scroll" style="max-height:200px;">
        @if(isset($expiredProducts) && $expiredProducts->count() > 0)
        <table>
            <thead>
                <tr><th>Product</th><th>Expiry Date</th><th>Stock Left</th><th>Status</th></tr>
            </thead>
            <tbody>
                @foreach($expiredProducts as $product)
                <tr style="background:#ffebee;">
                    <td>{{ $product->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($product->expiry_date)->format('M d, Y') }}</td>
                    <td>{{ $product->pieces_left }} pcs</td>
                    <td><span class="badge-expired">❌ EXPIRED</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state">
            <i class="fas fa-check-circle" style="color:#4caf50;"></i>
            <p style="color:#4caf50;">No expired products</p>
        </div>
        @endif
    </div>
</div>

@endif
{{-- ==================== END CASHIER ==================== --}}

{{-- ============================================================ --}}
{{-- PHARMACY ASSISTANT DASHBOARD --}}
{{-- ============================================================ --}}
@if($userRole === 'Pharmacy Assistant')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-capsules"></i></div>
        <div class="stat-info">
            <h3>Total Products</h3>
            <div class="value">{{ $totalProducts ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="stat-info">
            <h3>Low Stock (≤30 pcs)</h3>
            <div class="value" style="color:#e65100;">{{ $lowStockCount ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-calendar-week"></i></div>
        <div class="stat-info">
            <h3>Near Expiry (≤30 days)</h3>
            <div class="value" style="color:#c62828;">{{ $nearExpiryCount ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-ban"></i></div>
        <div class="stat-info">
            <h3>Out of Stock</h3>
            <div class="value" style="color:#c62828;">{{ $outOfStockCount ?? 0 }}</div>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-bar"></i> Stock Levels per Product (Top 10)
        </div>
        <div style="height: 260px;">
            <canvas id="stockLevelsChart"></canvas>
        </div>
    </div>
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-pie"></i> Inventory Status
        </div>
        <div style="height: 260px;">
            <canvas id="inventoryStatusChart"></canvas>
        </div>
    </div>
</div>

<div class="tables-row">
    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-exclamation-triangle" style="color:#ff9800;"></i> Low Stock List
        </div>
        <div class="table-scroll">
            @if(isset($lowStockProductsTable) && $lowStockProductsTable->count() > 0)
            <table>
                <thead><tr><th>Product</th><th>Category</th><th>Stock</th></tr></thead>
                <tbody>
                    @foreach($lowStockProductsTable as $product)
                    <tr style="background:#fff3e0;">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ?? 'N/A' }}</td>
                        <td style="color:#e65100;font-weight:700;">{{ $product->total_stock }} pcs</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-check-circle" style="color:#4caf50;"></i><p style="color:#4caf50;">No low stock products</p></div>
            @endif
        </div>
    </div>

    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-times-circle" style="color:#d32f2f;"></i> Out of Stock List
        </div>
        <div class="table-scroll">
            @if(isset($outOfStockProductsTable) && $outOfStockProductsTable->count() > 0)
            <table>
                <thead><tr><th>Product</th><th>Category</th></tr></thead>
                <tbody>
                    @foreach($outOfStockProductsTable as $product)
                    <tr style="background:#ffebee;">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-check-circle" style="color:#4caf50;"></i><p style="color:#4caf50;">No out of stock products</p></div>
            @endif
        </div>
    </div>
</div>

<div class="table-box" style="margin-top:20px;">
    <div class="chart-title">
        <i class="fas fa-hourglass-half" style="color:#ff9800;"></i> Expiring Soon List (≤30 days)
    </div>
    <div class="table-scroll" style="max-height:200px;">
        @if(isset($expiringSoonTable) && $expiringSoonTable->count() > 0)
        <table>
            <thead><tr><th>Product</th><th>Category</th><th>Expiry Date</th><th>Days Left</th></tr></thead>
            <tbody>
                @foreach($expiringSoonTable as $product)
                <tr style="background:#fff3e0;">
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($product->expiry_date)->format('M d, Y') }}</td>
                    <td style="color:#e65100;font-weight:700;">{{ $product->days_left }} days</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state"><i class="fas fa-check-circle" style="color:#4caf50;"></i><p style="color:#4caf50;">No expiring products</p></div>
        @endif
    </div>
</div>

@endif
{{-- ==================== END PHARMACY ASSISTANT ==================== --}}

{{-- ============================================================ --}}
{{-- ADMIN DASHBOARD --}}
{{-- ============================================================ --}}
@if($userRole === 'Admin')

<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(170px, 1fr));">
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-chart-line"></i></div>
        <div class="stat-info">
            <h3>Total Sales (Today)</h3>
            <div class="value">{{ $totalSales ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-money-bill-wave"></i></div>
        <div class="stat-info">
            <h3>Total Revenue</h3>
            <div class="value"><span class="currency">₱</span>{{ number_format($totalRevenue ?? 0, 2) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon purple"><i class="fas fa-receipt"></i></div>
        <div class="stat-info">
            <h3>Transactions</h3>
            <div class="value">{{ $totalTransactions ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-capsules"></i></div>
        <div class="stat-info">
            <h3>Total Products</h3>
            <div class="value">{{ $totalProducts ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="stat-info">
            <h3>Low Stock</h3>
            <div class="value" style="color:#e65100;">{{ $lowStockCount ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon red"><i class="fas fa-ban"></i></div>
        <div class="stat-info">
            <h3>Out of Stock</h3>
            <div class="value" style="color:#c62828;">{{ $outOfStockCount ?? 0 }}</div>
        </div>
    </div>
</div>

<div class="charts-row-3">
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-line"></i> Sales Trend (Last 7 Days)
        </div>
        <div style="height: 220px;">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-simple"></i> Top Selling Products
        </div>
        <div style="height: 220px;">
            <canvas id="topProductsAllChart"></canvas>
        </div>
    </div>
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-pie"></i> Inventory Status
        </div>
        <div style="height: 220px;">
            <canvas id="inventoryStatusPieChart"></canvas>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-clock"></i> Peak Sales Hours (Today)
        </div>
        <div style="height: 220px;">
            <canvas id="peakHoursChart"></canvas>
        </div>
    </div>
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-clock-rotate-left"></i> Recent Transactions
            <span class="badge-count">{{ isset($recentTransactionsAll) ? $recentTransactionsAll->count() : 0 }}</span>
        </div>
        <div class="table-scroll" style="max-height: 220px;">
            @if(isset($recentTransactionsAll) && $recentTransactionsAll->count() > 0)
            <table>
                <thead><tr><th>Invoice #</th><th>Cashier</th><th>Time</th><th>Total</th></tr></thead>
                <tbody>
                    @foreach($recentTransactionsAll as $transaction)
                    <tr>
                        <td><strong>{{ $transaction->invoice_no }}</strong></td>
                        <td>{{ $transaction->user->username ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('h:i A') }}</td>
                        <td style="color:#1b5e20;font-weight:700;">₱{{ number_format($transaction->total_amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-receipt"></i><p>No transactions</p></div>
            @endif
        </div>
    </div>
</div>

<div class="tables-row-3">
    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-exclamation-triangle" style="color:#ff9800;"></i> Low Stock Products
        </div>
        <div class="table-scroll">
            @if(isset($lowStockProductsList) && $lowStockProductsList->count() > 0)
            <table>
                <thead><tr><th>Product</th><th>Category</th><th>Stock</th></tr></thead>
                <tbody>
                    @foreach($lowStockProductsList as $product)
                    <tr style="background:#fff3e0;">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ?? 'N/A' }}</td>
                        <td style="color:#e65100;font-weight:700;">{{ $product->total_stock }} pcs</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-check-circle" style="color:#4caf50;"></i><p style="color:#4caf50;">No low stock products</p></div>
            @endif
        </div>
    </div>

    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-times-circle" style="color:#d32f2f;"></i> Out of Stock Products
        </div>
        <div class="table-scroll">
            @if(isset($outOfStockList) && $outOfStockList->count() > 0)
            <table>
                <thead><tr><th>Product</th><th>Category</th></tr></thead>
                <tbody>
                    @foreach($outOfStockList as $product)
                    <tr style="background:#ffebee;">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-check-circle" style="color:#4caf50;"></i><p style="color:#4caf50;">No out of stock products</p></div>
            @endif
        </div>
    </div>

    <div class="table-box">
        <div class="chart-title">
            <i class="fas fa-hourglass-half" style="color:#ff9800;"></i> Expiring Soon (≤30 days)
        </div>
        <div class="table-scroll">
            @if(isset($expiringSoonList) && $expiringSoonList->count() > 0)
            <table>
                <thead><tr><th>Product</th><th>Category</th><th>Expiry</th><th>Days</th><th>Stock</th></tr></thead>
                <tbody>
                    @foreach($expiringSoonList as $product)
                    <tr style="background:#fff3e0;">
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($product->expiry_date)->format('M d, Y') }}</td>
                        <td style="color:#e65100;font-weight:700;">{{ $product->days_left }}</td>
                        <td>{{ $product->total_stock }} pcs</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div class="empty-state"><i class="fas fa-check-circle" style="color:#4caf50;"></i><p style="color:#4caf50;">No expiring products</p></div>
            @endif
        </div>
    </div>
</div>

@endif
{{-- ==================== END ADMIN ==================== --}}

{{-- ============================================================ --}}
{{-- PHARMACIST DASHBOARD --}}
{{-- ============================================================ --}}
@if($userRole === 'Pharmacist')

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue"><i class="fas fa-chart-line"></i></div>
        <div class="stat-info">
            <h3>Total Sales Today</h3>
            <div class="value"><span class="currency">₱</span>{{ number_format($salesToday ?? 0, 2) }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-receipt"></i></div>
        <div class="stat-info">
            <h3>Transactions Today</h3>
            <div class="value">{{ $transactionsToday ?? 0 }}</div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon orange"><i class="fas fa-cubes"></i></div>
        <div class="stat-info">
            <h3>Items Sold Today</h3>
            <div class="value">{{ number_format($itemsSoldToday ?? 0) }} <span style="font-size:14px;font-weight:400;color:#6c757d;">pcs</span></div>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon green"><i class="fas fa-capsules"></i></div>
        <div class="stat-info">
            <h3>Total Products</h3>
            <div class="value">{{ $totalProducts ?? 0 }}</div>
        </div>
    </div>
</div>

<div class="charts-row">
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-bar"></i> Stock Levels per Product (Top 10)
        </div>
        <div style="height: 260px;">
            <canvas id="stockLevelsChart"></canvas>
        </div>
    </div>
    <div class="chart-box">
        <div class="chart-title">
            <i class="fas fa-chart-pie"></i> Inventory Status
        </div>
        <div style="height: 260px;">
            <canvas id="inventoryStatusChart"></canvas>
        </div>
    </div>
</div>

<div class="table-box" style="margin-top:20px; height:400px;">
    <div class="chart-title">
        <i class="fas fa-clock-rotate-left"></i> Recent Transactions
        <span class="badge-count">{{ isset($recentTransactions) ? $recentTransactions->count() : 0 }}</span>
    </div>
    <div class="table-scroll">
        @if(isset($recentTransactions) && $recentTransactions->count() > 0)
        <table>
            <thead><tr><th>Invoice #</th><th>Date & Time</th><th>Cashier</th><th>Total</th></tr></thead>
            <tbody>
                @foreach($recentTransactions as $transaction)
                <tr>
                    <td><strong>{{ $transaction->invoice_no }}</strong></td>
                    <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('M d, Y h:i A') }}</td>
                    <td>{{ $transaction->user->username ?? 'N/A' }}</td>
                    <td style="color:#1b5e20;font-weight:700;">₱{{ number_format($transaction->total_amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="empty-state"><i class="fas fa-receipt"></i><p>No transactions found</p></div>
        @endif
    </div>
</div>

@endif
{{-- ==================== END PHARMACIST ==================== --}}

{{-- ============================================================ --}}
{{-- SCRIPTS --}}
{{-- ============================================================ --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== Sales Per Hour Chart (Cashier) =====
    const salesData = @json($salesPerHour ?? []);
    const hours = salesData.map(s => s.label);
    const salesValues = salesData.map(s => s.total);
    
    if (document.getElementById('salesPerHourChart')) {
        new Chart(document.getElementById('salesPerHourChart'), {
            type: 'line',
            data: {
                labels: hours.length ? hours : ['No Data'],
                datasets: [{
                    label: 'Sales (₱)',
                    data: salesValues.length ? salesValues : [0],
                    borderColor: '#1b5e20',
                    backgroundColor: 'rgba(27, 94, 32, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#1b5e20',
                    pointBorderColor: '#fff',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { callbacks: { label: (ctx) => `₱${ctx.raw.toFixed(2)}` } }
                },
                scales: { y: { beginAtZero: true, ticks: { callback: (val) => '₱' + val } } }
            }
        });
    }

    // ===== Top Products Chart (Cashier) =====
    const topProducts = @json($topProducts ?? []);
    const productNames = topProducts.map(p => p.name.length > 18 ? p.name.substring(0, 18) + '...' : p.name);
    const productSold = topProducts.map(p => p.total_sold);
    
    if (document.getElementById('topProductsChart')) {
        new Chart(document.getElementById('topProductsChart'), {
            type: 'bar',
            data: {
                labels: productNames.length ? productNames : ['No Data'],
                datasets: [{
                    label: 'Quantity Sold',
                    data: productSold.length ? productSold : [0],
                    backgroundColor: '#ff9800',
                    borderRadius: 8,
                    barPercentage: 0.7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top' },
                    tooltip: { callables: { label: (ctx) => `${ctx.raw} pcs sold` } }
                },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }

    // ===== Stock Levels Chart (PA & Pharmacist) =====
    const stockLevelsData = @json($stockLevels ?? []);
    if (document.getElementById('stockLevelsChart') && stockLevelsData.length) {
        const stockNames = stockLevelsData.map(s => s.name.length > 15 ? s.name.substring(0, 12) + '...' : s.name);
        const stockValues = stockLevelsData.map(s => s.total_stock);
        
        new Chart(document.getElementById('stockLevelsChart'), {
            type: 'bar',
            data: {
                labels: stockNames,
                datasets: [{
                    label: 'Stock Quantity (pcs)',
                    data: stockValues,
                    backgroundColor: '#ff9800',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }

    // ===== Inventory Status Pie Chart (PA & Pharmacist) =====
    const inventoryStatus = @json($inventoryStatus ?? ['in_stock' => 0, 'low_stock' => 0, 'out_of_stock' => 0]);
    if (document.getElementById('inventoryStatusChart')) {
        new Chart(document.getElementById('inventoryStatusChart'), {
            type: 'pie',
            data: {
                labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    data: [inventoryStatus.in_stock, inventoryStatus.low_stock, inventoryStatus.out_of_stock],
                    backgroundColor: ['#2e7d32', '#ff9800', '#d32f2f'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // ===== Admin: Sales Trend Chart =====
    const salesTrend = @json($salesTrend ?? []);
    if (document.getElementById('salesTrendChart') && salesTrend.length) {
        new Chart(document.getElementById('salesTrendChart'), {
            type: 'line',
            data: {
                labels: salesTrend.map(s => s.date),
                datasets: [{
                    label: 'Sales (₱)',
                    data: salesTrend.map(s => s.total),
                    borderColor: '#1b5e20',
                    backgroundColor: 'rgba(27, 94, 32, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#1b5e20'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { callback: (val) => '₱' + val } } }
            }
        });
    }

    // ===== Admin: Top Selling Products Chart =====
    const topProductsAll = @json($topProductsAll ?? []);
    if (document.getElementById('topProductsAllChart') && topProductsAll.length) {
        const names = topProductsAll.map(p => p.name.length > 15 ? p.name.substring(0, 12) + '...' : p.name);
        new Chart(document.getElementById('topProductsAllChart'), {
            type: 'bar',
            data: {
                labels: names,
                datasets: [{
                    label: 'Quantity Sold',
                    data: topProductsAll.map(p => p.total_sold),
                    backgroundColor: '#ff9800',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }

    // ===== Admin: Inventory Status Pie Chart =====
    if (document.getElementById('inventoryStatusPieChart')) {
        new Chart(document.getElementById('inventoryStatusPieChart'), {
            type: 'pie',
            data: {
                labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    data: [inventoryStatus.in_stock, inventoryStatus.low_stock, inventoryStatus.out_of_stock],
                    backgroundColor: ['#2e7d32', '#ff9800', '#d32f2f'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    }

    // ===== Admin: Peak Sales Hours Chart =====
    const peakHoursData = @json($peakHoursData ?? []);
    if (document.getElementById('peakHoursChart') && peakHoursData.length) {
        new Chart(document.getElementById('peakHoursChart'), {
            type: 'line',
            data: {
                labels: peakHoursData.map(h => h.label),
                datasets: [{
                    label: 'Sales (₱)',
                    data: peakHoursData.map(h => h.total),
                    borderColor: '#1b5e20',
                    backgroundColor: 'rgba(27, 94, 32, 0.1)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#1b5e20'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: { legend: { position: 'top' } },
                scales: { y: { beginAtZero: true, ticks: { callback: (val) => '₱' + val } } }
            }
        });
    }

    // ===== WELCOME ALERT =====
    @if(session('show_welcome_alert', true))
        @php
            session(['show_welcome_alert' => false]);
        @endphp
        
        Swal.fire({
            icon: 'success',
            title: 'Welcome back, {{ auth()->user()->username ?? 'User' }}! 👋',
            html: `
                <div style="text-align: left; padding: 10px 0;">
                    <p style="font-size: 16px; color: #333; margin-bottom: 8px;">
                        <i class="fas fa-check-circle" style="color: #28a745; margin-right: 8px;"></i>
                        You have successfully logged in to <strong>Pharmacy System</strong>.
                    </p>
                    <p style="font-size: 14px; color: #666; margin-bottom: 5px;">
                        <i class="fas fa-user-tag" style="color: #0b8f66; margin-right: 8px;"></i>
                        Role: <strong>{{ ucfirst($userRole ?? 'User') }}</strong>
                    </p>
                    <p style="font-size: 14px; color: #666; margin-bottom: 5px;">
                        <i class="fas fa-clock" style="color: #ff9800; margin-right: 8px;"></i>
                        Logged in: {{ now()->format('F d, Y h:i A') }}
                    </p>
                    <hr style="margin: 12px 0; border-color: #e9ecef;">
                    <p style="font-size: 13px; color: #999; text-align: center; margin: 0;">
                        <i class="fas fa-info-circle"></i> You are now viewing your personalized dashboard.
                    </p>
                </div>
            `,
            confirmButtonText: '👌 Got it!',
            confirmButtonColor: '#0b8f66',
            background: 'rgba(255,255,255,0.95)',
            backdrop: 'rgba(0,0,0,0.3)',
            timer: 15000,
            timerProgressBar: true
        });
    @endif
});
</script>

@endsection