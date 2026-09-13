@extends('layouts.app')

@section('title', 'Discount Types Management')

@section('content')

<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - DISCOUNT TYPES
       ============================================ */

    /* Header Box */
    .header-box {
        background: linear-gradient(135deg, #198754, #157347);
        color: #fff;
        padding: 20px 30px;
        border-radius: 12px;
        margin-bottom: 30px;
    }

    .header-box h2 {
        margin: 0;
        font-size: 22px;
        font-weight: 700;
    }

    .header-box h2 i {
        margin-right: 10px;
    }

    .header-box p {
        margin: 4px 0 0 0;
        font-size: 14px;
        opacity: 0.85;
        padding-left: 36px;
    }

    /* Toolbar */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding: 15px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        flex-wrap: wrap;
        gap: 15px;
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
        font-weight: 600;
        color: #333;
        white-space: nowrap;
        font-size: 13px;
    }

    .toolbar select,
    .toolbar input,
    .toolbar button {
        padding: 10px 16px;
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 13px;
        outline: none;
        height: 40px;
        box-sizing: border-box;
    }

    .toolbar select {
        background: white;
        cursor: pointer;
    }

    .toolbar select:focus,
    .toolbar input:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.12);
    }

    .toolbar button {
        background: #198754;
        color: white;
        border: none;
        cursor: pointer;
        transition: 0.3s;
        font-weight: 500;
        white-space: nowrap;
    }

    .toolbar button:hover {
        background: #157347;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(25, 135, 84, 0.3);
    }

    /* Button Styles */
    .btn-success {
        background-color: #198754;
        border-color: #198754;
        color: white;
        font-size: 13px;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 6px;
    }

    .btn-success:hover {
        background-color: #157347;
        border-color: #157347;
        color: white;
    }

    .btn-warning {
        background-color: #ff9800;
        border-color: #ff9800;
        color: white;
        font-size: 12px;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 6px;
    }

    .btn-warning:hover {
        background-color: #f57c00;
        border-color: #f57c00;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
        font-size: 12px;
        font-weight: 500;
        padding: 6px 14px;
        border-radius: 6px;
    }

    .btn-danger:hover {
        background-color: #c82333;
        border-color: #c82333;
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
        font-size: 13px;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 6px;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #5a6268;
        color: white;
    }

    /* Card */
    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .card-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.15);
        padding: 14px 20px;
    }

    .card-header h6 {
        font-size: 15px;
        font-weight: 600;
        margin: 0;
    }

    .card-header small {
        font-size: 12px;
        opacity: 0.75;
        display: block;
        margin-top: 2px;
    }

    .card-body {
        padding: 20px;
    }

    /* Table */
    .table-success {
        background-color: #198754;
        color: white;
    }

    .table-success th {
        font-size: 13px;
        font-weight: 600;
        padding: 10px 12px;
        border-bottom: 2px solid #157347;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table td {
        padding: 10px 12px;
        vertical-align: middle;
        text-align: center;
        font-size: 13px;
    }

    .table th {
        text-align: center;
        vertical-align: middle;
        font-size: 13px;
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(25, 135, 84, 0.06);
        transition: all 0.2s ease;
    }

    .table-bordered {
        border: 1px solid #dee2e6;
    }

    .table-bordered th,
    .table-bordered td {
        border: 1px solid #dee2e6;
    }

    /* Badges */
    .badge {
        font-size: 11px;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .badge.bg-success {
        background-color: #198754 !important;
    }

    .badge.bg-warning {
        background-color: #ff9800 !important;
        color: #000;
    }

    .badge.bg-danger {
        background-color: #dc3545 !important;
    }

    .badge.bg-secondary {
        background-color: #6c757d !important;
    }

    /* Button Group */
    .btn-group {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .btn-group .btn {
        margin-right: 0;
        border-radius: 6px;
    }

    /* Modal */
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        padding: 16px 20px;
    }

    .modal-header.bg-success {
        background-color: #198754 !important;
    }

    .modal-header .modal-title {
        font-size: 18px;
        font-weight: 600;
        color: white;
    }

    .modal-body {
        padding: 20px;
    }

    .modal-body .form-label {
        font-size: 13px;
        font-weight: 500;
        color: #333;
    }

    .modal-body .form-control {
        font-size: 13px;
        border-radius: 6px;
        border: 1px solid #ddd;
        padding: 8px 12px;
    }

    .modal-body .form-control:focus {
        border-color: #198754;
        box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.12);
    }

    .modal-body .form-text {
        font-size: 12px;
        color: #6c757d;
    }

    .modal-body .form-check-label {
        font-size: 13px;
        font-weight: 500;
        color: #333;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        padding: 16px 20px;
    }

    .modal-footer .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 6px;
    }

    /* Input Group */
    .input-group .form-control {
        border-radius: 6px 0 0 6px;
    }

    .input-group .input-group-text {
        border-radius: 0 6px 6px 0;
        font-size: 13px;
        background: #f8f9fa;
        border: 1px solid #ddd;
    }

    /* Empty State */
    .empty-state i {
        font-size: 48px;
        opacity: 0.3;
        color: #198754;
    }

    .empty-state h5 {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-top: 10px;
    }

    .empty-state p {
        font-size: 14px;
        color: #6c757d;
    }

    /* Notification */
    #notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 12px 20px;
        border-radius: 10px;
        color: #fff;
        display: none;
        z-index: 2000;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        font-weight: 600;
        font-size: 13px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .toolbar-left,
        .toolbar-right {
            justify-content: center;
        }

        .btn-group {
            flex-direction: column;
        }

        .header-box {
            padding: 16px 20px;
        }

        .header-box h2 {
            font-size: 20px;
        }

        .header-box p {
            padding-left: 0;
            font-size: 13px;
        }
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
        }

        .header-box p {
            font-size: 12px;
        }

        .table td,
        .table th {
            font-size: 12px;
            padding: 6px 8px;
        }

        .badge {
            font-size: 10px;
            padding: 2px 8px;
        }

        .modal-title {
            font-size: 16px;
        }
    }
