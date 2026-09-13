@extends('layouts.app')

@section('title', 'Sales & Reports')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - SALES & REPORTS
       ============================================ */

    /* ===== COMPACT STAT CARDS ===== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        margin-bottom: 25px;
    }

    .stat-compact {
        background: white;
        border-radius: 10px;
        padding: 15px 10px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border-top: 3px solid #0b7a33;
        transition: all 0.3s ease;
    }

    .stat-compact:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    }

    .stat-compact .stat-label {
        font-size: 11px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 5px;
        white-space: nowrap;
    }

    .stat-compact .stat-value {
        font-size: 22px;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .stat-compact.border-sales { border-top-color: #0b7a33; }
    .stat-compact.border-sales .stat-value { color: #0b7a33; }

    .stat-compact.border-trans { border-top-color: #1565c0; }
    .stat-compact.border-trans .stat-value { color: #1565c0; }

    .stat-compact.border-items { border-top-color: #17a2b8; }
    .stat-compact.border-items .stat-value { color: #17a2b8; }

    .stat-compact.border-avg { border-top-color: #f57f17; }
    .stat-compact.border-avg .stat-value { color: #f57f17; }

    /* ===== CHART ROW - PANTay NA HATI ===== */
    .charts-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .chart-card {
        background: white;
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .chart-card .card-header {
        background: white;
        border-bottom: 1px solid #e9ecef;
        padding: 12px 20px;
        border-radius: 12px 12px 0 0;
    }

    .chart-card .card-header h5 {
        font-size: 14px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .chart-card .card-body {
        padding: 20px;
        flex: 1;
    }

    .chart-container {
        position: relative;
        height: 260px;
        width: 100%;
    }

    /* ===== FILTER CARD ===== */
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 18px 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #e9ecef;
    }

    .filter-card .form-label {
        font-size: 12px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 4px;
    }

    .filter-card .form-label i {
        color: #0b7a33;
        width: 14px;
    }

    .filter-card .form-control,
    .filter-card .form-select {
        font-size: 13px;
        border-radius: 8px;
        border: 1.5px solid #e0e0e0;
        padding: 6px 12px;
        height: 38px;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 8px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .btn-success {
        background: #0b7a33;
        border-color: #0b7a33;
        color: white;
    }

    .btn-success:hover {
        background: #056b28;
        border-color: #056b28;
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(11, 122, 51, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        border-color: #5a6268;
        color: white;
    }

    .btn-info {
        background: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #138496;
        border-color: #138496;
        color: white;
    }

    /* ===== TABLE ===== */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        font-size: 13px;
        margin: 0;
        width: 100%;
    }

    .table thead th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 14px;
        border-bottom: 2px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 10;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        font-size: 12px;
        border-bottom: 1px solid #f1f3f5;
    }

    .table tbody tr:hover {
        background: #f8fdf8;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* ===== BADGES ===== */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 12px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge.bg-warning {
        background: #ffc107 !important;
        color: #333;
    }

    .badge.bg-secondary {
        background: #6c757d !important;
        color: white;
    }

    .badge.bg-primary {
        background: #0b7a33 !important;
        color: white;
    }

    /* ===== EXPORT BUTTONS ===== */
    .export-buttons {
        display: flex;
        gap: 8px;
        justify-content: flex-end;
        flex-wrap: wrap;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 992px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .charts-row { grid-template-columns: 1fr; }
    }

    @media (max-width: 768px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); gap: 8px; }
        .stat-compact .stat-value { font-size: 18px; }
        .stat-compact .stat-label { font-size: 10px; }
        .chart-container { height: 220px; }
        .filter-card .row { flex-direction: column; gap: 8px; }
        .filter-card .col-md-3 { width: 100%; }
        .filter-card .btn { width: 100%; }
        .export-buttons { flex-direction: column; }
        .export-buttons .btn { width: 100%; }
        .chart-card .card-header h5 { font-size: 13px; }
        .table thead th, .table tbody td { font-size: 11px; padding: 6px 8px; }
    }

    @media (max-width: 480px) {
        .stats-row { grid-template-columns: 1fr 1fr; }
        .stat-compact .stat-value { font-size: 16px; }
        .stat-compact .stat-label { font-size: 9px; }
    }
</style>

