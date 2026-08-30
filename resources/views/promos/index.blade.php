@extends('layouts.app')

@section('title', 'Promo Management - Pharmacy System')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="header-box">
        <h2><i class="fa-solid fa-percentage"></i> Promo Management</h2>
        <p class="mb-0">Manage product promotions and discounts</p>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <!-- Filter by Status -->
            <div style="display: flex; align-items: center;">
                <label>Filter:</label>
                <select id="filterStatus" style="width: 150px;">
                    <option value="all">All Promos</option>
                    <option value="active">Active Only</option>
                    <option value="inactive">Inactive</option>
                    <option value="expired">Expired</option>
                    <option value="upcoming">Upcoming</option>
                </select>
            </div>
            
            <!-- Search -->
            <div style="display: flex; align-items: center;">
                <label>Search:</label>
                <input type="text" id="searchBox" placeholder="Search product or reason...">
            </div>
        </div>

        <div class="toolbar-right">
            <!-- Add Promo Button -->
            <button id="addPromoBtn">
                <i class="fa-solid fa-plus"></i> Add New Promo
            </button>
        </div>
    </div>

    <!-- Promos Table -->
    <div class="card shadow mb-4 border-purple">
        <div class="card-header bg-purple text-white py-3">
            <h6 class="m-0 font-weight-bold"><i class="fa-solid fa-list"></i> All Promos</h6>
            <small class="d-block mt-1 opacity-75">{{ $promos->count() }} promos found</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="promosTable" width="100%" cellspacing="0">
                    <thead class="table-purple">
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Discount</th>
                            <th>Duration</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="promosTableBody">
                        @forelse($promos as $promo)
                        @php
                            $isActive = $promo->is_active && now()->between($promo->start_date, $promo->end_date);
                            $isExpired = now()->greaterThan($promo->end_date);
                            $isUpcoming = now()->lessThan($promo->start_date);
                            
                            // Calculate discounted price
                            $originalPrice = $promo->product->price ?? 0;
                            $discountedPrice = $originalPrice - ($originalPrice * $promo->discount_percent / 100);
                        @endphp
                        <tr id="promo-{{ $promo->id }}" 
                            class="@if($isExpired) table-expired @elseif($isUpcoming) table-upcoming @elseif($isActive) table-active @endif">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div style="width: 40px; height: 40px; background: #f5f5f5; border-radius: 8px; 
                                                display: flex; align-items: center; justify-content: center; 
                                                margin-right: 10px; color: #9c27b0;">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $promo->product->name ?? 'Product Deleted' }}</strong>
                                        <div class="small text-muted">
                                            SKU: {{ $promo->product->sku ?? 'N/A' }}
                                            <br>
                                            Original: ₱{{ number_format($originalPrice, 2) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="discount-badge">
                                    <span class="badge bg-purple">{{ $promo->discount_percent }}% OFF</span>
                                    <div class="small text-muted mt-1">
                                        New Price: <strong>₱{{ number_format($discountedPrice, 2) }}</strong>
                                    </div>
                                    <div class="very-small text-muted">
                                        Save: ₱{{ number_format($originalPrice - $discountedPrice, 2) }}
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="duration-info">
                                    <div><strong>{{ $promo->start_date->format('M d, Y') }}</strong></div>
                                    <div class="small text-muted">to</div>
                                    <div><strong>{{ $promo->end_date->format('M d, Y') }}</strong></div>
                                    @if(!$isExpired)
                                    <div class="very-small text-muted mt-1">
                                        {{ $promo->start_date->diffInDays($promo->end_date) }} days total
                                    </div>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($promo->reason)
                                <span class="reason-badge">{{ $promo->reason }}</span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($isActive)
                                <span class="badge bg-success">
                                    <i class="fa-solid fa-circle-play"></i> Active
                                </span>
                                @elseif($isExpired)
                                <span class="badge bg-secondary">
                                    <i class="fa-solid fa-clock"></i> Expired
                                </span>
                                @elseif($isUpcoming)
                                <span class="badge bg-warning text-dark">
                                    <i class="fa-solid fa-calendar-plus"></i> Upcoming
                                </span>
                                @else
                                <span class="badge bg-danger">
                                    <i class="fa-solid fa-ban"></i> Inactive
                                </span>
                                @endif
                                
                                @if($isActive)
                                <div class="very-small text-muted mt-1">
                                    Ends in {{ now()->diffInDays($promo->end_date) }} days
                                </div>
                                @endif
                            </td>
                            <td class="actions-col">
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
                            <td colspan="7" class="text-center text-muted py-5">
                                <div class="empty-state">
                                    <i class="fa-solid fa-percentage fa-3x mb-3" style="color: #9c27b0; opacity: 0.3;"></i>
                                    <h5>No promos found</h5>
                                    <p class="text-muted">Create your first promo to boost sales!</p>
                                    <button id="addPromoBtnEmpty" class="btn btn-purple mt-2">
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

<!-- Add Promo Modal -->
<div class="modal fade" id="addPromoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-purple">
            <div class="modal-header bg-purple text-white">
                <h5 class="modal-title"><i class="fa-solid fa-plus"></i> Add New Promo</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="addPromoForm" method="POST" action="{{ route('promos.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="product_id" class="form-label">Product <span class="text-danger">*</span></label>
                            <select class="form-select border-purple" id="product_id" name="product_id" required>
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}">
                                    {{ $product->name }} - ₱{{ number_format($product->price, 2) }}
                                    @if($product->batches->count() > 0)
                                    (Stock: {{ $product->batches->sum('pieces_left') }})
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            <div class="form-text">Only products with available stock are listed</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="discount_percent" class="form-label">Discount Percentage <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control border-purple" 
                                       id="discount_percent" 
                                       name="discount_percent" 
                                       min="1" 
                                       max="90" 
                                       value="10"
                                       required>
                                <span class="input-group-text bg-purple text-white">%</span>
                            </div>
                            <div class="form-text">Discount amount (1-90%)</div>
                            <div id="pricePreview" class="mt-2 p-2 bg-light rounded" style="display: none;">
                                <small>Original: <span id="originalPrice">₱0.00</span> | 
                                Discounted: <span id="discountedPrice" class="text-purple fw-bold">₱0.00</span></small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control border-purple" 
                                   id="start_date" 
                                   name="start_date" 
                                   value="{{ date('Y-m-d') }}"
                                   required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control border-purple" 
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
                                <select class="form-select border-purple" id="reasonSelect" name="reason">
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
                                       class="form-control border-purple" 
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
                               class="form-check-input border-purple" 
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
                    <button type="submit" class="btn btn-purple">
                        <i class="fa-solid fa-plus"></i> Add Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Promo Modal -->
<div class="modal fade" id="editPromoModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content border-purple-edit">
            <div class="modal-header bg-purple-edit text-white">
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
                            <select class="form-select border-purple-edit" id="edit_product_id" name="product_id" disabled>
                                <option value="">Loading...</option>
                            </select>
                            <div class="form-text">Product cannot be changed</div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_discount_percent" class="form-label">Discount Percentage <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" 
                                       class="form-control border-purple-edit" 
                                       id="edit_discount_percent" 
                                       name="discount_percent" 
                                       min="1" 
                                       max="90" 
                                       required>
                                <span class="input-group-text bg-purple-edit text-white">%</span>
                            </div>
                            <div class="form-text">Discount amount (1-90%)</div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="edit_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control border-purple-edit" 
                                   id="edit_start_date" 
                                   name="start_date" 
                                   required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="edit_end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                            <input type="date" 
                                   class="form-control border-purple-edit" 
                                   id="edit_end_date" 
                                   name="end_date" 
                                   required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_reason" class="form-label">Promo Reason</label>
                        <input type="text" 
                               class="form-control border-purple-edit" 
                               id="edit_reason" 
                               name="reason"
                               placeholder="Enter reason">
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" 
                               class="form-check-input border-purple-edit" 
                               id="edit_is_active" 
                               name="is_active">
                        <label class="form-check-label" for="edit_is_active">
                            Activate promo
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-purple-edit">
                        <i class="fa-solid fa-save"></i> Update Promo
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification -->
<div id="notification" style="position: fixed; top: 20px; right: 20px; padding: 12px 20px; border-radius: 10px; 
                              color: #fff; display: none; z-index: 2000; box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15); 
                              font-weight: 600; font-size: 14px;"></div>

<style>
/* === PROMO COLOR SCHEME === */
:root {
    --purple: #2e7d32;
    --purple-light: #602179ff;
    --purple-dark: #0a490eff;
    --purple-edit: #ff9800;
    --purple-edit-light: #ffb74d;
    --purple-edit-dark: #f57c00;
    --purple-delete: #d32f2f;
    --purple-delete-light: #ef5350;
    --purple-delete-dark: #c62828;
    --purple-success: #2e7d32;
    --purple-warning: #ff9800;
    --purple-expired: #757575;
}

/* === Header Box === */
.header-box {
    background: linear-gradient(135deg, #266f29ff, #1a691eff);
    color: #fff;
    padding: 25px 30px;
    border-radius: 12px;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.header-box h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 600;
}

.header-box h2 i {
    margin-right: 10px;
}

.header-box p {
    opacity: 0.9;
    margin-top: 5px;
}

/* === Toolbar === */
.toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    flex-wrap: wrap;
    gap: 15px;
    background: white;
    padding: 15px 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.toolbar-left {
    display: flex;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
}

.toolbar-right {
    display: flex;
    align-items: center;
    gap: 15px;
}

.toolbar label {
    margin-right: 8px;
    font-weight: 500;
    color: #333;
    white-space: nowrap;
}

.toolbar select,
.toolbar input,
.toolbar button {
    padding: 10px 16px;
    border-radius: 8px;
    border: 1px solid #ddd;
    font-size: 14px;
    outline: none;
    height: 40px;
    box-sizing: border-box;
}

.toolbar input {
    width: 250px;
}

.toolbar button {
    background: var(--purple);
    color: white;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    font-weight: 500;
    white-space: nowrap;
}

.toolbar button:hover {
    background: var(--purple-dark);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(155, 39, 176, 0.3);
}

/* === Button Styles === */
.btn-purple {
    background-color: var(--purple);
    border-color: var(--purple);
    color: white;
}

.btn-purple:hover {
    background-color: var(--purple-dark);
    border-color: var(--purple-dark);
    color: white;
}

.btn-purple-edit {
    background-color: var(--purple-edit);
    border-color: var(--purple-edit);
    color: white;
}

.btn-purple-edit:hover {
    background-color: var(--purple-edit-dark);
    border-color: var(--purple-edit-dark);
    color: white;
}

.btn-purple-delete {
    background-color: var(--purple-delete);
    border-color: var(--purple-delete);
    color: white;
}

.btn-purple-delete:hover {
    background-color: var(--purple-delete-dark);
    border-color: var(--purple-delete-dark);
    color: white;
}

/* === Background Colors === */
.bg-purple {
    background-color: var(--purple) !important;
}

.bg-purple-edit {
    background-color: var(--purple-edit) !important;
}

/* === Border Colors === */
.border-purple {
    border-color: var(--purple) !important;
}

.border-purple-edit {
    border-color: var(--purple-edit) !important;
}

/* === Table Styles === */
.table-purple {
    background-color: var(--purple);
    color: white;
}

.table-purple th {
    border-bottom: 2px solid var(--purple-dark);
    font-weight: 600;
}

/* Status-based row colors */
.table-active {
    background-color: rgba(46, 125, 50, 0.05) !important;
    border-left: 4px solid var(--purple-success);
}

.table-expired {
    background-color: rgba(117, 117, 117, 0.05) !important;
    border-left: 4px solid var(--purple-expired);
}

.table-upcoming {
    background-color: rgba(255, 152, 0, 0.05) !important;
    border-left: 4px solid var(--purple-warning);
}

/* Table hover effect */
.table-hover tbody tr:hover {
    background-color: rgba(155, 39, 176, 0.08) !important;
    transform: translateY(1px);
    transition: all 0.2s ease;
}

/* === Badge Styles === */
.badge.bg-purple {
    background-color: var(--purple) !important;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
}

.discount-badge {
    text-align: center;
}

.reason-badge {
    display: inline-block;
    padding: 4px 10px;
    background: #f3e5f5;
    color: var(--purple);
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.duration-info {
    text-align: center;
}

.very-small {
    font-size: 11px;
}

/* === Empty State === */
.empty-state {
    padding: 40px 20px;
    text-align: center;
}

.empty-state h5 {
    color: var(--purple);
    margin: 10px 0;
}

/* === Form Control Focus === */
.form-control.border-purple:focus,
.form-control.border-purple-edit:focus {
    box-shadow: 0 0 0 0.2rem rgba(155, 39, 176, 0.25);
    border-color: var(--purple);
}

.form-control.border-purple-edit:focus {
    box-shadow: 0 0 0 0.2rem rgba(255, 152, 0, 0.25);
    border-color: var(--purple-edit);
}

/* === Price Preview === */
#pricePreview {
    border-left: 3px solid var(--purple);
}

.text-purple {
    color: var(--purple) !important;
}

/* === Card Styling === */
.card {
    border-radius: 12px;
    overflow: hidden;
    border: none;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

/* === Button Group === */
.btn-group .btn {
    margin-right: 5px;
    border-radius: 6px;
    font-weight: 500;
    font-size: 12px;
    padding: 5px 10px;
}

/* === Modal Styling === */
.modal-content {
    border-radius: 12px;
    border: none;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
}

.modal-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.2);
}

/* === Responsive Design === */
@media (max-width: 768px) {
    .btn-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    
    .btn-group .btn {
        margin-right: 0;
    }

    .toolbar {
        flex-direction: column;
        align-items: stretch;
    }

    .toolbar-left, .toolbar-right {
        justify-content: center;
    }

    .toolbar input {
        width: 200px;
    }
}

@media (max-width: 480px) {
    .header-box {
        padding: 15px 20px;
    }

    .header-box h2 {
        font-size: 20px;
    }

    .toolbar input {
        width: 150px;
    }
}
</style>

<!-- Add Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Search functionality
document.getElementById('searchBox').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    
    document.querySelectorAll('#promosTableBody tr').forEach(row => {
        const productName = row.children[1].textContent.toLowerCase();
        const reason = row.children[4].textContent.toLowerCase();
        
        const matches = productName.includes(searchTerm) || reason.includes(searchTerm);
        row.style.display = matches ? '' : 'none';
    });
});

