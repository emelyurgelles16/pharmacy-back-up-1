@extends('layouts.app')

@section('title', 'Discount Types Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="header-box" style="background: linear-gradient(135deg, #198754, #157347); color: #fff; padding: 25px 30px; border-radius: 12px; margin-bottom: 30px;">
        <h2><i class="fa-solid fa-user-tag"></i> Discount Types Management</h2>
        <p>Manage customer discount types (PWD, Senior Citizen, VIP, etc.)</p>
    </div>

    <!-- Toolbar -->
    <div class="toolbar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding: 15px 20px; background: white; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div class="toolbar-left">
            <label>Filter:</label>
            <select id="filterStatus" style="padding: 8px 12px; border-radius: 6px; border: 1px solid #ddd;">
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
        <div class="card-header bg-success text-white py-3">
            <h6 class="m-0 font-weight-bold"><i class="fa-solid fa-list"></i> Discount Types</h6>
            <small class="d-block mt-1 opacity-75">{{ $discountTypes->count() }} types found</small>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Discount %</th>
                            <th>ID Required</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                                    <i class="fa-solid fa-user-tag fa-3x mb-3" style="color: #198754; opacity: 0.3;"></i>
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
                        <label for="name" class="form-label">Discount Name *</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="form-text">e.g., PWD, Senior Citizen, VIP</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="code" class="form-label">Discount Code *</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                        <div class="form-text">Unique code: PWD, SENIOR, VIP</div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="discount_percent" class="form-label">Discount Percentage *</label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="discount_percent" 
                                   name="discount_percent" min="0" max="100" step="0.01" required>
                            <span class="input-group-text">%</span>
                        </div>
                        <div class="form-text">Discount amount (0-100%)</div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="requires_id" name="requires_id" value="1">
                            <label class="form-check-label" for="requires_id">
                                Requires ID Verification
                            </label>
                        </div>
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">
                                Activate this discount type
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fa-solid fa-save"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Notification -->
<div id="notification" style="position: fixed; top: 20px; right: 20px; padding: 12px 20px; border-radius: 10px; color: #fff; display: none; z-index: 2000; box-shadow: 0 6px 20px rgba(0,0,0,0.15); font-weight: 600;"></div>

<style>
    .btn-success {
        background-color: #198754;
        border-color: #198754;
    }
    
    .btn-success:hover {
        background-color: #157347;
        border-color: #157347;
    }
    
    .btn-warning {
        background-color: #ff9800;
        border-color: #ff9800;
        color: white;
    }
    
    .btn-warning:hover {
        background-color: #f57c00;
        border-color: #f57c00;
    }
    
    .table-success {
        background-color: #198754;
        color: white;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Notification function
    function showNotification(msg, type = 'success') {
        const el = document.getElementById('notification');
        el.textContent = msg;
        el.style.display = 'block';
        
        switch(type) {
            case 'success':
                el.style.background = '#198754';
                el.innerHTML = '<i class="fa-solid fa-check-circle"></i> ' + msg;
                break;
            case 'error':
                el.style.background = '#dc3545';
                el.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i> ' + msg;
                break;
            case 'warning':
                el.style.background = '#ffc107';
                el.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i> ' + msg;
                break;
        }
        
        setTimeout(() => {
            el.style.opacity = 1;
        }, 20);
        
        setTimeout(() => {
            el.style.opacity = 0;
            setTimeout(() => el.style.display = 'none', 300);
        }, 2200);
    }

    // Open Add Modal
    function openAddModal() {
        document.getElementById('discountTypeForm').reset();
        document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-plus"></i> Add Discount Type';
        document.getElementById('edit_id').value = '';
        document.getElementById('is_active').checked = true;
        
        const modal = new bootstrap.Modal(document.getElementById('discountTypeModal'));
        modal.show();
    }

    // Event Listeners for Add Buttons
    document.getElementById('addDiscountTypeBtn').addEventListener('click', openAddModal);
    document.getElementById('addDiscountTypeBtnEmpty')?.addEventListener('click', openAddModal);

    // Edit Discount Type
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const code = this.getAttribute('data-code');
                const discountPercent = this.getAttribute('data-discount_percent');
                const requiresId = this.getAttribute('data-requires_id');
                const isActive = this.getAttribute('data-is_active');
                
                // Fill form
                document.getElementById('edit_id').value = id;
                document.getElementById('name').value = name;
                document.getElementById('code').value = code;
                document.getElementById('discount_percent').value = discountPercent;
                document.getElementById('requires_id').checked = requiresId === '1';
                document.getElementById('is_active').checked = isActive === '1';
                
                // Update modal title
                document.getElementById('modalTitle').innerHTML = '<i class="fa-solid fa-edit"></i> Edit Discount Type';
                
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('discountTypeModal'));
                modal.show();
            });
        });

        // Delete Discount Type
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
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteDiscountType(id, name);
                    }
                });
            });
        });
    });

    // Form Submission (Add/Edit)
    document.getElementById('discountTypeForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const id = formData.get('id');
        const url = id ? `/discount-types/${id}` : '/discount-types';
        const method = id ? 'PUT' : 'POST';
        
        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(Object.fromEntries(formData))
            });
            
            const data = await response.json();
            
            if (data.success) {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('discountTypeModal')).hide();
                
                // Show notification
                showNotification(data.message, 'success');
                
                // Reload page after 1.5 seconds
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showNotification(data.message || 'Error saving discount type', 'error');
            }
        } catch (error) {
            showNotification('Network error: ' + error.message, 'error');
        }
    });

    // Delete Discount Type
    async function deleteDiscountType(id, name) {
        try {
            const response = await fetch(`/discount-types/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                showNotification(data.message, 'success');
                
                // Remove row from table
                const row = document.getElementById(`discount-type-${id}`);
                if (row) {
                    row.remove();
                    
                    // Check if table is empty
                    const tableBody = document.getElementById('discountTypesTable');
                    const rows = tableBody.querySelectorAll('tr');
                    
                    if (rows.length === 0 || (rows.length === 1 && rows[0].id === 'emptyState')) {
                        window.location.reload();
                    }
                }
            } else {
                showNotification(data.message || 'Error deleting discount type', 'error');
            }
        } catch (error) {
            showNotification('Network error: ' + error.message, 'error');
        }
    }

    // Filter functionality
    document.getElementById('filterStatus').addEventListener('change', function() {
        const filter = this.value;
        const rows = document.querySelectorAll('#discountTypesTable tr');
        
        rows.forEach(row => {
            if (row.id === 'emptyState') return;
            
            const statusBadge = row.querySelector('td:nth-child(6) .badge');
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