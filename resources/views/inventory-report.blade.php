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

    /* ===== COMPACT STAT CARDS ===== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(6, 1fr);
        gap: 10px;
        margin-bottom: 25px;
    }

    .stat-compact {
        background: white;
        border-radius: 10px;
        padding: 12px 8px;
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
        font-size: 10px;
        color: #6c757d;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 4px;
        white-space: nowrap;
    }

    .stat-compact .stat-value {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        line-height: 1.2;
    }

    .stat-compact.border-total { border-top-color: #0b7a33; }
    .stat-compact.border-total .stat-value { color: #0b7a33; }

    .stat-compact.border-stock { border-top-color: #1565c0; }
    .stat-compact.border-stock .stat-value { color: #1565c0; }

    .stat-compact.border-low { border-top-color: #e65100; }
    .stat-compact.border-low .stat-value { color: #e65100; }

    .stat-compact.border-out { border-top-color: #c62828; }
    .stat-compact.border-out .stat-value { color: #c62828; }

    .stat-compact.border-near { border-top-color: #f57f17; }
    .stat-compact.border-near .stat-value { color: #f57f17; }

    .stat-compact.border-exp { border-top-color: #b71c1c; }
    .stat-compact.border-exp .stat-value { color: #b71c1c; }

    /* ===== EXPANDABLE SECTIONS ===== */
    .expandable-header {
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        user-select: none;
    }

    .expandable-header .toggle-icon {
        transition: transform 0.3s ease;
        font-size: 14px;
        color: #999;
    }

    .expandable-header.collapsed .toggle-icon {
        transform: rotate(-90deg);
    }

    .expandable-body {
        max-height: 250px;
        overflow-y: auto;
        transition: max-height 0.3s ease;
    }

    .expandable-body.collapsed {
        max-height: 0;
        overflow: hidden;
    }

    /* ===== INVENTORY TABLE ===== */
    .inventory-table thead th {
        background: #f8f9fa;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #495057;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    .inventory-table tbody td {
        font-size: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }

    .inventory-table tbody tr:hover {
        background: #f8fdf8;
    }

    /* ===== PAGINATION ===== */
    .pagination-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 20px;
        background: #fafbfc;
        border-top: 1px solid #e9ecef;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pagination-wrapper .pagination-info {
        font-size: 13px;
        color: #6c757d;
    }

    .pagination-wrapper .pagination-info strong {
        color: #1a1a2e;
    }

    .pagination {
        display: flex;
        gap: 4px;
        margin: 0;
        padding: 0;
        list-style: none;
        align-items: center;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 8px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        color: #495057;
        background: white;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background: #e8f5e9;
        border-color: #0b7a33;
        color: #0b7a33;
    }

    .pagination .page-item.active .page-link {
        background: #0b7a33;
        border-color: #0b7a33;
        color: white;
    }

    .pagination .page-item.disabled .page-link {
        opacity: 0.4;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ===== FILTER LABELS ===== */
    .filter-label {
        font-size: 11px;
        font-weight: 600;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        margin-bottom: 4px;
        display: block;
    }

    .filter-label i {
        color: #0b7a33;
        width: 14px;
    }

    @media (max-width: 992px) {
        .stats-row { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 768px) {
        .chart-container { height: 220px; }
        .stat-compact .stat-value { font-size: 16px; }
        .stat-compact .stat-label { font-size: 9px; }
        .pagination-wrapper { flex-direction: column; align-items: center; }
    }

    @media (max-width: 480px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
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

    <!-- ===== SUMMARY STATS (Compact Single Row) ===== -->
    <div class="stats-row">
        <div class="stat-compact border-total">
            <div class="stat-label">Total Products</div>
            <div class="stat-value">{{ number_format($totalMedicines) }}</div>
        </div>
        <div class="stat-compact border-stock">
            <div class="stat-label">Total Stock</div>
            <div class="stat-value">{{ number_format($totalStock) }}</div>
        </div>
        <div class="stat-compact border-low">
            <div class="stat-label">Low Stock</div>
            <div class="stat-value">{{ number_format($lowStockCount) }}</div>
        </div>
        <div class="stat-compact border-out">
            <div class="stat-label">Out of Stock</div>
            <div class="stat-value">{{ number_format($outOfStockCount) }}</div>
        </div>
        <div class="stat-compact border-near">
            <div class="stat-label">Near Expiry</div>
            <div class="stat-value">{{ number_format($nearExpiryCount) }}</div>
        </div>
        <div class="stat-compact border-exp">
            <div class="stat-label">Expired</div>
            <div class="stat-value">{{ number_format($expiredCount) }}</div>
        </div>
    </div>

    <!-- ===== CHARTS ROW (3 Charts) ===== -->
    <div class="row g-4 mb-4">
        <!-- Stock Status - Bar Chart -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-bar text-success me-2"></i> STOCK STATUS
                        <small class="text-muted ms-2">Bar Chart</small>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="stockStatusBarChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiry Status - Pie Chart -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-pie text-warning me-2"></i> EXPIRY STATUS
                        <small class="text-muted ms-2">Pie Chart</small>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="expiryStatusPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Movement - Line Chart -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-semibold">
                        <i class="fas fa-chart-line text-primary me-2"></i> STOCK MOVEMENT
                        <small class="text-muted ms-2">Line Chart</small>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="stockMovementLineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== EXPORT BUTTONS ===== -->
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

    <!-- ===== FILTER BAR ===== -->
    <div class="filter-card">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="filter-label">
                    <i class="fas fa-calendar-alt"></i> Expiry Date From
                </label>
                <input type="date" name="expiry_from" class="form-control rounded-pill" 
                       value="{{ request('expiry_from') }}">
            </div>
            <div class="col-md-2">
                <label class="filter-label">
                    <i class="fas fa-calendar-alt"></i> Expiry Date To
                </label>
                <input type="date" name="expiry_to" class="form-control rounded-pill" 
                       value="{{ request('expiry_to') }}">
            </div>
            <div class="col-md-2">
                <label class="filter-label">
                    <i class="fas fa-hashtag"></i> Batch No.
                </label>
                <input type="text" name="batch_no" class="form-control rounded-pill" 
                       placeholder="Search batch..." value="{{ request('batch_no') }}">
            </div>
            <div class="col-md-2">
                <label class="filter-label">
                    <i class="fas fa-circle"></i> Status
                </label>
                <select name="status" class="form-select rounded-pill">
                    <option value="">All Status</option>
                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>🟢 Available</option>
                    <option value="lowstock" {{ request('status') == 'lowstock' ? 'selected' : '' }}>🟠 Low Stock</option>
                    <option value="outofstock" {{ request('status') == 'outofstock' ? 'selected' : '' }}>🔴 Out of Stock</option>
                    <option value="nearexpired" {{ request('status') == 'nearexpired' ? 'selected' : '' }}>🟡 Near Expiry</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>⚫ Expired</option>
                </select>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success rounded-pill px-4 flex-grow-1">
                        <i class="fas fa-filter me-2"></i>Apply Filter
                    </button>
                    <a href="{{ route('inventory.report') }}" class="btn btn-secondary rounded-pill px-4">
                        <i class="fas fa-undo me-2"></i>Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- ===== INVENTORY LIST ===== -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white py-3 border-0">
            <h5 class="mb-0 fw-semibold">
                <i class="fas fa-table text-success me-2"></i>Inventory List
                <small class="text-muted ms-2">{{ $products->total() }} product(s)</small>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                <table class="table table-hover mb-0 inventory-table">
                    <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                        <tr>
                            <th class="ps-3" style="width: 60px;">#</th>
                            <th>Product Name</th>
                            <th>Barcode</th>
                            <th>Batch No.</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Pcs Left</th>
                            <th>Expiry Date</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $index => $product)
                            @foreach($product->batches as $batch)
                            <tr>
                                <td class="ps-3 text-muted">{{ $products->firstItem() + $index }}</td>
                                <td class="fw-medium">{{ $product->name }}</td>
                                <td>
                                    @if($product->barcode)
                                        <span style="font-family: monospace; font-size: 11px; background: #f5f5f5; padding: 2px 8px; border-radius: 4px;">{{ $product->barcode }}</span>
                                    @else
                                        <span style="color: #ccc;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ $batch->batch_number ?? 'Batch 1' }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-secondary rounded-pill">{{ number_format($batch->pieces_per_box ?? 0) }}</span>
                                </td>
                                <td class="text-center">
                                    <strong style="color: {{ $batch->pieces_left <= 30 ? '#c62828' : '#0b7a33' }};">
                                        {{ number_format($batch->pieces_left ?? 0) }}
                                    </strong>
                                </td>
                                <td>{{ $batch->expiry_date ? $batch->expiry_date->format('M d, Y') : '—' }}</td>
                                <td class="text-center">
                                    @php $statusClass = $batch->status; @endphp
                                    <span class="status-badge-report status-{{ $statusClass }}">
                                        {{ $batch->status_text }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fas fa-inbox fa-3x text-muted mb-3 d-block"></i>
                                <p class="text-muted mb-0">No inventory found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ===== PAGINATION ===== -->
        @if($products->hasPages())
        <div class="pagination-wrapper">
            <div class="pagination-info">
                <i class="fas fa-list-ul me-1"></i>
                Showing <strong>{{ $products->firstItem() ?? 0 }}</strong> to <strong>{{ $products->lastItem() ?? 0 }}</strong> of <strong>{{ $products->total() }}</strong> results
            </div>
            <div>
                {{ $products->appends(request()->all())->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- ============================================================ -->
    <!-- ===== EXPANDABLE SECTIONS (TAMANG ORDER) ===== -->
    <!-- ============================================================ -->
    <div class="row g-4 mt-3">
        <!-- ===== 1. NEAR EXPIRED MEDICINES ===== -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 expandable-header" onclick="toggleSection('nearExpirySection', this)">
                    <h5 class="mb-0 fw-semibold text-warning">
                        <i class="fas fa-clock me-2"></i>Near Expiry Medicines
                        <span class="badge bg-warning ms-2">{{ count($nearExpiryItems) }}</span>
                        <i class="fas fa-chevron-down toggle-icon ms-2"></i>
                    </h5>
                </div>
                <div class="card-body p-0 expandable-body" id="nearExpirySection">
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
                                    <td class="text-center fw-bold">{{ number_format($item->total_pieces_left) }}</td>
                                    <td class="text-warning fw-bold">{{ $item->earliest_expiry_date ? $item->earliest_expiry_date->format('M d, Y') : '—' }}</td>
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

        <!-- ===== 2. EXPIRED MEDICINES ===== -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 expandable-header" onclick="toggleSection('expiredSection', this)">
                    <h5 class="mb-0 fw-semibold text-danger">
                        <i class="fas fa-skull-crossbones me-2"></i>Expired Medicines
                        <span class="badge bg-danger ms-2">{{ count($expiredItems) }}</span>
                        <i class="fas fa-chevron-down toggle-icon ms-2"></i>
                    </h5>
                </div>
                <div class="card-body p-0 expandable-body" id="expiredSection">
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
                                @forelse($expiredItems as $item)
                                <tr style="background: #ffebee;">
                                    <td class="ps-3">{{ $item->name }}</td>
                                    <td class="text-center text-danger fw-bold">{{ number_format($item->total_pieces_left) }}</td>
                                    <td class="text-danger fw-bold">{{ $item->earliest_expiry_date ? $item->earliest_expiry_date->format('M d, Y') : '—' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">No expired items</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== 3. LOW STOCK MEDICINES ===== -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 expandable-header" onclick="toggleSection('lowStockSection', this)">
                    <h5 class="mb-0 fw-semibold text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Low Stock Medicines
                        <span class="badge bg-danger ms-2">{{ count($lowStockItems) }}</span>
                        <i class="fas fa-chevron-down toggle-icon ms-2"></i>
                    </h5>
                </div>
                <div class="card-body p-0 expandable-body" id="lowStockSection">
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
                                    <td class="text-center text-danger fw-bold">{{ number_format($item->total_pieces_left) }}</td>
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

        <!-- ===== 4. OUT OF STOCK MEDICINES ===== -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 border-0 expandable-header" onclick="toggleSection('outOfStockSection', this)">
                    <h5 class="mb-0 fw-semibold text-danger">
                        <i class="fas fa-times-circle me-2"></i>Out of Stock Medicines
                        <span class="badge bg-danger ms-2">{{ count($outOfStockItems) }}</span>
                        <i class="fas fa-chevron-down toggle-icon ms-2"></i>
                    </h5>
                </div>
                <div class="card-body p-0 expandable-body" id="outOfStockSection">
                    <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Product</th>
                                    <th class="text-center">Stock</th>
                                    <th>Batch No.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($outOfStockItems as $item)
                                <tr style="background: #ffebee;">
                                    <td class="ps-3">{{ $item->name }}</td>
                                    <td class="text-center text-danger fw-bold">{{ number_format($item->pieces_left) }}</td>
                                    <td><span class="badge bg-light text-dark border">{{ $item->batch_number }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center py-3 text-muted">No out of stock items</td>
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
// ============================================
// EXPANDABLE SECTIONS
// ============================================
function toggleSection(sectionId, header) {
    const section = document.getElementById(sectionId);
    const icon = header.querySelector('.toggle-icon');
    
    if (section.classList.contains('collapsed')) {
        section.classList.remove('collapsed');
        header.classList.remove('collapsed');
        icon.style.transform = 'rotate(0deg)';
    } else {
        section.classList.add('collapsed');
        header.classList.add('collapsed');
        icon.style.transform = 'rotate(-90deg)';
    }
}

@php
    // ✅ I-SET ANG DEFAULT VALUE SA PHP SIDE (hindi sa @json)
    $stockMovementData = $stockMovementData ?? [
        'labels' => [],
        'added' => [],
        'deducted' => [],
        'net' => []
    ];
@endphp

document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // 1. STOCK STATUS - BAR CHART
    // ============================================
    const stockStatusData = {
        labels: ['Available', 'Low Stock', 'Out of Stock', 'Near Expiry', 'Expired'],
        values: [
            {{ $statusDistribution['Available'] ?? 0 }},
            {{ $statusDistribution['Low Stock'] ?? 0 }},
            {{ $statusDistribution['Out of Stock'] ?? 0 }},
            {{ $statusDistribution['Near Expiry'] ?? 0 }},
            {{ $statusDistribution['Expired'] ?? 0 }}
        ]
    };

    if (document.getElementById('stockStatusBarChart')) {
        new Chart(document.getElementById('stockStatusBarChart'), {
            type: 'bar',
            data: {
                labels: stockStatusData.labels,
                datasets: [{
                    label: 'Number of Items',
                    data: stockStatusData.values,
                    backgroundColor: [
                        '#4caf50',
                        '#ff9800',
                        '#f44336',
                        '#ffc107',
                        '#d32f2f'
                    ],
                    borderRadius: 8,
                    barPercentage: 0.7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.raw} items` } }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 10 } }
                    },
                    x: {
                        ticks: { font: { size: 10 } }
                    }
                }
            }
        });
    }

    // ============================================
    // 2. EXPIRY STATUS - PIE CHART
    // ============================================
    const expiryStatusData = {
        labels: ['Safe (>30 days)', 'Near Expiry (≤30 days)', 'Expired'],
        values: [
            {{ ($statusDistribution['Available'] ?? 0) + ($statusDistribution['Low Stock'] ?? 0) }},
            {{ $statusDistribution['Near Expiry'] ?? 0 }},
            {{ $statusDistribution['Expired'] ?? 0 }}
        ]
    };

    if (document.getElementById('expiryStatusPieChart')) {
        new Chart(document.getElementById('expiryStatusPieChart'), {
            type: 'pie',
            data: {
                labels: expiryStatusData.labels,
                datasets: [{
                    data: expiryStatusData.values,
                    backgroundColor: ['#4caf50', '#ffc107', '#d32f2f'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 10, font: { size: 10 }, padding: 8 }
                    },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.label}: ${ctx.raw} items` } }
                }
            }
        });
    }

    // ============================================
    // 3. STOCK MOVEMENT - LINE CHART (REAL DATA)
    // ============================================
    const stockMovementData = @json($stockMovementData);  // ✅ TAMA NA

    if (document.getElementById('stockMovementLineChart')) {
        new Chart(document.getElementById('stockMovementLineChart'), {
            type: 'line',
            data: {
                labels: stockMovementData.labels.length ? stockMovementData.labels : ['No Data'],
                datasets: [
                    {
                        label: 'Stock Added',
                        data: stockMovementData.added.length ? stockMovementData.added : [0],
                        borderColor: '#4caf50',
                        backgroundColor: 'rgba(76, 175, 80, 0.1)',
                        tension: 0.4,
                        fill: false,
                        pointBackgroundColor: '#4caf50',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        borderWidth: 2
                    },
                    {
                        label: 'Stock Deducted',
                        data: stockMovementData.deducted.length ? stockMovementData.deducted : [0],
                        borderColor: '#f44336',
                        backgroundColor: 'rgba(244, 67, 54, 0.1)',
                        tension: 0.4,
                        fill: false,
                        pointBackgroundColor: '#f44336',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        borderWidth: 2
                    },
                    {
                        label: 'Net Movement',
                        data: stockMovementData.net.length ? stockMovementData.net : [0],
                        borderColor: '#0b7a33',
                        backgroundColor: 'rgba(11, 122, 51, 0.15)',
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#0b7a33',
                        pointBorderColor: '#fff',
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        borderWidth: 2,
                        borderDash: [5, 5]
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            boxWidth: 12,
                            font: { size: 10 },
                            padding: 8,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: (ctx) => `${ctx.dataset.label}: ${ctx.raw} pcs`
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { font: { size: 10 } },
                        title: {
                            display: true,
                            text: 'Pieces',
                            font: { size: 10 }
                        }
                    },
                    x: {
                        ticks: { font: { size: 10 } },
                        title: {
                            display: true,
                            text: 'Date',
                            font: { size: 10 }
                        }
                    }
                }
            }
        });
    }

    console.log('✅ Inventory Report charts loaded with REAL stock movement data!');
});
</script>
@endsection