// Filter by status
document.getElementById('filterStatus').addEventListener('change', function() {
    const filter = this.value;
    
    document.querySelectorAll('#promosTableBody tr').forEach(row => {
        if (row.classList.contains('empty-state-row')) return;
        
        const statusText = row.children[5].textContent.toLowerCase();
        let show = false;
        
        switch(filter) {
            case 'all':
                show = true;
                break;
            case 'active':
                show = statusText.includes('active');
                break;
            case 'inactive':
                show = statusText.includes('inactive');
                break;
            case 'expired':
                show = statusText.includes('expired');
                break;
            case 'upcoming':
                show = statusText.includes('upcoming');
                break;
            default:
                show = true;
        }
        
        row.style.display = show ? '' : 'none';
    });
});

// Notification function
function showNotification(msg, type = 'success') {
    const el = document.getElementById('notification');
    el.textContent = msg;
    el.style.display = 'block';
    
    // Different colors for different actions
    switch(type) {
        case 'created':
            el.style.background = 'var(--purple)';
            el.innerHTML = '<i class="fa-solid fa-circle-plus"></i> ' + msg;
            break;
        case 'updated':
            el.style.background = 'var(--purple-edit)';
            el.innerHTML = '<i class="fa-solid fa-pen-to-square"></i> ' + msg;
            break;
        case 'deleted':
            el.style.background = 'var(--purple-delete)';
            el.innerHTML = '<i class="fa-solid fa-trash"></i> ' + msg;
            break;
        case 'error':
            el.style.background = 'var(--purple-delete-dark)';
            el.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + msg;
            break;
        case 'warning':
            el.style.background = 'var(--purple-edit-dark)';
            el.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + msg;
            break;
        default:
            el.style.background = 'var(--purple)';
            el.innerHTML = '<i class="fa-solid fa-check-circle"></i> ' + msg;
    }
    
    // Smooth fade in
    setTimeout(() => {
        el.style.opacity = 1;
        el.style.transition = 'opacity 0.3s ease';
    }, 20);
    
    // Auto hide after 2.2 seconds
    setTimeout(() => {
        el.style.opacity = 0;
        setTimeout(() => el.style.display = 'none', 300);
    }, 2200);
}