<div class="container-fluid px-3">
    <!-- ===== HEADER ===== -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%); border-radius: 16px;">
                <div class="card-body py-4">
                    <h4 class="mb-1 text-white" style="font-size: 24px; font-weight: 700;">
                        <i class="fas fa-chart-line me-2"></i> Sales & Reports
                    </h4>
                    <p class="mb-0 text-white-50" style="font-size: 14px;">View and analyze your sales data</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== COMPACT STAT CARDS ===== -->
    <div class="stats-row">
        <div class="stat-compact border-sales">
            <div class="stat-label">Total Sales</div>
            <div class="stat-value">₱{{ number_format($totalSales ?? 0, 2) }}</div>
        </div>
        <div class="stat-compact border-trans">
            <div class="stat-label">Transactions</div>
            <div class="stat-value">{{ number_format($totalTransactions ?? 0) }}</div>
        </div>
        <div class="stat-compact border-items">
            <div class="stat-label">Items Sold</div>
            <div class="stat-value">{{ number_format($totalItemsSold ?? 0) }}</div>
        </div>
        <div class="stat-compact border-avg">
            <div class="stat-label">Average Sale</div>
            <div class="stat-value">₱{{ number_format($averageSale ?? 0, 2) }}</div>
        </div>
    </div>

    <!-- ===== CHARTS ROW 1: Daily Sales Trend + Sales by Hour (PANTay NA HATI) ===== -->
    <div class="charts-row">
        <!-- 1. Daily Sales Trend - Line Chart -->
        <div class="chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-chart-line text-success me-2"></i> Daily Sales Trend
                    <small class="text-muted ms-2" style="font-size: 11px;">Line Chart</small>
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 2. Sales by Hour - Bar Chart -->
        <div class="chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-chart-bar text-success me-2"></i> Sales by Hour
                    <small class="text-muted ms-2" style="font-size: 11px;">Bar Chart</small>
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="hourlyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CHARTS ROW 2: Customer Type + Top Products (PANTay NA HATI) ===== -->
    <div class="charts-row">
        <!-- 3. Sales by Customer Type - Pie Chart -->
        <div class="chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-chart-pie text-success me-2"></i> Sales by Customer Type
                    <small class="text-muted ms-2" style="font-size: 11px;">Pie Chart</small>
                </h5>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="customerTypeChart"></canvas>
                </div>
            </div>
        </div>

        <!-- 4. Top Selling Products - Table -->
        <div class="chart-card">
            <div class="card-header">
                <h5>
                    <i class="fas fa-chart-simple text-success me-2"></i> Top Selling Products
                    <small class="text-muted ms-2" style="font-size: 11px;">Table</small>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive" style="max-height: 260px; overflow-y: auto;">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th class="ps-3">Product Name</th>
                                <th class="text-center">Qty Sold</th>
                                <th class="text-end pe-3">Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts ?? [] as $product)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $product->name ?? 'Unknown' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        {{ number_format($product->total_sold ?? 0) }} pcs
                                    </span>
                                </td>
                                <td class="text-end pe-3 text-success fw-semibold">
                                    ₱{{ number_format($product->total_revenue ?? 0, 2) }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    <i class="fas fa-chart-line fa-2x mb-2 d-block opacity-50"></i>
                                    No sales data available
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== EXPORT BUTTONS ===== -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body export-buttons">
                    <a href="{{ route('sales-reports.export', request()->all()) }}" class="btn btn-info text-white">
                        <i class="fas fa-file-excel me-2"></i>Export CSV
                    </a>
                    <a href="{{ route('sales-reports.print', request()->all()) }}" target="_blank" class="btn btn-secondary">
                        <i class="fas fa-print me-2"></i>Print Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== FILTER BAR (Nasa pagitan ng Export at Sales Transactions) ===== -->
    <div class="filter-card">
        <form method="GET" action="{{ route('sales-reports.index') }}" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">
                    <i class="fas fa-calendar-alt"></i> Date From
                </label>
                <input type="date" name="date_from" class="form-control"
                       value="{{ request('date_from', $dateFrom ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">
                    <i class="fas fa-calendar-alt"></i> Date To
                </label>
                <input type="date" name="date_to" class="form-control"
                       value="{{ request('date_to', $dateTo ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">
                    <i class="fas fa-users"></i> Customer Type
                </label>
                <select name="customer_type" class="form-select">
                    <option value="all">All Customer Types</option>
                    @foreach($discountTypes ?? [] as $type)
                    <option value="{{ strtolower(str_replace(' ', '_', $type->name)) }}"
                        {{ request('customer_type') == strtolower(str_replace(' ', '_', $type->name)) ? 'selected' : '' }}>
                        {{ $type->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success flex-grow-1">
                        <i class="fas fa-filter me-2"></i>Apply Filter
                    </button>
                    <a href="{{ route('sales-reports.index') }}" class="btn btn-secondary">
                        <i class="fas fa-undo me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- ===== SALES TRANSACTIONS TABLE ===== -->
    <div class="card border-0 shadow-sm">
        <div class="card-header">
            <h5>
                <i class="fas fa-table text-success me-2"></i> Sales Transactions
                <small class="text-muted ms-2" style="font-size: 12px;">{{ $sales->count() ?? 0 }} transaction(s)</small>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="ps-3">Invoice No</th>
                            <th>Date</th>
                            <th>Cashier</th>
                            <th>Customer Type</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-end">Discount</th>
                            <th class="text-end pe-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales ?? [] as $sale)
                        <tr>
                            <td class="ps-3 fw-semibold">{{ $sale->invoice_no ?? 'N/A' }}</td>
                            <td class="text-muted" style="font-size: 12px;">
                                {{ isset($sale->created_at) ? $sale->created_at->format('M d, Y h:i A') : 'N/A' }}
                            </td>
                            <td>{{ $sale->user->username ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $customerLabel = ucfirst(str_replace('_', ' ', $sale->customer_type ?? 'Walk-in'));
                                @endphp
                                @if($sale->customer_type && $sale->customer_type != 'walk_in')
                                    <span class="badge bg-warning text-dark">{{ $customerLabel }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ $customerLabel }}</span>
                                @endif
                            </td>
                            <td class="text-end">₱{{ number_format($sale->subtotal ?? 0, 2) }}</td>
                            <td class="text-end text-danger">₱{{ number_format($sale->discount ?? 0, 2) }}</td>
                            <td class="text-end pe-3 fw-semibold text-success">₱{{ number_format($sale->total_amount ?? 0, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0" style="font-size: 14px;">No sales found for the selected period</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================ -->
<!-- SCRIPTS -->
<!-- ============================================================ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // 1. DAILY SALES TREND - LINE CHART
    // ============================================
    const salesChartData = @json($salesChart ?? []);
    
    if (document.getElementById('salesChart') && salesChartData.length > 0) {
        new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: salesChartData.map(s => s.date),
                datasets: [{
                    label: 'Daily Sales (₱)',
                    data: salesChartData.map(s => parseFloat(s.total) || 0),
                    borderColor: '#0b7a33',
                    backgroundColor: 'rgba(11, 122, 51, 0.08)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#0b7a33',
                    pointBorderColor: '#fff',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: { label: (ctx) => `₱${ctx.raw.toFixed(2)}` }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: (val) => '₱' + val.toFixed(0), font: { size: 10 } }
                    },
                    x: {
                        ticks: { maxRotation: 45, minRotation: 45, autoSkip: true, maxTicksLimit: 8, font: { size: 10 } }
                    }
                }
            }
        });
    }

    // ============================================
    // 2. SALES BY HOUR - BAR CHART
    // ============================================
    const hourlyData = @json($hoursData ?? []);
    
    if (document.getElementById('hourlyChart') && hourlyData.length > 0) {
        new Chart(document.getElementById('hourlyChart'), {
            type: 'bar',
            data: {
                labels: hourlyData.map(h => h.label),
                datasets: [{
                    label: 'Sales (₱)',
                    data: hourlyData.map(h => parseFloat(h.total) || 0),
                    backgroundColor: '#0b7a33',
                    borderRadius: 6,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } },
                    tooltip: { callbacks: { label: (ctx) => `₱${ctx.raw.toFixed(2)}` } }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { callback: (val) => '₱' + val.toFixed(0), font: { size: 10 } }
                    },
                    x: {
                        ticks: { maxRotation: 45, autoSkip: true, maxTicksLimit: 12, font: { size: 10 } }
                    }
                }
            }
        });
    }

    // ============================================
    // 3. SALES BY CUSTOMER TYPE - PIE CHART
    // ============================================
    const customerData = @json($salesByCustomerType ?? []);
    
    if (document.getElementById('customerTypeChart') && customerData.length > 0) {
        const pieColors = ['#0b7a33', '#ff9800', '#2196f3', '#9c27b0', '#f44336', '#00bcd4', '#4caf50', '#e91e63'];
        new Chart(document.getElementById('customerTypeChart'), {
            type: 'doughnut',
            data: {
                labels: customerData.map(c => {
                    let label = c.customer_type ? c.customer_type.replace('_', ' ') : 'Walk-in';
                    return label.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
                }),
                datasets: [{
                    data: customerData.map(c => parseFloat(c.total) || 0),
                    backgroundColor: pieColors.slice(0, customerData.length),
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ₱${ctx.raw.toFixed(2)}` } }
                }
            }
        });
    }

    console.log('✅ Sales & Reports charts loaded!');
});
</script>

@endsection