@php
// Helper function para ma-display ang customer type
function displayCustomerType($type) {
    if (!$type || $type == 'walk_in' || $type == 'walk-in') {
        return 'Walk-in';
    }
    return ucwords(str_replace('_', ' ', $type));
}

// Helper para sa discount type display
function displayDiscountInfo($sale) {
    if ($sale->discount_percent > 0 && $sale->customer_type && $sale->customer_type != 'walk_in') {
        return displayCustomerType($sale->customer_type) . ' (' . $sale->discount_percent . '%)';
    }
    return 'No Discount';
}
@endphp

@extends('layouts.app')

@section('title', 'Receipts History')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - RECEIPTS HISTORY
       ============================================ */

    /* ===== HEADER BOX ===== */
    .header-box {
        background: linear-gradient(135deg, #056b28, #0a8a3a);
        color: #fff;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
        text-align: left;
        box-shadow: 0 4px 15px rgba(5, 107, 40, 0.3);
    }

    .header-box h2 {
        margin: 0;
        font-size: 26px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .header-box p {
        margin: 5px 0 0;
        font-size: 14px;
        opacity: 0.9;
    }

    /* ===== HEADER TITLE ===== */
    .header-title h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1a1a2e;
    }

    .header-title p {
        font-size: 14px;
        color: #6c757d;
        margin-bottom: 0;
    }

    /* ===== RECEIPT ITEMS ===== */
    .receipt-item {
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 12px 16px;
        border-bottom: 1px solid #f1f3f5;
    }

    .receipt-item:hover {
        background-color: #f8fdf8 !important;
        transform: translateX(4px);
    }

    .selected-receipt {
        background-color: #e8f5e9 !important;
        border-left: 4px solid #0b7a33 !important;
        margin-left: -4px;
    }

    .receipt-badge {
        font-family: 'Courier New', monospace;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.5px;
        background: #0b7a33;
        color: white;
        padding: 2px 10px;
        border-radius: 20px;
        white-space: nowrap;
    }

    /* ===== CARDS ===== */
    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .card-header {
        background: white;
        border-bottom: 1px solid #e9ecef;
        padding: 12px 20px;
    }

    .card-header h5 {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .card-body {
        padding: 20px;
    }

    /* ===== FILTERS ===== */
    .filter-card .form-control,
    .filter-card .form-select {
        font-size: 13px;
        border-radius: 6px;
        border: 1.5px solid #e0e0e0;
        padding: 6px 12px;
        height: 34px;
    }

    .filter-card .form-control:focus,
    .filter-card .form-select:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    .filter-card .input-group-text {
        font-size: 13px;
        background: #f8f9fa;
        border: 1.5px solid #e0e0e0;
        border-right: none;
        padding: 6px 10px;
    }

    .filter-card .form-control.border-start-0 {
        border-left: none;
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 5px 14px;
        border-radius: 6px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
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

    .btn-sm {
        font-size: 12px;
        padding: 4px 10px;
    }

    /* ===== TABLE ===== */
    .table {
        font-size: 13px;
        margin: 0;
    }

    .table thead th {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #495057;
        background: #e8f5e9;
        padding: 8px 12px;
        border-bottom: 2px solid #c8e6c9;
    }

    .table tbody td {
        font-size: 13px;
        padding: 8px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }

    .table tbody tr:hover {
        background: #f8fdf8;
    }

    .table-success {
        --bs-table-bg: #e8f5e9;
        --bs-table-border-color: #c8e6c9;
    }

    /* ===== BADGES ===== */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge.bg-success {
        background: #0b7a33 !important;
        color: white;
    }

    .badge.bg-warning {
        background: #ffc107 !important;
        color: #333;
    }

    .badge.bg-primary {
        background: #0b7a33 !important;
        color: white;
    }

    .badge.bg-light {
        background: #f8f9fa !important;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    /* ===== PAGINATION ===== */
    .pagination {
        display: flex;
        gap: 3px;
        margin: 0;
        padding: 0;
        list-style: none;
        align-items: center;
    }

    .pagination .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        height: 28px;
        padding: 0 8px;
        border: 1px solid #dee2e6;
        border-radius: 4px;
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

    /* ===== EMPTY STATE ===== */
    .empty-state-icon {
        position: relative;
        display: inline-block;
    }

    .empty-state-icon .icon-bg {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
        border-radius: 50%;
        z-index: -1;
    }

    .empty-state-icon i {
        font-size: 48px;
        opacity: 0.3;
        color: #0b7a33;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .header-box h2 {
            font-size: 20px;
        }
        .header-title h2 {
            font-size: 20px;
        }
        .filter-card .row {
            flex-direction: column;
            gap: 8px;
        }
        .filter-card .col-md-3,
        .filter-card .col-md-2 {
            width: 100%;
        }
        .filter-card .btn {
            width: 100%;
        }
        .card-body {
            padding: 12px;
        }
        .table thead th,
        .table tbody td {
            font-size: 12px;
            padding: 6px 8px;
        }
        .receipt-item {
            padding: 10px 12px;
        }
        .receipt-item .fs-5 {
            font-size: 16px !important;
        }
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
        }
        .header-box {
            padding: 15px 20px;
        }
        .header-title h2 {
            font-size: 18px;
        }
        .header-title p {
            font-size: 13px;
        }
        .card-header h5 {
            font-size: 14px;
        }
        .table {
            font-size: 12px;
        }
        .table thead th {
            font-size: 10px;
        }
        .badge {
            font-size: 10px;
            padding: 2px 8px;
        }
        .receipt-item .fs-5 {
            font-size: 14px !important;
        }
        .pagination .page-link {
            font-size: 12px;
            min-width: 24px;
            height: 24px;
            padding: 0 6px;
        }
    }
</style>

<!-- ===== HEADER BOX ===== -->
<div class="header-box">
    <h2><i class="fas fa-receipt me-2"></i> Receipts History</h2>
    <p>View and manage all sales transactions</p>
</div>

<div class="container-fluid px-3">
    <!-- ===== SEARCH & FILTERS ===== -->
    <div class="filter-card card border-0 shadow-sm mb-4">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('receipts.index') }}" class="row g-2 align-items-center">
                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" class="form-control border-start-0"
                            placeholder="Search receipt number..."
                            value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="customer_type" class="form-select form-select-sm">
                        <option value="all">All Customer Types</option>
                        <option value="walk_in" {{ request('customer_type') == 'walk_in' ? 'selected' : '' }}>Walk-in</option>
                        @foreach($discountTypes as $type)
                        <option value="{{ strtolower(str_replace(' ', '_', $type->name)) }}"
                            {{ request('customer_type') == strtolower(str_replace(' ', '_', $type->name)) ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="date" class="form-control form-control-sm"
                        name="date_from" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control form-control-sm"
                        name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                    <a href="{{ route('receipts.index') }}" class="btn btn-secondary btn-sm w-100 mt-1">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="row g-4">
        <!-- Left: Receipts List -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold text-success">
                            <i class="fas fa-list me-2"></i> Transaction List
                        </h5>
                        <span class="badge bg-success">{{ $sales->total() }} receipts</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div style="max-height: 68vh; overflow-y: auto;">
                        @forelse($sales as $sale)
                        <div class="receipt-item
                                    {{ $selectedSale && $selectedSale->id == $sale->id ? 'selected-receipt' : '' }}"
                            onclick="window.location.href='{{ route('receipts.index', ['selected' => $sale->id]) }}'">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1 flex-wrap">
                                        <span class="receipt-badge me-2">{{ $sale->invoice_no }}</span>
                                        <span class="badge bg-light text-dark border me-1" style="font-size: 11px;">
                                            {{ $sale->items_count ?? $sale->items->count() }} items
                                        </span>

                                        @if($sale->customer_type && $sale->customer_type != 'walk_in')
                                        <span class="badge bg-warning" style="font-size: 10px;">
                                            {{ ucfirst(str_replace('_', ' ', $sale->customer_type)) }}
                                        </span>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center text-muted mb-1" style="font-size: 12px;">
                                        <i class="far fa-calendar me-1"></i>
                                        <span>{{ $sale->created_at->format('M d, Y') }}</span>
                                        <i class="far fa-clock ms-3 me-1"></i>
                                        <span>{{ $sale->created_at->format('h:i A') }}</span>
                                    </div>

                                    <div class="d-flex align-items-center" style="font-size: 12px;">
                                        <i class="fas fa-user-tie me-1 text-muted"></i>
                                        <span class="text-muted">
                                            @php
                                            $cashier = DB::table('users')->where('id', $sale->user_id)->value('username');
                                            echo $cashier ?: ($sale->user_id ? 'Cashier #' . $sale->user_id : 'No Cashier');
                                            @endphp
                                        </span>
                                    </div>
                                </div>

                                <div class="text-end ms-2">
                                    <div class="fw-bold text-success" style="font-size: 18px;">
                                        ₱{{ number_format($sale->total_amount, 2) }}
                                    </div>
                                    <small class="text-muted d-block" style="font-size: 11px;">
                                        @if($sale->discount > 0)
                                        <span class="text-danger">
                                            -₱{{ number_format($sale->discount, 2) }} discount
                                            @if($sale->discount_percent > 0)
                                            ({{ $sale->discount_percent }}%)
                                            @endif
                                            @if($sale->customer_type && $sale->customer_type != 'walk_in')
                                            <span class="text-warning">
                                                [{{ ucfirst(str_replace('_', ' ', $sale->customer_type)) }}]
                                            </span>
                                            @endif
                                        </span>
                                        @else
                                        No discount
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-4x text-light mb-3 opacity-25"></i>
                            <h5 class="text-muted" style="font-size: 18px;">No transactions found</h5>
                            <p class="text-muted" style="font-size: 14px;">Start selling from POS to see receipts here</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($sales->hasPages())
                <div class="card-footer bg-white border-top py-2">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <small class="text-muted" style="font-size: 13px;">
                            Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} entries
                        </small>
                        <div>
                            {{ $sales->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Right: Receipt Details -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold text-success">
                                <i class="fas fa-file-invoice me-2"></i> Receipt Details
                            </h5>
                            @if($selectedSale)
                            <p class="mb-0 text-muted" style="font-size: 13px;">
                                Invoice: {{ $selectedSale->invoice_no }}
                            </p>
                            @endif
                        </div>

                        @if($selectedSale)
                        <div class="btn-group" role="group">
                            <a href="/receipts/{{ $selectedSale->id }}/print"
                                target="_blank"
                                class="btn btn-success btn-sm">
                                <i class="fas fa-receipt me-1"></i> Print Receipt
                            </a>
                            <button onclick="copyToClipboard('{{ $selectedSale->invoice_no }}')"
                                class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-copy me-1"></i> Copy No.
                            </button>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card-body p-4" style="max-height: 68vh; overflow-y: auto;">
                    @if($selectedSale)
                    <!-- Pharmacy Header -->
                    <div class="text-center mb-4 pb-3 border-bottom">
                        <h3 class="fw-bold text-success mb-2" style="font-size: 22px;">
                            {{ $pharmacy['name'] ?? 'ALPHAMED PHARMACY' }}
                        </h3>

                        @if(isset($pharmacy['address']) && $pharmacy['address'])
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <i class="fas fa-map-marker-alt me-1"></i> {{ $pharmacy['address'] }}
                        </p>
                        @endif

                        @if(isset($pharmacy['contact']) && $pharmacy['contact'])
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <i class="fas fa-phone-alt me-1"></i> {{ $pharmacy['contact'] }}
                        </p>
                        @endif

                        @if(isset($pharmacy['email']) && $pharmacy['email'])
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <i class="fas fa-envelope me-1"></i> {{ $pharmacy['email'] }}
                        </p>
                        @endif

                        @if(isset($pharmacy['tin']) && $pharmacy['tin'])
                        <p class="text-muted mb-3" style="font-size: 13px;">
                            <i class="fas fa-id-card me-1"></i> TIN: {{ $pharmacy['tin'] }}
                        </p>
                        @endif
                    </div>

                    <!-- Receipt Info -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="bg-light p-2 rounded" style="font-size: 13px;">
                                <small class="d-block text-muted" style="font-size: 11px;">Customer Type</small>
                                <strong>
                                    @if($selectedSale->customer_type && $selectedSale->customer_type != 'walk_in')
                                    {{ ucfirst(str_replace('_', ' ', $selectedSale->customer_type)) }}
                                    @if($selectedSale->discount_percent > 0)
                                    <span class="badge bg-danger ms-1" style="font-size: 11px;">
                                        {{ $selectedSale->discount_percent }}% OFF
                                    </span>
                                    @endif
                                    @else
                                    Walk-in Customer
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-2 rounded" style="font-size: 13px;">
                                <small class="d-block text-muted" style="font-size: 11px;">Transaction Date</small>
                                <strong>{{ $selectedSale->created_at->format('M d, Y h:i A') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-2 rounded" style="font-size: 13px;">
                                <small class="d-block text-muted" style="font-size: 11px;">Cashier</small>
                                <strong>
                                    @php
                                    $cashier = DB::table('users')->where('id', $selectedSale->user_id)->value('username');
                                    echo $cashier ?: ($selectedSale->user_id ? 'Cashier #' . $selectedSale->user_id : 'No Cashier');
                                    @endphp
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-2 rounded" style="font-size: 13px;">
                                <small class="d-block text-muted" style="font-size: 11px;">ID Number Presented</small>
                                <strong>{{ $selectedSale->id_number ?? 'N/A' }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3 text-success" style="font-size: 15px;">
                            <i class="fas fa-shopping-cart me-2"></i> Purchased Items
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th class="ps-3" style="width: 40px;">#</th>
                                        <th>Product</th>
                                        <th class="text-center" style="width: 60px;">Qty</th>
                                        <th class="text-end pe-3" style="width: 100px;">Unit Price</th>
                                        <th class="text-end pe-3" style="width: 120px;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    if (!isset($selectedSale->items) || $selectedSale->items->isEmpty()) {
                                        $items = \DB::table('sale_items')
                                            ->where('sale_id', $selectedSale->id)
                                            ->join('products', 'sale_items.product_id', '=', 'products.id')
                                            ->select('sale_items.*', 'products.name as product_name')
                                            ->get();
                                    } else {
                                        $items = $selectedSale->items;
                                    }
                                    @endphp

                                    @foreach($items as $index => $item)
                                    <tr>
                                        <td class="ps-3">{{ $index + 1 }}</td>
                                        <td>
                                            <div class="fw-medium" style="font-size: 13px;">
                                                {{ $item->product_name ?? $item->product->name ?? 'N/A' }}
                                            </div>
                                            <small class="text-muted" style="font-size: 11px;">
                                                @if(isset($item->sell_type))
                                                {{ $item->sell_type == 'box' ? 'Box' : 'Piece' }}
                                                @if($item->sell_type == 'box' && isset($item->pieces_per_box))
                                                ({{ $item->pieces_per_box }} pcs/box)
                                                @endif
                                                @endif
                                            </small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill px-3" style="font-size: 12px;">
                                                {{ $item->quantity }}
                                            </span>
                                        </td>
                                        <td class="text-end pe-3" style="font-size: 13px;">
                                            ₱{{ number_format($item->unit_price, 2) }}
                                        </td>
                                        <td class="text-end pe-3 fw-bold" style="font-size: 13px;">
                                            ₱{{ number_format($item->total_price, 2) }}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Totals -->
                    <div class="border-top pt-4">
                        <div class="row justify-content-end">
                            <div class="col-md-8">
                                <table class="table table-borderless" style="font-size: 13px;">
                                    <tr>
                                        <td class="text-end"><strong>Subtotal:</strong></td>
                                        <td class="text-end" width="150">
                                            ₱{{ number_format($selectedSale->subtotal, 2) }}
                                        </td>
                                    </tr>
                                    @if($selectedSale->discount > 0)
                                    <tr>
                                        <td class="text-end text-danger">
                                            <i class="fas fa-tag me-1"></i>
                                            <strong>
                                                Discount
                                                @if($selectedSale->customer_type && $selectedSale->customer_type != 'walk_in')
                                                ({{ ucfirst(str_replace('_', ' ', $selectedSale->customer_type)) }})
                                                @endif
                                                :
                                            </strong>
                                        </td>
                                        <td class="text-end text-danger" width="150">
                                            -₱{{ number_format($selectedSale->discount, 2) }}
                                            @if($selectedSale->discount_percent > 0)
                                            <br><small style="font-size: 11px;">({{ $selectedSale->discount_percent }}%)</small>
                                            @endif
                                        </td>
                                    </tr>
                                    @endif
                                    <tr class="border-top border-2">
                                        <td class="text-end" style="font-size: 17px;"><strong>Total Amount:</strong></td>
                                        <td class="text-end fw-bold text-success" width="150" style="font-size: 17px;">
                                            ₱{{ number_format($selectedSale->total_amount, 2) }}
                                        </td>
                                    </tr>
                                    @if($selectedSale->cash_tendered > 0)
                                    <tr>
                                        <td class="text-end">Cash Tendered:</td>
                                        <td class="text-end" width="150">
                                            ₱{{ number_format($selectedSale->cash_tendered, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end"><strong>Change:</strong></td>
                                        <td class="text-end fw-bold" width="150">
                                            ₱{{ number_format($selectedSale->change, 2) }}
                                        </td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-5 pt-3 border-top">
                        <p class="text-muted mb-1" style="font-size: 13px;">
                            <i class="fas fa-shield-alt me-1"></i> Thank you for your purchase!
                        </p>
                        <small class="text-muted" style="font-size: 12px;">
                            This receipt is generated electronically. Valid for 30 days.
                        </small>
                    </div>
                    @else
                    <!-- Empty State -->
                    <div class="text-center py-5 my-5">
                        <div class="empty-state-icon mb-4">
                            <i class="fas fa-receipt"></i>
                            <div class="icon-bg"></div>
                        </div>
                        <h5 class="text-muted mb-2" style="font-size: 18px;">No receipt selected</h5>
                        <p class="text-muted mb-4" style="font-size: 14px;">
                            Select a transaction from the list to view receipt details
                        </p>
                        <div class="d-inline-block p-3 bg-light rounded" style="font-size: 13px;">
                            <i class="fas fa-info-circle me-1"></i>
                            Click any receipt on the left panel to view details
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Receipt number copied: ' + text,
                timer: 1500,
                showConfirmButton: false,
                position: 'top-end',
                toast: true
            });
        });
    }
</script>
@endsection