// Price preview for add form
document.getElementById('product_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const price = selectedOption.getAttribute('data-price') || 0;
    const discount = document.getElementById('discount_percent').value || 0;
    
    updatePricePreview(price, discount);
});

document.getElementById('discount_percent').addEventListener('input', function() {
    const productSelect = document.getElementById('product_id');
    const selectedOption = productSelect.options[productSelect.selectedIndex];
    const price = selectedOption.getAttribute('data-price') || 0;
    const discount = this.value;
    
    updatePricePreview(price, discount);
});

function updatePricePreview(originalPrice, discountPercent) {
    if (originalPrice > 0 && discountPercent > 0) {
        const original = parseFloat(originalPrice);
        const discount = parseFloat(discountPercent);
        const discounted = original - (original * discount / 100);
        
        document.getElementById('originalPrice').textContent = '₱' + original.toFixed(2);
        document.getElementById('discountedPrice').textContent = '₱' + discounted.toFixed(2);
        document.getElementById('pricePreview').style.display = 'block';
    } else {
        document.getElementById('pricePreview').style.display = 'none';
    }
}

// Reason select logic
document.getElementById('reasonSelect').addEventListener('change', function() {
    const customReasonInput = document.getElementById('reasonCustom');
    if (this.value === 'other') {
        customReasonInput.style.display = 'block';
        customReasonInput.required = true;
        customReasonInput.name = 'reason';
        document.querySelector('[name="reason"]').name = 'reason_temp';
    } else {
        customReasonInput.style.display = 'none';
        customReasonInput.required = false;
        document.querySelector('[name="reason_temp"]').name = 'reason';
        customReasonInput.value = '';
    }
});

