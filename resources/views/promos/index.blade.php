@extends('layouts.app')

@section('title', 'Promo Management - Pharmacy System')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - PROMO MANAGEMENT
       ============================================ */

    /* ===== HEADER BOX ===== */
    .header-box {
        background: linear-gradient(135deg, #198754, #157347);
        border-radius: 12px;
        padding: 20px 30px;
        margin-bottom: 30px;
        text-align: left;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .header-box h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 700;
        color: #ffffff;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .header-box h2 i {
        margin-right: 8px;
    }

    /* ===== TOOLBAR ===== */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px;
        background: white;
        padding: 12px 18px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }

    .toolbar-left {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .toolbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .toolbar label {
        font-size: 13px;
        font-weight: 500;
        color: #333;
        white-space: nowrap;
        margin-right: 4px;
    }

    .toolbar select,
    .toolbar input {
        padding: 6px 12px;
        border-radius: 6px;
        border: 1.5px solid #e0e0e0;
        font-size: 13px;
        outline: none;
        height: 34px;
        background: white;
        box-sizing: border-box;
    }

    .toolbar input {
        width: 200px;
    }

    .toolbar select:focus,
    .toolbar input:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
    }

    /* ===== RESET BUTTON ===== */
    .btn-reset {
        background: #f8f9fa;
        color: #6c757d;
        border: 1.5px solid #e0e0e0;
        padding: 6px 14px;
        border-radius: 6px;
        font-weight: 500;
        font-size: 13px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 34px;
        white-space: nowrap;
    }

    .btn-reset:hover {
        background: #e53935;
        color: white;
        border-color: #e53935;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(229, 57, 53, 0.3);
    }

    .btn-reset:active {
        transform: translateY(0);
    }

    .btn-add {
        background: #0b7a33;
        color: white;
        border: none;
        padding: 6px 18px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        height: 34px;
        white-space: nowrap;
    }

    .btn-add:hover {
        background: #056b28;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(11, 122, 51, 0.3);
    }

    /* ===== FILTER GROUP ===== */
    .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        background: #f8f9fa;
        padding: 4px 12px 4px 8px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .filter-group label {
        font-size: 12px;
        font-weight: 600;
        color: #495057;
        margin-right: 2px;
    }

    .filter-group select {
        border: none;
        background: transparent;
        padding: 4px 8px;
        height: 30px;
        font-size: 12px;
        cursor: pointer;
        min-width: 120px;
    }

    .filter-group select:focus {
        box-shadow: none;
        border: none;
    }

    .filter-divider {
        width: 1px;
        height: 28px;
        background: #dee2e6;
    }

    /* ===== SEARCH GROUP ===== */
    .search-group {
        display: flex;
        align-items: center;
        gap: 6px;
        background: #f8f9fa;
        padding: 4px 12px 4px 8px;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .search-group label {
        font-size: 12px;
        font-weight: 600;
        color: #495057;
    }

    .search-group input {
        border: none;
        background: transparent;
        padding: 4px 8px;
        height: 30px;
        font-size: 12px;
        width: 180px;
    }

    .search-group input:focus {
        box-shadow: none;
        border: none;
    }

    .search-group input::placeholder {
        color: #adb5bd;
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
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 10px 14px;
        border-bottom: 2px solid #e9ecef;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 10px 14px;
        vertical-align: middle;
        font-size: 13px;
        border-bottom: 1px solid #f1f3f5;
    }

    .table tbody tr:hover {
        background: #f8fdf8;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Status-based row colors */
    .table-active {
        background-color: rgba(46, 125, 50, 0.04) !important;
        border-left: 4px solid #28a745;
    }

    .table-expired {
        background-color: rgba(108, 117, 125, 0.04) !important;
        border-left: 4px solid #6c757d;
    }

    .table-upcoming {
        background-color: rgba(255, 152, 0, 0.04) !important;
        border-left: 4px solid #ff9800;
    }

    /* ===== BADGES ===== */
    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 11px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge.bg-success { background: #28a745 !important; color: white; }
    .badge.bg-secondary { background: #6c757d !important; color: white; }
    .badge.bg-warning { background: #ffc107 !important; color: #333; }
    .badge.bg-danger { background: #dc3545 !important; color: white; }

    .discount-badge {
        text-align: center;
    }

    .discount-badge .badge {
        font-size: 13px;
        padding: 4px 14px;
        background: #0b7a33;
        color: white;
        border-radius: 20px;
    }

    .reason-badge {
        display: inline-block;
        padding: 3px 12px;
        background: #e8f5e9;
        color: #0b7a33;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
    }

    /* ===== CARD ===== */
    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .card-header {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 12px 20px !important;
        border: none;
    }

    .card-header h6 {
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }

    .card-header small {
        font-size: 12px;
        opacity: 0.85;
        display: block;
        margin-top: 2px;
    }

    .card-body {
        padding: 0 !important;
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
        gap: 4px;
    }

    .btn-group .btn {
        font-size: 12px;
        padding: 4px 10px;
        margin-right: 3px;
        border-radius: 6px;
    }

    .btn-purple-edit {
        background: #ff9800;
        border-color: #ff9800;
        color: white;
    }

    .btn-purple-edit:hover {
        background: #f57c00;
        border-color: #f57c00;
        color: white;
    }

    .btn-purple-delete {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .btn-purple-delete:hover {
        background: #c82333;
        border-color: #c82333;
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

    /* ===== MODAL ===== */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 14px 20px;
        border-radius: 12px 12px 0 0;
        border-bottom: none;
    }

    .modal-header .modal-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
    }

    .modal-body {
        padding: 20px 25px;
    }

    .modal-body .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .modal-body .form-control,
    .modal-body .form-select {
        font-size: 13px;
        border-radius: 6px;
        border: 1.5px solid #e0e0e0;
        padding: 6px 12px;
        height: 36px;
        width: 100%;
    }

    .modal-body .form-control:focus,
    .modal-body .form-select:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    .modal-body .form-text {
        font-size: 12px;
        color: #6c757d;
        margin-top: 3px;
    }

    .modal-body .form-check-label {
        font-size: 13px;
        font-weight: 500;
    }

    .modal-footer {
        padding: 12px 20px;
        border-top: 1px solid #e9ecef;
        background: #fafafa;
        border-radius: 0 0 12px 12px;
    }

    .modal-footer .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 6px;
    }

    /* ===== NOTIFICATION ===== */
    #notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 10px;
        color: #fff;
        display: none;
        z-index: 10000;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        font-weight: 600;
        font-size: 13px;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from { transform: translateY(-20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* ===== PRICE PREVIEW ===== */
    #pricePreview {
        border-left: 3px solid #0b7a33;
        background: #f8fdf8;
        padding: 8px 14px;
        border-radius: 6px;
        margin-top: 6px;
        font-size: 13px;
    }

    .text-purple {
        color: #0b7a33 !important;
    }

    /* ===== EMPTY STATE ===== */
    .empty-state {
        text-align: center;
        padding: 50px 20px;
        color: #adb5bd;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 12px;
        opacity: 0.3;
        color: #0b7a33;
    }

    .empty-state h5 {
        font-size: 18px;
        font-weight: 600;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .empty-state p {
        font-size: 14px;
        color: #adb5bd;
        margin-bottom: 8px;
    }

    .very-small {
        font-size: 11px;
        color: #6c757d;
    }

    /* ===== ACTIVE FILTERS DISPLAY ===== */
    .active-filters {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        margin-top: 8px;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px dashed #d0d0d0;
        min-height: 36px;
        align-items: center;
    }

    .active-filters .filter-tag {
        background: #e8f5e9;
        color: #1b5e20;
        padding: 3px 12px;
        border-radius: 16px;
        font-size: 12px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 6px;
        border: 1px solid #a5d6a7;
    }

    .active-filters .filter-tag .remove-tag {
        cursor: pointer;
        font-weight: 700;
        color: #666;
        transition: color 0.2s;
    }

    .active-filters .filter-tag .remove-tag:hover {
        color: #e53935;
    }

    .active-filters .no-filters {
        color: #999;
        font-size: 13px;
        font-style: italic;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .header-box {
            padding: 16px 20px;
        }
        .header-box h2 {
            font-size: 20px;
        }
        .toolbar {
            flex-direction: column;
            align-items: stretch;
        }
        .toolbar-left,
        .toolbar-right {
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
        }
        .filter-group {
            flex-wrap: wrap;
        }
        .filter-group select {
            width: 100%;
        }
        .search-group input {
            width: 100%;
        }
        .btn-reset,
        .btn-add {
            width: 100%;
            justify-content: center;
        }
        .btn-group {
            flex-direction: column;
        }
        .btn-group .btn {
            margin-right: 0;
            margin-bottom: 3px;
        }
        .table thead th,
        .table tbody td {
            padding: 6px 8px;
            font-size: 12px;
        }
        .modal-body {
            padding: 15px;
        }
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
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
        .discount-badge .badge {
            font-size: 11px;
            padding: 2px 10px;
        }
        .reason-badge {
            font-size: 11px;
            padding: 2px 8px;
        }
        .modal-header .modal-title {
            font-size: 16px;
        }
        .empty-state h5 {
            font-size: 16px;
        }
    }
</style>

<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="header-box">
        <h2>
            <i class="fa-solid fa-percentage"></i>
            Promo Management
        </h2>
    </div>

    <!-- ===== TOOLBAR ===== -->
    <div class="toolbar">
        <div class="toolbar-left">
            <!-- Filter Group -->
            <div class="filter-group">
                <label><i class="fa-solid fa-filter"></i> Filter:</label>
                <select id="filterStatus">
                    <option value="all">All Promos</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive</option>
                    <option value="expired">Expired</option>
                    <option value="upcoming">Upcoming</option>
                </select>
            </div>

            <div class="filter-divider"></div>

            <!-- Search Group -->
            <div class="search-group">
                <label><i class="fa-solid fa-search"></i></label>
                <input type="text" id="searchBox" placeholder="Search product or reason...">
            </div>

            <div class="filter-divider"></div>

            <!-- Reset Button -->
            <button class="btn-reset" id="resetFilters">
                <i class="fa-solid fa-rotate-right"></i> Reset
            </button>
        </div>

        <div class="toolbar-right">
            <button id="addPromoBtn" class="btn-add">
                <i class="fa-solid fa-plus"></i> Add New Promo
            </button>
        </div>
    </div>

    <!-- ===== ACTIVE FILTERS DISPLAY ===== -->
    <div class="active-filters" id="activeFiltersDisplay">
        <span class="no-filters">No active filters</span>
    </div>

    <!-- ===== TABLE ===== -->
    <div class="card shadow mb-4">
        <div class="card-header">
            <h6><i class="fa-solid fa-list"></i> All Promos</h6>
            <small id="promoCount">{{ $promos->count() }} promos found</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="promosTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style="width: 25%;">Product</th>
                            <th style="width: 15%;">Discount</th>
                            <th style="width: 20%;">Duration</th>
                            <th style="width: 15%;">Reason</th>
                            <th style="width: 10%;">Status</th>
                            <th style="width: 10%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="promosTableBody">
                        @forelse($promos as $promo)
                        @php
                            $isActive = $promo->is_active && now()->between($promo->start_date, $promo->end_date);
                            $isExpired = now()->greaterThan($promo->end_date);
                            $isUpcoming = now()->lessThan($promo->start_date);

                            $originalPrice = $promo->product->price ?? 0;
                            $discountedPrice = $originalPrice - ($originalPrice * $promo->discount_percent / 100);
                        @endphp
                        <tr id="promo-{{ $promo->id }}"
                            class="@if($isExpired) table-expired @elseif($isUpcoming) table-upcoming @elseif($isActive) table-active @endif"
                            data-status="@if($isActive) active @elseif($isExpired) expired @elseif($isUpcoming) upcoming @else inactive @endif">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div style="width: 36px; height: 36px; background: #f5f5f5; border-radius: 6px;
                                                display: flex; align-items: center; justify-content: center;
                                                margin-right: 10px; color: #0b7a33; flex-shrink: 0;">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <div>
                                        <strong style="font-size: 13px;">{{ $promo->product->name ?? 'Product Deleted' }}</strong>
                                        <div class="small text-muted" style="font-size: 11px;">
                                            Original: ₱{{ number_format($originalPrice, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="discount-badge">
                                    <span class="badge" style="background: #0b7a33; color: white; font-size: 13px; padding: 4px 14px; border-radius: 20px;">
                                        {{ $promo->discount_percent }}% OFF
                                    </span>
                                    <div class="small text-muted mt-1" style="font-size: 12px;">
                                        New Price: <strong>₱{{ number_format($discountedPrice, 2) }}</strong>
                                    </div>
                                    <div class="very-small">Save: ₱{{ number_format($originalPrice - $discountedPrice, 2) }}</div>
                                </div>
                            </td>
                            <td>
                                <div style="text-align: center;">
                                    <div><strong style="font-size: 13px;">{{ $promo->start_date->format('M d, Y') }}</strong></div>
                                    <div class="small text-muted" style="font-size: 11px;">to</div>
                                    <div><strong style="font-size: 13px;">{{ $promo->end_date->format('M d, Y') }}</strong></div>
                                    @if(!$isExpired)
                                    <div class="very-small mt-1">{{ $promo->start_date->diffInDays($promo->end_date) }} days total</div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($promo->reason)
                                <span class="reason-badge">{{ $promo->reason }}</span>
                                @else
                                <span class="text-muted" style="font-size: 12px;">-</span>
                                @endif
                            </td>
                            <td>
                                @if($isActive)
                                <span class="badge bg-success"><i class="fa-solid fa-circle-play"></i> Active</span>
                                @elseif($isExpired)
                                <span class="badge bg-secondary"><i class="fa-solid fa-clock"></i> Expired</span>
                                @elseif($isUpcoming)
                                <span class="badge bg-warning" style="color: #333;"><i class="fa-solid fa-calendar-plus"></i> Upcoming</span>
                                @else
                                <span class="badge bg-danger"><i class="fa-solid fa-ban"></i> Inactive</span>
                                @endif

                                @if($isActive)
                                <div class="very-small mt-1">Ends in {{ now()->diffInDays($promo->end_date) }} days</div>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-purple-edit btn-edit"
                                            data-id="{{ $promo->id }}"
                                            data-product_id="{{ $promo->product_id }}"
                                            data-discount_percent="{{ $promo->discount_percent }}"
                                            data-start_date="{{ $promo->start_date->format('Y-m-d') }}"
                                            data-end_date="{{ $promo->end_date->format('Y-m-d') }}"
                                            data-reason="{{ $promo->reason }}"
                                            data-is_active="{{ $promo->is_active ? '1' : '0' }}">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-purple-delete btn-delete"
                                            data-id="{{ $promo->id }}"
                                            data-product="{{ $promo->product->name ?? 'Promo' }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <i class="fa-solid fa-percentage"></i>
                                    <h5>No promos found</h5>
                                    <p>Create your first promo to boost sales!</p>
                                    <button id="addPromoBtnEmpty" class="btn" style="background: #0b7a33; color: white; padding: 6px 20px; border-radius: 6px; font-size: 13px; border: none; cursor: pointer;">
                                        <i class="fa-solid fa-plus"></i> Add New Promo
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ===== ADD PROMO MODAL ===== -->
<div class="modal fade" id="addPromoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Add New Promo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addPromoForm" method="POST" action="{{ route('promos.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                            <select class="form-select" id="product_id" name="product_id" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - ₱{{ number_format($product->price, 2) }}
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">Only products with available stock are listed</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="discount_percent" class="form-label">Discount Percentage <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number"
                                       class="form-control"
                                       id="discount_percent"
                                       name="discount_percent"
                                       min="1"
                                       max="90"
                                       value="10"
                                       required>
                                <span class="input-group-text" style="background: #0b7a33; color: white; border: none;">%</span>
                            </div>
                            <div class="form-text">Discount amount (1-90%)</div>
                            <div id="pricePreview" style="display: none;">
                                <small>Original: <span id="originalPrice">₱0.00</span> |
                                Discounted: <span id="discountedPrice" class="text-purple fw-bold">₱0.00</span></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control"
                                   id="start_date"
                                   name="start_date"
                                   value="{{ date('Y-m-d') }}"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control"
                                   id="end_date"
                                   name="end_date"
                                   value="{{ date('Y-m-d', strtotime('+7 days')) }}"
                                   required>
                            <div class="form-text">Must be after start date</div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="reason" class="form-label">Promo Reason</label>
                        <div class="row">
                            <div class="col-md-6">
                                <select class="form-select" id="reasonSelect" name="reason">
                                    <option value="">Select Common Reason</option>
                                    <option value="Near expiry">Near Expiry</option>
                                    <option value="Overstock">Overstock</option>
                                    <option value="Seasonal">Seasonal</option>
                                    <option value="Holiday">Holiday</option>
                                    <option value="Clearance">Clearance</option>
                                    <option value="New Product">New Product</option>
                                    <option value="Anniversary">Anniversary</option>
                                    <option value="other">Other (specify below)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="text"
                                       class="form-control"
                                       id="reasonCustom"
                                       name="reason_custom"
                                       placeholder="Enter custom reason"
                                       style="display: none;">
                            </div>
                        </div>
                        <div class="form-text">Optional: Helps identify promo purpose</div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               class="form-check-input"
                               id="is_active"
                               name="is_active"
                               checked>
                        <label class="form-check-label" for="is_active">
                            Activate promo immediately
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: #0b7a33; color: white; border: none; padding: 8px 20px; border-radius: 6px;">
                        <i class="fa-solid fa-plus"></i> Add Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== EDIT PROMO MODAL ===== -->
<div class="modal fade" id="editPromoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #ff9800, #f57c00);">
                <h5 class="modal-title"><i class="fa-solid fa-edit"></i> Edit Promo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editPromoForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_product_id" class="form-label">Product</label>
                            <select class="form-select" id="edit_product_id" name="product_id" disabled>
                                <option value="">Loading...</option>
                            </select>
                            <div class="form-text">Product cannot be changed</div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_discount_percent" class="form-label">Discount Percentage <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number"
                                       class="form-control"
                                       id="edit_discount_percent"
                                       name="discount_percent"
                                       min="1"
                                       max="90"
                                       required>
                                <span class="input-group-text" style="background: #ff9800; color: white; border: none;">%</span>
                            </div>
                            <div class="form-text">Discount amount (1-90%)</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control"
                                   id="edit_start_date"
                                   name="start_date"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="edit_end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date"
                                   class="form-control"
                                   id="edit_end_date"
                                   name="end_date"
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_reason" class="form-label">Promo Reason</label>
                        <input type="text"
                               class="form-control"
                               id="edit_reason"
                               name="reason"
                               placeholder="Enter reason">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               class="form-check-input"
                               id="edit_is_active"
                               name="is_active">
                        <label class="form-check-label" for="edit_is_active">
                            Activate promo
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn" style="background: #ff9800; color: white; border: none; padding: 8px 20px; border-radius: 6px;">
                        <i class="fa-solid fa-save"></i> Update Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== NOTIFICATION ===== -->
<div id="notification"></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // ============================================
    // ACTIVE FILTERS TRACKING
    // ============================================
    let activeFilters = {
        search: '',
        status: 'all'
    };

    // ============================================
    // UPDATE ACTIVE FILTERS DISPLAY
    // ============================================
    function updateActiveFiltersDisplay() {
        let container = $('#activeFiltersDisplay');
        container.empty();

        let hasFilter = false;
        let filterMap = {
            search: { label: 'Search', value: activeFilters.search },
            status: { label: 'Status', value: activeFilters.status }
        };

        Object.keys(filterMap).forEach(function(key) {
            if (filterMap[key].value && filterMap[key].value !== 'all' && filterMap[key].value.trim() !== '') {
                hasFilter = true;
                let tag = $(`<span class="filter-tag">
                    ${filterMap[key].label}: ${filterMap[key].value}
                    <span class="remove-tag" data-filter="${key}">×</span>
                </span>`);
                container.append(tag);
            }
        });

        if (!hasFilter) {
            container.html('<span class="no-filters">No active filters</span>');
        }
    }

    // ============================================
    // REMOVE FILTER TAG
    // ============================================
    $(document).on('click', '.remove-tag', function() {
        let filterKey = $(this).data('filter');

        if (filterKey === 'search') {
            activeFilters.search = '';
            $('#searchBox').val('');
        } else if (filterKey === 'status') {
            activeFilters.status = 'all';
            $('#filterStatus').val('all');
        }

        updateActiveFiltersDisplay();
        applyFilters();
    });

    // ============================================
    // SEARCH - LIVE SEARCH (first letter palang)
    // ============================================
    $('#searchBox').on('keyup', function() {
        activeFilters.search = this.value.trim();
        updateActiveFiltersDisplay();
        applyFilters();
    });

    // ============================================
    // FILTER
    // ============================================
    $('#filterStatus').on('change', function() {
        activeFilters.status = this.value;
        updateActiveFiltersDisplay();
        applyFilters();
    });

    // ============================================
    // APPLY FILTERS
    // ============================================
    function applyFilters() {
        const searchTerm = activeFilters.search.toLowerCase();
        const statusFilter = activeFilters.status;
        let visibleCount = 0;

        $('#promosTableBody tr').each(function() {
            if ($(this).find('.empty-state').length) {
                $(this).toggle(true);
                return;
            }

            let show = true;

            // Search filter
            if (searchTerm) {
                const productName = $(this).find('td:eq(1)').text().toLowerCase();
                const reason = $(this).find('td:eq(4)').text().toLowerCase();
                if (!productName.includes(searchTerm) && !reason.includes(searchTerm)) {
                    show = false;
                }
            }

            // Status filter
            if (statusFilter !== 'all' && show) {
                const statusText = $(this).find('td:eq(5)').text().toLowerCase();
                let statusMatch = false;

                switch(statusFilter) {
                    case 'active': statusMatch = statusText.includes('active'); break;
                    case 'inactive': statusMatch = statusText.includes('inactive'); break;
                    case 'expired': statusMatch = statusText.includes('expired'); break;
                    case 'upcoming': statusMatch = statusText.includes('upcoming'); break;
                    default: statusMatch = true;
                }

                if (!statusMatch) show = false;
            }

            $(this).toggle(show);
            if (show) visibleCount++;
        });

        // Update count
        $('#promoCount').text(visibleCount + ' promos found');
    }

    // ============================================
    // RESET FILTERS
    // ============================================
    $('#resetFilters').on('click', function() {
        // Reset values
        activeFilters.search = '';
        activeFilters.status = 'all';

        // Reset inputs
        $('#searchBox').val('');
        $('#filterStatus').val('all');

        // Update display
        updateActiveFiltersDisplay();

        // Apply filters
        applyFilters();

        // Show notification
        showNotification('Filters have been reset', 'success');
    });

    // ============================================
    // NOTIFICATION
    // ============================================
    function showNotification(msg, type = 'success') {
        const el = document.getElementById('notification');
        const colors = {
            success: '#0b7a33',
            created: '#0b7a33',
            updated: '#ff9800',
            deleted: '#dc3545',
            error: '#dc3545',
            warning: '#ff9800'
        };

        const icons = {
            success: 'fa-check-circle',
            created: 'fa-circle-plus',
            updated: 'fa-pen-to-square',
            deleted: 'fa-trash',
            error: 'fa-circle-exclamation',
            warning: 'fa-triangle-exclamation'
        };

        el.style.background = colors[type] || colors.success;
        el.innerHTML = `<i class="fa-solid ${icons[type] || icons.success} me-2"></i> ${msg}`;
        el.style.display = 'block';
        el.style.opacity = 1;

        setTimeout(() => {
            el.style.opacity = 0;
            setTimeout(() => el.style.display = 'none', 300);
        }, 3000);
    }

    // ============================================
    // OPEN ADD MODAL
    // ============================================
    function openAddModal() {
        $('#addPromoForm')[0].reset();
        $('#pricePreview').hide();
        $('#reasonCustom').hide();
        $('#is_active').prop('checked', true);
        new bootstrap.Modal(document.getElementById('addPromoModal')).show();
    }

    $('#addPromoBtn').on('click', openAddModal);
    $('#addPromoBtnEmpty').on('click', openAddModal);

    // ============================================
    // PRICE PREVIEW
    // ============================================
    $('#product_id, #discount_percent').on('change input', function() {
        const selectedOption = $('#product_id option:selected');
        const price = parseFloat(selectedOption.attr('data-price')) || 0;
        const discount = parseFloat($('#discount_percent').val()) || 0;

        if (price > 0 && discount > 0) {
            const discounted = price - (price * discount / 100);
            $('#originalPrice').text('₱' + price.toFixed(2));
            $('#discountedPrice').text('₱' + discounted.toFixed(2));
            $('#pricePreview').show();
        } else {
            $('#pricePreview').hide();
        }
    });

    // ============================================
    // REASON SELECT
    // ============================================
    $('#reasonSelect').on('change', function() {
        if (this.value === 'other') {
            $('#reasonCustom').show().prop('required', true);
            $('#reasonCustom').attr('name', 'reason');
            $('[name="reason"]').attr('name', 'reason_temp');
        } else {
            $('#reasonCustom').hide().prop('required', false);
            $('[name="reason_temp"]').attr('name', 'reason');
            $('#reasonCustom').val('');
        }
    });

    // ============================================
    // EDIT PROMO
    // ============================================
    $(document).on('click', '.btn-edit', function() {
        const id = this.dataset.id;
        const productId = this.dataset.product_id;
        const discountPercent = this.dataset.discount_percent;
        const startDate = this.dataset.start_date;
        const endDate = this.dataset.end_date;
        const reason = this.dataset.reason || '';
        const isActive = this.dataset.is_active;

        $('#edit_id').val(id);
        $('#edit_discount_percent').val(discountPercent);
        $('#edit_start_date').val(startDate);
        $('#edit_end_date').val(endDate);
        $('#edit_reason').val(reason);
        $('#edit_is_active').prop('checked', isActive === '1');

        // Load product info
        $.ajax({
            url: '/products/' + productId,
            method: 'GET',
            success: function(product) {
                const select = $('#edit_product_id');
                select.html(`<option value="${product.id}">${product.name} - ₱${product.price}</option>`);
            },
            error: function() {
                $('#edit_product_id').html('<option value="">Product not found</option>');
            }
        });

        new bootstrap.Modal(document.getElementById('editPromoModal')).show();
    });

    // ============================================
    // EDIT FORM SUBMIT
    // ============================================
    $('#editPromoForm').on('submit', function(e) {
        e.preventDefault();

        const id = $('#edit_id').val();
        const formData = {
            _method: 'PUT',
            discount_percent: $('#edit_discount_percent').val(),
            start_date: $('#edit_start_date').val(),
            end_date: $('#edit_end_date').val(),
            reason: $('#edit_reason').val(),
            is_active: $('#edit_is_active').is(':checked') ? 1 : 0,
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            url: '/promos/' + id,
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    bootstrap.Modal.getInstance(document.getElementById('editPromoModal')).hide();
                    showNotification(response.message || 'Promo updated successfully!', 'updated');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showNotification(response.message || 'Error updating promo', 'error');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Error updating promo';
                if (xhr.responseJSON?.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                showNotification(errorMsg, 'error');
            }
        });
    });

    // ============================================
    // DELETE PROMO
    // ============================================
    $(document).on('click', '.btn-delete', function() {
        const id = this.dataset.id;
        const productName = this.dataset.product || 'Promo';

        Swal.fire({
            title: 'Delete Promo?',
            html: `Are you sure you want to delete the promo for <strong>${productName}</strong>?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/promos/' + id,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'DELETE'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            showNotification(response.message || `Promo for "${productName}" deleted!`, 'deleted');
                            setTimeout(() => location.reload(), 1500);
                        } else {
                            showNotification(response.message || 'Error deleting promo', 'error');
                        }
                    },
                    error: function() {
                        showNotification('Error deleting promo', 'error');
                    }
                });
            }
        });
    });

    // ============================================
    // ADD FORM SUBMIT
    // ============================================
    $('#addPromoForm').on('submit', function(e) {
        // Handle custom reason
        if ($('#reasonSelect').val() === 'other') {
            $('[name="reason_temp"]').remove();
            $('#reasonCustom').attr('name', 'reason');
        }
    });

    // ============================================
    // INITIALIZE
    // ============================================
    updateActiveFiltersDisplay();
    console.log('✅ Promo Management page loaded successfully!');
});
</script>
@endsection