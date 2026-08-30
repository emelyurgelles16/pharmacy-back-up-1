@extends('layouts.app')

@section('title', 'Inventory Report')

@section('content')
<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        border-radius: 12px;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    .stat-card .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .filter-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 25px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid #eef2f6;
    }
    .chart-container {
        position: relative;
        height: 280px;
        width: 100%;
    }
    .status-badge-report {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .status-available { background: #e8f5e9; color: #2e7d32; }
    .status-lowstock { background: #fff3e0; color: #e65100; }
    .status-outofstock { background: #ffebee; color: #c62828; }
    .status-nearexpired { background: #fff8e1; color: #f57f17; }
    .status-expired { background: #ffebee; color: #c62828; }
    .status-nearexpired-lowstock { background: #ffe0b2; color: #e65100; }
    @media (max-width: 768px) {
        .chart-container { height: 220px; }
        .stat-card h3 { font-size: 20px; }
    }
</style>

<div class="container-fluid px-3">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0" style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%); border-radius: 20px;">
                <div class="card-body py-4">
                    <h4 class="mb-1 text-white">
                        <i class="fas fa-boxes me-2"></i> Inventory Report
                    </h4>
                    <p class="mb-0 text-white-50">Monitor and analyze your inventory status</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards - Row 1 -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-4">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Medicines</h6>
                            <h3 class="mb-0 text-success">{{ number_format($totalMedicines) }}</h3>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="fas fa-capsules"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Stock</h6>
                            <h3 class="mb-0 text-primary">{{ number_format($totalStock) }}</h3>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="fas fa-cubes"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Low Stock</h6>
                            <h3 class="mb-0 text-danger">{{ number_format($lowStockCount) }}</h3>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards - Row 2 -->
    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-lg-4">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Out of Stock</h6>
                            <h3 class="mb-0 text-danger">{{ number_format($outOfStockCount) }}</h3>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-times-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Near Expiry</h6>
                            <h3 class="mb-0 text-warning">{{ number_format($nearExpiryCount) }}</h3>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-4">
            <div class="card stat-card bg-white shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Expired Medicines</h6>
                            <h3 class="mb-0 text-danger">{{ number_format($expiredCount) }}</h3>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="fas fa-skull-crossbones"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-card">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">
                    <i class="fas fa-tag text-success me-1"></i> Category
                </label>
                <select name="category" class="form-select rounded-pill">
                    <option value="all">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->name }}" {{ request('category') == $cat->name ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">
                    <i class="fas fa-pills text-success me-1"></i> Dosage Form
                </label>
                <select name="dosage_form" class="form-select rounded-pill">
                    <option value="all">All Forms</option>
                    @foreach($dosageForms as $form)
                    <option value="{{ $form->id }}" {{ request('dosage_form') == $form->id ? 'selected' : '' }}>
                        {{ $form->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">
                    <i class="fas fa-building text-success me-1"></i> Brand
                </label>
                <input type="text" name="brand" class="form-control rounded-pill" 
                       placeholder="Search brand..." value="{{ request('brand') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold mb-1">
                    <i class="fas fa-circle text-success me-1"></i> Status
                </label>
                <select name="status" class="form-select rounded-pill">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="lowstock" {{ request('status') == 'lowstock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="outofstock" {{ request('status') == 'outofstock' ? 'selected' : '' }}>Out of Stock</option>
                    <option value="nearexpired" {{ request('status') == 'nearexpired' ? 'selected' : '' }}>Near Expiry</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                </select>
            </div>
            <div class="col-md-2">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success rounded-pill px-4 flex-grow-1">
                        <i class="fas fa-filter me-2"></i>Apply
                    </button>
                    <a href="{{ route('inventory.report') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-pie text-success me-2"></i>By Category
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-pie text-success me-2"></i>By Dosage Form
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="dosageFormChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-doughnut text-success me-2"></i>Stock Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
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
                    <a href="{{ route('inventory.report.export', request()->all()) }}" class="btn btn-info text-white rounded-pill px-4 me-2">
                        <i class="fas fa-file-excel me-2"></i>Export CSV
                    </a>
                    <a href="{{ route('inventory.report.print', request()->all()) }}" target="_blank" class="btn btn-secondary rounded-pill px-4">
                        <i class="fas fa-print me-2"></i>Print Report
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-table text-success me-2"></i>Inventory List
            </h5>
            <small class="text-muted ms-2">{{ $products->count() }} product(s)</small>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover mb-0">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th class="ps-3">Product Name</th>
                            <th>Barcode</th>
                            <th>Category</th>
                            <th>Dosage Form</th>
                            <th>Batch No.</th>
                            <th class="text-center">Stock</th>
                            <th class="text-end">Unit Price</th>
                            <th class="text-end">Inventory Value</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            @foreach($product->batches as $batch)
                            <tr>
                                <td class="ps-3 fw-medium">{{ $product->name }}</td>
                                <td>
                                    @if($product->barcode)
                                        <span style="font-family: monospace; font-size: 11px;">{{ $product->barcode }}</span>
                                    @else
                                        <span style="color: #ccc;">—</span>
                                    @endif
                                </td>
                                <td>{{ $product->category ?? '-' }}</td>
                                <td>{{ $product->dosageForm->name ?? '-' }}</td>
                                <td>{{ $batch->batch_number ?? 'Batch 1' }}</td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill">{{ number_format($batch->pieces_left ?? 0) }}</span>
                                </td>
                                <td class="text-end">₱{{ number_format($product->price, 2) }}</td>
                                <td class="text-end fw-semibold">
                                    ₱{{ number_format(($batch->pieces_left ?? 0) * $product->price, 2) }}
                                </td>
                                <td>{{ $batch->expiry_date ? $batch->expiry_date->format('M d, Y') : '—' }}</td>
                                <td>
                                    @php
                                        $statusClass = $batch->status;
                                    @endphp
                                    <span class="status-badge-report status-{{ $statusClass }}">
                                        {{ $batch->status_text }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No inventory found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Problem Sections -->
    <div class="row g-4 mt-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Low Stock Medicines
                        <span class="badge bg-danger ms-2">{{ count($lowStockItems) }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Product</th>
                                    <th class="text-center">Stock</th>
                                    <th>Expiry</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockItems as $item)
                                <tr>
                                    <td class="ps-3">{{ $item->name }}</td>
                                    <td class="text-center text-danger">{{ number_format($item->total_pieces_left) }}</td>
                                    <td>{{ $item->earliest_expiry_date ? $item->earliest_expiry_date->format('M d, Y') : '—' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">No low stock items</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-semibold text-warning">
                        <i class="fas fa-clock me-2"></i>Near Expiry Medicines
                        <span class="badge bg-warning ms-2">{{ count($nearExpiryItems) }}</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Product</th>
                                    <th class="text-center">Stock</th>
                                    <th>Expiry</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($nearExpiryItems as $item)
                                <tr>
                                    <td class="ps-3">{{ $item->name }}</td>
                                    <td class="text-center">{{ number_format($item->total_pieces_left) }}</td>
                                    <td class="text-warning">{{ $item->earliest_expiry_date ? $item->earliest_expiry_date->format('M d, Y') : '—' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">No near expiry items</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Category Chart
    const categoryData = @json($inventoryByCategory ?? []);
    if (document.getElementById('categoryChart') && categoryData.length) {
        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: categoryData.map(c => c.category || 'Uncategorized'),
                datasets: [{
                    data: categoryData.map(c => parseFloat(c.value)),
                    backgroundColor: ['#1b5e20', '#ff9800', '#2196f3', '#9c27b0', '#f44336', '#00bcd4', '#4caf50', '#e91e63'],
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

    // Dosage Form Chart
    const dosageData = @json($inventoryByDosageForm ?? []);
    if (document.getElementById('dosageFormChart') && dosageData.length) {
        new Chart(document.getElementById('dosageFormChart'), {
            type: 'doughnut',
            data: {
                labels: dosageData.map(d => d.dosage_form || 'Unknown'),
                datasets: [{
                    data: dosageData.map(d => parseFloat(d.value)),
                    backgroundColor: ['#0b7a33', '#ff9800', '#2196f3', '#9c27b0', '#f44336', '#00bcd4', '#4caf50', '#e91e63'],
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

    // Status Distribution Chart
    const statusData = @json($statusDistribution ?? []);
    if (document.getElementById('statusChart') && Object.keys(statusData).length) {
        const colors = {
            'Available': '#4caf50',
            'Low Stock': '#ff9800',
            'Out of Stock': '#f44336',
            'Near Expiry': '#ffc107',
            'Expired': '#d32f2f'
        };
        new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: Object.keys(statusData),
                datasets: [{
                    data: Object.values(statusData),
                    backgroundColor: Object.keys(statusData).map(k => colors[k] || '#999'),
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 10 } } },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw} items` } }
                }
            }
        });
    }
});
</script>
@endsection