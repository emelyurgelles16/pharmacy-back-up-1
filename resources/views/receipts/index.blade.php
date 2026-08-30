@php
// Helper function para ma-display ang customer type
function displayCustomerType($type) {
if (!$type || $type == 'walk_in' || $type == 'walk-in') {
return 'Walk-in';
}
// Convert snake_case to Proper Case with spaces
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
<div class="container-fluid px-3">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1"><i class="fas fa-receipt text-success"></i> Receipts History</h2>
                    <p class="text-muted mb-0">View and manage all sales transactions</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="card border-0 shadow-sm mb-4">
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

                <!-- Customer Type Filter -->
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

    <!-- Main Content -->
    <div class="row g-4">
        <!-- Left: Receipts List -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success">
                            <i class="fas fa-list"></i> Transaction List
                        </h5>
                        <span class="badge bg-success">{{ $sales->total() }} receipts</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div style="max-height: 68vh; overflow-y: auto;">
                        @forelse($sales as $sale)
                        <div class="receipt-item p-3 border-bottom border-light
                                    {{ $selectedSale && $selectedSale->id == $sale->id ? 'selected-receipt' : '' }}"
                            onclick="window.location.href='{{ route('receipts.index', ['selected' => $sale->id]) }}'"
                            style="cursor: pointer; transition: all 0.2s;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center mb-1">
                                        <div class="receipt-badge bg-primary text-white rounded-pill px-2 py-1 me-2"
                                            style="font-size: 10px; font-weight: 600; white-space: nowrap;">
                                            {{ $sale->invoice_no }}
                                        </div>
                                        <span class="badge bg-light text-dark border">
                                            {{ $sale->items_count ?? $sale->items->count() }} items
                                        </span>

                                        <!-- ✅ ADD CUSTOMER TYPE BADGE -->
                                        @if($sale->customer_type && $sale->customer_type != 'walk_in')
                                        <span class="badge bg-warning ms-1" style="font-size: 9px;">
                                            {{ ucfirst(str_replace('_', ' ', $sale->customer_type)) }}
                                        </span>
                                        @endif
                                    </div>

                                    <div class="d-flex align-items-center text-muted mb-1">
                                        <i class="far fa-calendar me-1" style="font-size: 12px;"></i>
                                        <small>{{ $sale->created_at->format('M d, Y') }}</small>
                                        <i class="far fa-clock ms-3 me-1" style="font-size: 12px;"></i>
                                        <small>{{ $sale->created_at->format('h:i A') }}</small>
                                    </div>

                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user-tie me-1 text-muted" style="font-size: 12px;"></i>
                                        <small class="text-muted">
                                            @php
                                            $cashier = DB::table('users')->where('id', $sale->user_id)->value('username');
                                            echo $cashier ?: ($sale->user_id ? 'Cashier #' . $sale->user_id : 'No Cashier');
                                            @endphp
                                        </small>
                                    </div>
                                </div>

                                <div class="text-end ms-2">
                                    <div class="fw-bold text-success fs-5">
                                        ₱{{ number_format($sale->total_amount, 2) }}
                                    </div>
                                    <small class="text-muted d-block">
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
                            <i class="fas fa-receipt fa-4x text-light mb-3"></i>
                            <h5 class="text-muted">No transactions found</h5>
                            <p class="text-muted">Start selling from POS to see receipts here</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($sales->hasPages())
                <div class="card-footer bg-white border-top py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted">
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
            <div class="card-header bg-white border-bottom py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Left: Title with invoice number -->
                    <div>
                        <h5 class="mb-0 fw-bold text-success">
                            <i class="fas fa-file-invoice"></i> Receipt Details
                        </h5>
                        @if($selectedSale)
                        <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                            Invoice: {{ $selectedSale->invoice_no }}
                        </p>
                        @endif
                    </div>

                    <!-- Right: Buttons (WALANG PRINT PREVIEW) -->
                    @if($selectedSale)
                    <div class="btn-group" role="group">
                        <!-- PRINT RECEIPT BUTTON ONLY -->
                        <a href="/receipts/{{ $selectedSale->id }}/print"
                            target="_blank"
                            class="btn btn-success btn-sm">
                            <i class="fas fa-receipt"></i> Print Receipt
                        </a>

                        <!-- COPY BUTTON -->
                        <button onclick="copyToClipboard('{{ $selectedSale->invoice_no }}')"
                            class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-copy"></i> Copy No.
                        </button>
                    </div>
                    @endif
                </div>
            </div>

           <div class="card-body p-4" style="max-height: 68vh; overflow-y: auto;">
    @if($selectedSale)
    <!-- Pharmacy Header -->
    <div class="text-center mb-4 pb-3 border-bottom">
        <h3 class="fw-bold text-success mb-2">{{ $pharmacy['name'] ?? 'ALPHAMED PHARMACY' }}</h3>
        
        @if(isset($pharmacy['address']) && $pharmacy['address'])
        <p class="text-muted mb-1">
            <i class="fas fa-map-marker-alt"></i> {{ $pharmacy['address'] }}
        </p>
        @endif
        
        @if(isset($pharmacy['contact']) && $pharmacy['contact'])
        <p class="text-muted mb-1">
            <i class="fas fa-phone-alt"></i> {{ $pharmacy['contact'] }}
        </p>
        @endif
        
        @if(isset($pharmacy['email']) && $pharmacy['email'])
        <p class="text-muted mb-1">
            <i class="fas fa-envelope"></i> {{ $pharmacy['email'] }}
        </p>
        @endif
        
        @if(isset($pharmacy['tin']) && $pharmacy['tin'])
        <p class="text-muted mb-3">
            <i class="fas fa-id-card"></i> TIN: {{ $pharmacy['tin'] }}
        </p>
        @endif
    </div>

                    <!-- Receipt Info -->
                    <div class="row g-3">
                        <div class="col-md-6 text-start">
                            <div class="bg-light p-2 rounded">
                                <small class="d-block text-muted">Customer Type</small>
                                <strong>
                                    @if($selectedSale->customer_type && $selectedSale->customer_type != 'walk_in')
                                    {{ ucfirst(str_replace('_', ' ', $selectedSale->customer_type)) }}
                                    @if($selectedSale->discount_percent > 0)
                                    <span class="badge bg-danger ms-1">
                                        {{ $selectedSale->discount_percent }}% OFF
                                    </span>
                                    @endif
                                    @else
                                    Walk-in Customer
                                    @endif
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6 text-start">
                            <div class="bg-light p-2 rounded">
                                <small class="d-block text-muted">Transaction Date</small>
                                <strong>{{ $selectedSale->created_at->format('M d, Y h:i A') }}</strong>
                            </div>
                        </div>
                        <div class="col-md-6 text-start">
                            <div class="bg-light p-2 rounded">
                                <small class="d-block text-muted">Cashier</small>
                                <strong>
                                    @php
                                    $cashier = DB::table('users')->where('id', $selectedSale->user_id)->value('username');
                                    echo $cashier ?: ($selectedSale->user_id ? 'Cashier #' . $selectedSale->user_id : 'No Cashier');
                                    @endphp
                                </strong>
                            </div>
                        </div>
                        <div class="col-md-6 text-start">
    <div class="bg-light p-2 rounded">
        <small class="d-block text-muted">ID Number Presented</small>
        <strong>{{ $selectedSale->id_number ?? 'N/A' }}</strong>
    </div>
</div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 text-success">
                        <i class="fas fa-shopping-cart"></i> Purchased Items
                    </h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th class="ps-3">#</th>
                                    <th>Product</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end pe-3">Unit Price</th>
                                    <th class="text-end pe-3">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                // Fallback kung wala ang items relationship
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
                                        <div class="fw-medium">{{ $item->product_name ?? $item->product->name ?? 'N/A' }}</div>
                                        <small class="text-muted">
                                            @if(isset($item->sell_type))
                                            {{ $item->sell_type == 'box' ? 'Box' : 'Piece' }}
                                            @if($item->sell_type == 'box' && isset($item->pieces_per_box))
                                            ({{ $item->pieces_per_box }} pcs/box)
                                            @endif
                                            @endif
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary rounded-pill px-3">
                                            {{ $item->quantity }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-3">
                                        ₱{{ number_format($item->unit_price, 2) }}
                                    </td>
                                    <td class="text-end pe-3 fw-bold">
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
                            <table class="table table-borderless">
                                <tr>
                                    <td class="text-end"><strong>Subtotal:</strong></td>
                                    <td class="text-end" width="150">
                                        ₱{{ number_format($selectedSale->subtotal, 2) }}
                                    </td>
                                </tr>
                                @if($selectedSale->discount > 0)
                                <tr>
                                    <td class="text-end text-danger">
                                        <i class="fas fa-tag"></i>
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
                                        <br><small>({{ $selectedSale->discount_percent }}%)</small>
                                        @endif
                                    </td>
                                </tr>
                                @endif
                                <tr class="border-top border-2">
                                    <td class="text-end fs-5"><strong>Total Amount:</strong></td>
                                    <td class="text-end fs-5 fw-bold text-success" width="150">
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
                    <p class="text-muted mb-1">
                        <i class="fas fa-shield-alt"></i> Thank you for your purchase!
                    </p>
                    <small class="text-muted">
                        This receipt is generated electronically. Valid for 30 days.
                    </small>
                </div>
                @else
                <!-- Empty State -->
                <div class="text-center py-5 my-5">
                    <div class="empty-state-icon mb-4">
                        <i class="fas fa-receipt fa-4x text-light"></i>
                        <div class="icon-bg"></div>
                    </div>
                    <h5 class="text-muted mb-2">No receipt selected</h5>
                    <p class="text-muted mb-4">
                        Select a transaction from the list to view receipt details
                    </p>
                    <div class="d-inline-block p-3 bg-light rounded">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Click any receipt on the left panel to view details
                        </small>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

<style>
    /* Custom Styles */
    .receipt-item:hover {
        background-color: #f8f9ff !important;
        transform: translateX(5px);
    }

    .selected-receipt {
        background-color: #e8f5e9 !important;
        border-left: 4px solid #0b7a33 !important;
        margin-left: -4px;
    }

    .receipt-badge {
        font-family: 'Courier New', monospace;
        letter-spacing: 0.5px;
    }

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

    .table-success {
        --bs-table-bg: #e8f5e9;
        --bs-table-border-color: #c8e6c9;
    }

    /* Print Styles */
    @media print {

        .col-lg-5,
        .card-header .btn,
        .user-info,
        .search-card {
            display: none !important;
        }

        .col-lg-7 {
            width: 100% !important;
            flex: 0 0 100% !important;
            max-width: 100% !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
        }

        .card-body {
            padding: 0 !important;
        }
    }
</style>

<script>
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // SweetAlert notification
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