// Open Add Modal
function openAddModal() {
    document.getElementById('addPromoForm').reset();
    document.getElementById('pricePreview').style.display = 'none';
    document.getElementById('reasonCustom').style.display = 'none';
    new bootstrap.Modal(document.getElementById('addPromoModal')).show();
}

// Add Promo Button Event Listeners
document.getElementById('addPromoBtn').addEventListener('click', openAddModal);
document.getElementById('addPromoBtnEmpty')?.addEventListener('click', openAddModal);

// Edit Promo functionality
document.addEventListener('DOMContentLoaded', function() {
    // Attach edit event listeners
    document.querySelectorAll('.btn-edit').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const productId = this.getAttribute('data-product_id');
            const discountPercent = this.getAttribute('data-discount_percent');
            const startDate = this.getAttribute('data-start_date');
            const endDate = this.getAttribute('data-end_date');
            const reason = this.getAttribute('data-reason');
            const isActive = this.getAttribute('data-is_active');
            
            // Fill form data
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_discount_percent').value = discountPercent;
            document.getElementById('edit_start_date').value = startDate;
            document.getElementById('edit_end_date').value = endDate;
            document.getElementById('edit_reason').value = reason || '';
            document.getElementById('edit_is_active').checked = isActive === '1';
            
            // Load product info
            fetch(`/products/${productId}`)
                .then(response => response.json())
                .then(product => {
                    const select = document.getElementById('edit_product_id');
                    select.innerHTML = `<option value="${product.id}">${product.name} - ₱${product.price}</option>`;
                });
            
            // Show modal
            new bootstrap.Modal(document.getElementById('editPromoModal')).show();
        });
    });

    // Delete Promo with confirmation
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const productName = this.getAttribute('data-product');
            
            Swal.fire({
                title: 'Delete Promo?',
                html: `Are you sure you want to delete the promo for <strong>${productName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: 'var(--purple-delete)',
                cancelButtonColor: 'var(--purple)',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                background: '#fff'
            }).then((result) => {
                if (result.isConfirmed) {
                    deletePromo(id, productName);
                }
            });
        });
    });
});

// Edit form submission (AJAX) - UPDATED WITH ERROR HANDLING
document.getElementById('editPromoForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const id = document.getElementById('edit_id').value;
    
    // Prepare form data - SIMPLE WAY
    const formData = {
        _method: 'PUT',
        discount_percent: document.getElementById('edit_discount_percent').value,
        start_date: document.getElementById('edit_start_date').value,
        end_date: document.getElementById('edit_end_date').value,
        reason: document.getElementById('edit_reason').value,
        is_active: document.getElementById('edit_is_active').checked ? 1 : 0,
        _token: '{{ csrf_token() }}'
    };
    
    // ✅ SIMPLE DEBUG: Check what we're sending
    console.log('Sending data:', formData);
    
    try {
        const response = await fetch(`/promos/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(formData)
        });
        
        const data = await response.json();
        
        if (!response.ok) {
            // Handle validation errors
            if (data.errors) {
                let errorMessages = '';
                for (const field in data.errors) {
                    errorMessages += data.errors[field].join(', ') + '\n';
                }
                showNotification('Validation Error: ' + errorMessages, 'error');
            } else {
                showNotification(data.message || 'Error updating promo', 'error');
            }
            return;
        }
        
        if (data.status === 'success') {
            bootstrap.Modal.getInstance(document.getElementById('editPromoModal')).hide();
            showNotification(data.message || 'Promo updated successfully!', 'updated');
            setTimeout(() => location.reload(), 1500);
        } else {
            showNotification(data.message || 'Error updating promo', 'error');
        }
        
    } catch (error) {
        console.error('Fetch error:', error);
        showNotification('Network error: ' + error.message, 'error');
    }
});
// Delete Promo (AJAX)
function deletePromo(id, productName) {
    fetch(`/promos/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-HTTP-Method-Override': 'DELETE'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            showNotification(data.message || `Promo for "${productName}" deleted!`, 'deleted');
            setTimeout(() => location.reload(), 1000); // Reload to update list
        } else {
            showNotification(data.message || 'Error deleting promo', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error deleting promo', 'error');
    });
}

// Clear search when page loads
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('searchBox').value = '';
});
</script>
@endsection