</style>

<div class="container-fluid">
    <!-- Page Header -->
    <div class="header-box">
        <h2><i class="fa-solid fa-user-tag"></i> Discount Types Management</h2>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <label><i class="fa-solid fa-filter me-1"></i> Filter:</label>
            <select id="filterStatus">
                <option value="all">All Types</option>
                <option value="active">Active Only</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
        <div class="toolbar-right">
            <button id="addDiscountTypeBtn" class="btn btn-success">
                <i class="fa-solid fa-plus"></i> Add New Type
            </button>
        </div>
    </div>

    <!-- Discount Types Table -->
    <div class="card shadow mb-4">
        <div class="card-header bg-success text-white">
            <h6 class="m-0 font-weight-bold"><i class="fa-solid fa-list"></i> Discount Types</h6>
            <small>{{ $discountTypes->count() }} types found</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-success">
                        <tr>
                            <th style="width: 50px;">#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Discount %</th>
                            <th>ID Required</th>
                            <th>Status</th>
                            <th style="width: 180px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="discountTypesTable">
                        @forelse($discountTypes as $type)
                        <tr id="discount-type-{{ $type->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td><strong>{{ $type->name }}</strong></td>
                            <td><span class="badge bg-secondary">{{ $type->code }}</span></td>
                            <td><span class="badge bg-success">{{ $type->discount_percent }}%</span></td>
                            <td>
                                @if($type->requires_id)
                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-id-card"></i> Yes</span>
                                @else
                                <span class="badge bg-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                @if($type->is_active)
                                <span class="badge bg-success"><i class="fa-solid fa-check"></i> Active</span>
                                @else
                                <span class="badge bg-danger"><i class="fa-solid fa-ban"></i> Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <button class="btn btn-warning btn-edit" 
                                            data-id="{{ $type->id }}"
                                            data-name="{{ $type->name }}"
                                            data-code="{{ $type->code }}"
                                            data-discount_percent="{{ $type->discount_percent }}"
                                            data-requires_id="{{ $type->requires_id ? '1' : '0' }}"
                                            data-is_active="{{ $type->is_active ? '1' : '0' }}">
                                        <i class="fa-solid fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-delete" 
                                            data-id="{{ $type->id }}"
                                            data-name="{{ $type->name }}">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyState">
                            <td colspan="7" class="text-center text-muted py-5">
                                <div class="empty-state">
                                    <i class="fa-solid fa-user-tag fa-3x mb-3"></i>
                                    <h5>No discount types found</h5>
                                    <p class="text-muted">Create your first discount type!</p>
                                    <button id="addDiscountTypeBtnEmpty" class="btn btn-success mt-2">
                                        <i class="fa-solid fa-plus"></i> Add New Type
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

<!-- Add/Edit Modal -->
<div class="modal fade" id="discountTypeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="modalTitle"><i class="fa-solid fa-plus"></i> Add Discount Type</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="discountTypeForm">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Discount Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" required placeholder="e.g., PWD, Senior Citizen, VIP">
                        <div class="form-text">Enter a descriptive name for this discount type.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="code" class="form-label">Discount Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="code" name="code" required placeholder="e.g., PWD, SENIOR, VIP">
                        <div class="form-text">Unique code for this discount type.</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="discount_percent" class="form-label">Discount Percentage <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="discount_percent" 
                                   name="discount_percent" min="0" max="100" step="0.01" required placeholder="0-100">
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text">Enter discount percentage (0% to 100%).</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="requires_id" name="requires_id" value="1">
                            <label class="form-check-label" for="requires_id">
                                <i class="fa-solid fa-id-card me-1"></i> Requires ID Verification
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                <i class="fa-solid fa-check-circle me-1"></i> Activate this discount type
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save"></i> Save Discount Type
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification -->
<div id="notification">
    <i class="fa-solid fa-check-circle"></i> <span id="notificationMessage">Success!</span>
</div>

