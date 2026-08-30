@extends('layouts.app')

@section('title', 'Sales & Reports')

@section('content')
<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
    }
    .filter-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .chart-container {
        position: relative;
        height: 280px;
        width: 100%;
    }
    .table-scroll {
        max-height: 450px;
        overflow-y: auto;
    }
    .table-scroll th {
        position: sticky;
        top: 0;
        background: #f8f9fa;
        z-index: 10;
    }
    @media (max-width: 768px) {
        .chart-container {
            height: 220px;
        }
        .stat-card h3 {
            font-size: 20px;
        }
    }
    @media print {
        .no-print, .sidebar, .logout, .btn, .filter-card, .card-header .btn, 
        .user-info, .dashboard-topbar, .page-loading, .export-buttons {
            display: none !important;
        }
        .main {
            margin: 0 !important;
            padding: 0 !important;
        }
        .card {
            border: none !important;
            box-shadow: none !important;
        }
        .stat-card {
            break-inside: avoid;
        }
        .chart-container {
            break-inside: avoid;
        }
    }
</style>

<div class="container-fluid px-3">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%); border-radius: 20px;">
                <div class="card-body py-4">
                    <h4 class="mb-1 text-white">
                        <i class="fas fa-chart-line me-2"></i> Sales & Reports
                    </h4>
                    <p class="mb-0 text-white-50">View and analyze your sales data</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Sales</h6>
                            <h3 class="mb-0 text-success">₱{{ number_format($totalSales, 2) }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Transactions</h6>
                            <h3 class="mb-0 text-primary">{{ number_format($totalTransactions) }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-receipt fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Items Sold</h6>
                            <h3 class="mb-0 text-info">{{ number_format($totalItemsSold ?? 0) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-cubes fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="card stat-card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Average Sale</h6>
                            <h3 class="mb-0 text-warning">₱{{ number_format($averageSale, 2) }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                            <i class="fas fa-chart-simple fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-card">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">
                    <i class="fas fa-calendar-alt text-success me-1"></i> Date From
                </label>
                <input type="date" name="date_from" class="form-control rounded-pill" 
                       value="{{ request('date_from', $dateFrom ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">
                    <i class="fas fa-calendar-alt text-success me-1"></i> Date To
                </label>
                <input type="date" name="date_to" class="form-control rounded-pill" 
                       value="{{ request('date_to', $dateTo ?? '') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold mb-1">
                    <i class="fas fa-users text-success me-1"></i> Customer Type
                </label>
                <select name="customer_type" class="form-select rounded-pill">
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
                    <button type="submit" class="btn btn-success rounded-pill px-4 flex-grow-1">
                        <i class="fas fa-filter me-2"></i>Apply
                    </button>
                    <a href="{{ route('sales-reports.index') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-line text-success me-2"></i>Daily Sales Trend
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-clock text-success me-2"></i>Sales by Hour
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="hourlyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Type & Top Products -->
    <div class="row g-4 mb-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-pie text-success me-2"></i>Sales by Customer Type
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="chart-container" style="height: 280px;">
                        <canvas id="customerTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-simple text-success me-2"></i>Top Selling Products
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Product Name</th>
                                    <th class="text-center">Qty Sold</th>
                                    <th class="text-end pe-3">Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts ?? [] as $product)
                                <tr>
                                    <td class="ps-3 fw-medium">{{ $product->name }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill px-3 py-1">
                                            {{ number_format($product->total_sold) }} pcs
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
                                        No data available
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-end">
                    <a href="{{ route('sales-reports.export', request()->all()) }}" class="btn btn-info text-white rounded-pill px-4 me-2">
                        <i class="fas fa-file-excel me-2"></i>Export CSV
                    </a>
                    <a href="{{ route('sales-reports.print', request()->all()) }}" target="_blank" class="btn btn-secondary rounded-pill px-4">
                        <i class="fas fa-print me-2"></i>Print Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Transactions Table -->
        <!-- Sales Transactions Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-table text-success me-2"></i>Sales Transactions
            </h5>
            <small class="text-muted ms-2">{{ $sales->count() }} transaction(s)</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover mb-0">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
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
                        @forelse($sales as $sale)
                        <tr>
                            <td class="ps-3 fw-semibold">{{ $sale->invoice_no }}</td>
                            <td class="text-muted">{{ $sale->created_at->format('M d, Y h:i A') }}</td>
                            <td>{{ $sale->user->username ?? 'N/A' }}</td>
                            <td>
                                @php
                                    $customerLabel = ucfirst(str_replace('_', ' ', $sale->customer_type ?? 'Walk-in'));
                                @endphp
                                @if($sale->customer_type && $sale->customer_type != 'walk_in')
                                    <span class="badge bg-warning text-dark rounded-pill">{{ $customerLabel }}</span>
                                @else
                                    <span class="badge bg-secondary rounded-pill">{{ $customerLabel }}</span>
                                @endif
                            </td>
                            <td class="text-end">₱{{ number_format($sale->subtotal, 2) }}</td>
                            <td class="text-end text-danger">₱{{ number_format($sale->discount, 2) }}</td>
                            <td class="text-end pe-3 fw-semibold text-success">₱{{ number_format($sale->total_amount, 2) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No sales found for the selected period</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Trend Chart - with improved label handling
    const salesChartData = @json($salesChart ?? []);
    if (document.getElementById('salesChart') && salesChartData.length) {
        const chart = new Chart(document.getElementById('salesChart'), {
            type: 'line',
            data: {
                labels: salesChartData.map(s => s.date),
                datasets: [{
                    label: 'Daily Sales (₱)',
                    data: salesChartData.map(s => s.total),
                    borderColor: '#1b5e20',
                    backgroundColor: 'rgba(27, 94, 32, 0.05)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#1b5e20',
                    pointBorderColor: '#fff',
                    pointRadius: 3,
                    pointHoverRadius: 5,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } },
                    tooltip: { mode: 'index', intersect: false, callbacks: { label: (ctx) => `₱${ctx.raw.toFixed(2)}` } }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: (val) => '₱' + val, stepSize: Math.ceil(Math.max(...salesChartData.map(s => s.total), 100) / 5) } },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            minRotation: 45,
                            autoSkip: true,
                            maxTicksLimit: 8,
                            font: { size: 10 }
                        }
                    }
                }
            }
        });
    }
    
    // Hourly Sales Chart
    const hourlyData = @json($hoursData ?? []);
    if (document.getElementById('hourlyChart') && hourlyData.length) {
        new Chart(document.getElementById('hourlyChart'), {
            type: 'bar',
            data: {
                labels: hourlyData.map(h => h.label),
                datasets: [{
                    label: 'Sales (₱)',
                    data: hourlyData.map(h => h.total),
                    backgroundColor: '#0b7a33',
                    borderRadius: 8,
                    barPercentage: 0.7,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'top', labels: { boxWidth: 12, font: { size: 11 } } },
                    tooltip: { callbacks: { label: (ctx) => `₱${ctx.raw.toFixed(2)}` } }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: (val) => '₱' + val } },
                    x: {
                        ticks: {
                            maxRotation: 45,
                            autoSkip: true,
                            maxTicksLimit: 12,
                            font: { size: 10 }
                        }
                    }
                }
            }
        });
    }
    
    // Customer Type Pie Chart
    const customerData = @json($salesByCustomerType ?? []);
    if (document.getElementById('customerTypeChart') && customerData.length) {
        const pieColors = ['#1b5e20', '#ff9800', '#2196f3', '#9c27b0', '#f44336', '#00bcd4', '#4caf50', '#e91e63'];
        new Chart(document.getElementById('customerTypeChart'), {
            type: 'pie',
            data: {
                labels: customerData.map(c => {
                    let label = c.customer_type ? c.customer_type.replace('_', ' ') : 'Walk-in';
                    return label.split(' ').map(w => w.charAt(0).toUpperCase() + w.slice(1)).join(' ');
                }),
                datasets: [{
                    data: customerData.map(c => parseFloat(c.total)),
                    backgroundColor: pieColors,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ₱${ctx.raw.toFixed(2)}` } }
                }
            }
        });
    }
});

function ucfirst(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
}
</script>
@endsection