<!-- ============================================ -->
<!-- JAVASCRIPT -->
<!-- ============================================ -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ============================================
    // NOTIFICATION FUNCTION
    // ============================================
    function showNotification(msg, type = 'success') {
        const el = document.getElementById('notification');
        const msgEl = document.getElementById('notificationMessage');
        
        el.style.display = 'block';
        msgEl.textContent = msg;
        
        const icons = {
            success: 'fa-check-circle',
            error: 'fa-circle-exclamation',
            warning: 'fa-triangle-exclamation'
        };
        
        const colors = {
            success: '#198754',
            error: '#dc3545',
            warning: '#ffc107'
        };
        
        el.style.background = colors[type] || colors.success;
        el.innerHTML = `<i class="fa-solid ${icons[type] || icons.success}"></i> ${msg}`;
        
        setTimeout(() => {
            el.style.opacity = 1;
            el.style.transition = 'opacity 0.3s ease';
        }, 20);
        
        setTimeout(() => {
            el.style.opacity = 0;
            setTimeout(() => el.style.display = 'none', 300);
        }, 2200);
    }

    // ============================================
    // OPEN ADD MODAL
    // ============================================
    function openAddModal() {
        document.getElementById('discountTypeForm').reset();
        document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-plus"></i> Add Discount Type';
        document.getElementById('edit_id').value = '';
        document.getElementById('is_active').checked = true;
        
        const modal = new bootstrap.Modal(document.getElementById('discountTypeModal'));
        modal.show();
    }

    // ============================================
    // EVENT LISTENERS - ADD BUTTONS
    // ============================================
    document.getElementById('addDiscountTypeBtn').addEventListener('click', openAddModal);
    
    const emptyBtn = document.getElementById('addDiscountTypeBtnEmpty');
    if (emptyBtn) {
        emptyBtn.addEventListener('click', openAddModal);
    }

    // ============================================
    // EVENT LISTENERS - EDIT & DELETE
    // ============================================
    document.addEventListener('DOMContentLoaded', function() {
        // Edit Buttons
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const code = this.getAttribute('data-code');
                const discountPercent = this.getAttribute('data-discount_percent');
                const requiresId = this.getAttribute('data-requires_id');
                const isActive = this.getAttribute('data-is_active');
                
                document.getElementById('edit_id').value = id;
                document.getElementById('name').value = name;
                document.getElementById('code').value = code;
                document.getElementById('discount_percent').value = discountPercent;
                document.getElementById('requires_id').checked = requiresId === '1';
                document.getElementById('is_active').checked = isActive === '1';
                
                document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-edit"></i> Edit Discount Type';
                
                const modal = new bootstrap.Modal(document.getElementById('discountTypeModal'));
                modal.show();
            });
        });

        // Delete Buttons
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                
                Swal.fire({
                    title: 'Delete Discount Type?',
                    html: `Are you sure you want to delete <strong>${name}</strong>?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#dc3545',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteDiscountType(id, name);
                    }
                });
            });
        });
    });

    // ============================================
    // FORM SUBMISSION (Add/Edit)
    // ============================================
    document.getElementById('discountTypeForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = formData.get('id');
        const url = id ? `/discount-types/${id}` : '/discount-types';
        const method = id ? 'PUT' : 'POST';
        
        // Convert FormData to Object
        const data = Object.fromEntries(formData);
        data.requires_id = data.requires_id ? 1 : 0;
        data.is_active = data.is_active ? 1 : 0;
        
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            
            const result = await response.json();
            
            if (result.success) {
                bootstrap.Modal.getInstance(document.getElementById('discountTypeModal')).hide();
                showNotification(result.message, 'success');
                
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(result.message || 'Error saving discount type', 'error');
            }
        } catch (error) {
            showNotification('Network error: ' + error.message, 'error');
        }
    });

    // ============================================
    // DELETE DISCOUNT TYPE
    // ============================================
    async function deleteDiscountType(id, name) {
        try {
            const response = await fetch(`/discount-types/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const result = await response.json();
            
            if (result.success) {
                showNotification(result.message, 'success');
                
                const row = document.getElementById(`discount-type-${id}`);
                if (row) {
                    row.remove();
                    
                    const tableBody = document.getElementById('discountTypesTable');
                    const rows = tableBody.querySelectorAll('tr');
                    
                    if (rows.length === 0 || (rows.length === 1 && rows[0].id === 'emptyState')) {
                        window.location.reload();
                    }
                }
            } else {
                showNotification(result.message || 'Error deleting discount type', 'error');
            }
        } catch (error) {
            showNotification('Network error: ' + error.message, 'error');
        }
    }

    // ============================================
    // FILTER FUNCTIONALITY
    // ============================================
    document.getElementById('filterStatus').addEventListener('change', function() {
        const filter = this.value;
        const rows = document.querySelectorAll('#discountTypesTable tr');
        
        rows.forEach(row => {
            if (row.id === 'emptyState') return;
            
            const statusBadge = row.querySelector('td:nth-child(6) .badge');
            if (!statusBadge) return;
            
            const isActive = statusBadge.classList.contains('bg-success');
            
            let show = false;
            switch(filter) {
                case 'all': show = true; break;
                case 'active': show = isActive; break;
                case 'inactive': show = !isActive; break;
            }
            
            row.style.display = show ? '' : 'none';
        });
    });
</script>
@endsection