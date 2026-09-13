@extends('layouts.app')

@section('title', 'Permission Management')

@section('content')
<style>
    /* ============================================
       🎯 STANDARDIZED FONT SIZES - PERMISSION MANAGEMENT
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

    /* ===== PERMISSION BADGES ===== */
    .perm-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #2e7d32;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        margin: 2px 4px 2px 0;
        white-space: nowrap;
    }

    .perm-badge i {
        margin-right: 4px;
        font-size: 10px;
    }

    /* ===== ROLE ICONS ===== */
    .role-icon {
        font-size: 16px;
        margin-right: 8px;
    }
    .role-admin { color: #dc3545; }
    .role-cashier { color: #28a745; }
    .role-pa { color: #17a2b8; }
    .role-pharmacist { color: #6f42c1; }

    /* ===== TABLE ===== */
    .table-responsive {
        overflow-x: auto;
    }

    .table {
        font-size: 13px;
        margin: 0;
    }

    .table thead th {
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
        padding: 10px 14px;
        background: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .table tbody td {
        font-size: 13px;
        padding: 10px 14px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }

    .table tbody tr:hover {
        background-color: #f8fdf8;
    }

    /* ===== CARD ===== */
    .card {
        border-radius: 10px;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
    }

    .card-header {
        background: white;
        padding: 12px 20px !important;
        border-bottom: 1px solid #e9ecef;
    }

    .card-header h5 {
        font-size: 16px;
        font-weight: 600;
        color: #1a1a2e;
        margin: 0;
    }

    .card-header h5 i {
        color: #0b7a33;
        margin-right: 8px;
    }

    .card-footer {
        background: white;
        padding: 10px 18px;
        border-top: 1px solid #e9ecef;
    }

    /* ===== INPUT GROUP ===== */
    .input-group .input-group-text {
        font-size: 13px;
        background: white;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
    }

    .input-group .form-control {
        font-size: 13px;
        padding: 8px 12px;
        border: 1px solid #dee2e6;
        height: 38px;
    }

    .input-group .form-control:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
    }

    /* ===== BUTTONS ===== */
    .btn {
        font-size: 13px;
        font-weight: 500;
        padding: 6px 16px;
        border-radius: 6px;
        transition: all 0.2s;
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

    .btn-warning {
        background: #ff9800;
        border-color: #ff9800;
        color: white;
        font-size: 12px;
        padding: 4px 12px;
    }

    .btn-warning:hover {
        background: #f57c00;
        border-color: #f57c00;
        color: white;
    }

    .btn-danger {
        background: #dc3545;
        border-color: #dc3545;
        color: white;
        font-size: 12px;
        padding: 4px 12px;
    }

    .btn-danger:hover {
        background: #c82333;
        border-color: #c82333;
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        border-color: #6c757d;
        color: white;
        font-size: 13px;
    }

    .btn-secondary:hover {
        background: #5a6268;
        border-color: #5a6268;
        color: white;
    }

    /* ===== TOOLBAR ===== */
    .toolbar {
        margin-bottom: 20px;
    }

    .toolbar .btn-add {
        background: #0b7a33;
        color: white;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
    }

    .toolbar .btn-add:hover {
        background: #056b28;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(11, 122, 51, 0.3);
    }

    /* ============================================
       ✅ FIXED MODAL - CHECKBOXES STAY INSIDE
       ============================================ */
    .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        animation: fadeIn 0.3s ease;
        overflow-y: auto;
        padding: 20px;
    }

    .modal-content {
        background: white;
        margin: 2% auto;
        padding: 0;
        width: 95%;
        max-width: 900px;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.3);
        animation: slideUp 0.3s ease;
        max-height: 95vh;
        display: flex;
        flex-direction: column;
    }

    .modal-header-custom {
        background: linear-gradient(135deg, #0b7a33, #056b28);
        color: white;
        padding: 14px 24px;
        border-radius: 12px 12px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-shrink: 0;
    }

    .modal-header-custom h4 {
        font-size: 18px;
        font-weight: 600;
        margin: 0;
    }

    .modal-header-custom h4 i {
        margin-right: 8px;
    }

    .modal-header-custom .close-modal {
        background: none;
        border: none;
        color: white;
        font-size: 28px;
        cursor: pointer;
        transition: all 0.3s;
        line-height: 1;
        padding: 0 8px;
    }

    .modal-header-custom .close-modal:hover {
        transform: rotate(90deg);
    }

    .modal-body-custom {
        padding: 20px 24px;
        overflow-y: auto;
        flex: 1;
        max-height: calc(95vh - 180px);
    }

    .modal-body-custom .form-label {
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
        display: block;
    }

    .modal-body-custom .form-control {
        font-size: 13px;
        border-radius: 6px;
        border: 1.5px solid #e0e0e0;
        padding: 8px 12px;
        width: 100%;
        height: 38px;
    }

    .modal-body-custom .form-control:focus {
        border-color: #0b7a33;
        box-shadow: 0 0 0 3px rgba(11, 122, 51, 0.1);
        outline: none;
    }

    /* ✅ PERMISSIONS GRID - NAKALOOB SA MODAL */
    .permissions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 2px 6px;
        padding: 4px 0;
        max-height: 280px;
        overflow-y: auto;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        background: #fafafa;
        padding: 6px 8px;
    }

    .permissions-grid .form-check {
        padding: 3px 6px;
        display: flex;
        align-items: center;
        gap: 6px;
        border-radius: 4px;
        transition: background 0.2s;
        margin: 0;
        min-height: 28px;
    }

    .permissions-grid .form-check:hover {
        background: #e8f5e9;
    }

    .permissions-grid .form-check-input {
        width: 15px;
        height: 15px;
        accent-color: #0b7a33;
        cursor: pointer;
        flex-shrink: 0;
        margin: 0;
    }

    .permissions-grid .form-check-label {
        font-size: 12px;
        cursor: pointer;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 1px 0;
        color: #333;
    }

    .permissions-grid .form-check-label i {
        color: #0b7a33;
        font-size: 11px;
    }

    .modal-footer-custom {
        padding: 12px 24px;
        border-top: 1px solid #e9ecef;
        display: flex;
        justify-content: flex-end;
        gap: 8px;
        border-radius: 0 0 12px 12px;
        background: #fafafa;
        flex-shrink: 0;
    }

    /* ===== PAGINATION ===== */
    .pagination {
        display: flex;
        gap: 3px;
        margin: 0;
        padding: 0;
        list-style: none;
        align-items: center;
        flex-wrap: wrap;
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

    /* ===== ANIMATIONS ===== */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
        .header-box {
            padding: 16px 20px;
        }
        .header-box h2 {
            font-size: 20px;
        }
        .modal-content {
            margin: 5% auto;
            width: 98%;
            max-height: 98vh;
        }
        .modal-body-custom {
            max-height: calc(98vh - 180px);
            padding: 16px;
        }
        .permissions-grid {
            grid-template-columns: 1fr 1fr;
            max-height: 220px;
        }
        .permissions-grid .form-check-label {
            font-size: 12px;
        }
        .table {
            font-size: 12px;
        }
        .table thead th,
        .table tbody td {
            padding: 6px 8px;
        }
    }

    @media (max-width: 576px) {
        .header-box h2 {
            font-size: 18px;
        }
        .toolbar .row {
            flex-direction: column;
            gap: 8px;
        }
        .toolbar .text-end {
            text-align: left !important;
        }
        .modal-content {
            margin: 2% auto;
            width: 100%;
            border-radius: 8px;
            max-height: 100vh;
        }
        .modal-header-custom {
            padding: 12px 16px;
        }
        .modal-header-custom h4 {
            font-size: 16px;
        }
        .modal-body-custom {
            padding: 12px 16px;
            max-height: calc(100vh - 160px);
        }
        .permissions-grid {
            grid-template-columns: 1fr 1fr;
            max-height: 200px;
            padding: 4px 6px;
        }
        .permissions-grid .form-check {
            padding: 2px 4px;
            min-height: 24px;
        }
        .permissions-grid .form-check-label {
            font-size: 11px;
        }
        .permissions-grid .form-check-input {
            width: 14px;
            height: 14px;
        }
        .btn {
            font-size: 12px;
            padding: 4px 12px;
        }
        .pagination .page-link {
            font-size: 12px;
            min-width: 24px;
            height: 24px;
            padding: 0 6px;
        }
        .table thead th {
            font-size: 10px;
        }
        .table tbody td {
            font-size: 12px;
        }
        .perm-badge {
            font-size: 10px;
            padding: 2px 8px;
        }
        .modal-footer-custom {
            padding: 10px 16px;
            flex-wrap: wrap;
            gap: 6px;
        }
        .modal-footer-custom .btn {
            flex: 1;
            min-width: 80px;
            text-align: center;
        }
    }

    @media (max-width: 400px) {
        .permissions-grid {
            grid-template-columns: 1fr;
            max-height: 180px;
        }
        .permissions-grid .form-check {
            padding: 2px 4px;
        }
        .permissions-grid .form-check-label {
            font-size: 11px;
        }
        .modal-header-custom h4 {
            font-size: 14px;
        }
        .modal-body-custom {
            padding: 8px 12px;
        }
    }
</style>

<div class="container-fluid">
    <!-- ===== HEADER ===== -->
    <div class="header-box">
        <h2>
            <i class="fas fa-key"></i>
            Permission Management
        </h2>
    </div>

    <!-- ===== TOOLBAR ===== -->
    <div class="toolbar">
        <div class="row g-2 align-items-center">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" id="searchRole" class="form-control border-start-0" placeholder="Search role...">
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button id="addRoleBtn" class="btn-add">
                    <i class="fas fa-plus"></i> Add Role with Permissions
                </button>
            </div>
        </div>
    </div>

    <!-- ===== TABLE ===== -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5>
                <i class="fas fa-list me-2 text-success"></i> Roles & Permissions
            </h5>
        </div>
        <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th style="width: 20%;">Role</th>
                            <th style="width: 65%;">Permissions</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="rolesTableBody">
                        @foreach($roles as $role)
                        @php
                            $roleIcon = '👑';
                            $roleClass = 'role-admin';
                            if($role->name == 'Admin') { $roleIcon = '👑'; $roleClass = 'role-admin'; }
                            elseif($role->name == 'Cashier') { $roleIcon = '💰'; $roleClass = 'role-cashier'; }
                            elseif($role->name == 'Pharmacy Assistant') { $roleIcon = '📦'; $roleClass = 'role-pa'; }
                            elseif($role->name == 'Pharmacist') { $roleIcon = '💊'; $roleClass = 'role-pharmacist'; }
                        @endphp
                        <tr class="role-row" data-role-name="{{ $role->name }}">
                            <td>
                                <span class="role-icon {{ $roleClass }}">{{ $roleIcon }}</span>
                                <strong>{{ $role->name }}</strong>
                            </td>
                            <td class="permissions-cell">
                                @foreach($role->permissions as $perm)
                                <span class="perm-badge">
                                    <i class="fas fa-check-circle text-success"></i> {{ $perm->name }}
                                </span>
                                @endforeach
                                @if($role->permissions->count() == 0)
                                <span class="text-muted" style="font-size: 12px;">No permissions assigned</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning edit-role" data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                    <i class="fas fa-edit"></i> Edit
                                </button>
                                @if(!in_array($role->name, ['Admin', 'Cashier', 'Pharmacy Assistant', 'Pharmacist']))
                                <button class="btn btn-danger delete-role" data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @if($roles->hasPages())
        <div class="card-footer bg-white">
            {{ $roles->links() }}
        </div>
        @endif
    </div>
</div>

<!-- ===== ✅ FIXED MODAL - CHECKBOXES SA LOOB ===== -->
<div id="roleModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header-custom">
            <h4 id="modalTitle"><i class="fas fa-plus me-2"></i> Add Role</h4>
            <button class="close-modal closeModal">&times;</button>
        </div>
        <div class="modal-body-custom">
            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" id="roleName" class="form-control" placeholder="Enter role name">
                <input type="hidden" id="roleId">
            </div>
            <div class="mb-2">
                <label class="form-label fw-bold">Permissions</label>
                <div id="permissionsList" class="permissions-grid">
                    <!-- Permissions will be loaded here -->
                </div>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn btn-secondary closeModalBtn">Cancel</button>
            <button type="button" id="saveRoleBtn" class="btn btn-success">Save Role</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    let allPermissions = @json($permissions ?? []);

    // ============================================
    // SEARCH ROLE
    // ============================================
    $('#searchRole').on('keyup', function() {
        let search = $(this).val().toLowerCase();
        let visibleCount = 0;
        
        $('.role-row').each(function() {
            let roleName = $(this).data('role-name').toLowerCase();
            let isVisible = roleName.indexOf(search) > -1;
            $(this).toggle(isVisible);
            if (isVisible) visibleCount++;
        });
        
        if (visibleCount === 0 && $('#rolesTableBody').children().length > 0) {
            if ($('#noResultsRow').length === 0) {
                $('#noResultsRow').remove();
                $('#rolesTableBody').append('<tr id="noResultsRow"><td colspan="3" class="text-center text-muted py-4" style="font-size: 14px;">No roles found matching your search.</td></tr>');
            }
        } else {
            $('#noResultsRow').remove();
        }
    });

    // ============================================
    // LOAD PERMISSIONS - ✅ FIXED
    // ============================================
    function loadPermissions(selectedPermissions = []) {
        let html = '';
        if (allPermissions.length === 0) {
            html = '<div class="text-muted text-center py-3" style="font-size: 13px; grid-column: 1 / -1;">No permissions available</div>';
        } else {
            allPermissions.forEach(perm => {
                let isChecked = selectedPermissions.includes(perm.id) ? 'checked' : '';
                html += `
                    <div class="form-check">
                        <input class="form-check-input perm-checkbox" type="checkbox" value="${perm.id}" id="perm_${perm.id}" ${isChecked}>
                        <label class="form-check-label" for="perm_${perm.id}">
                            <i class="fas fa-check-circle"></i> ${perm.name}
                        </label>
                    </div>
                `;
            });
        }
        $('#permissionsList').html(html);
    }

    // ============================================
    // ADD ROLE MODAL
    // ============================================
    $('#addRoleBtn').click(function() {
        $('#modalTitle').html('<i class="fas fa-plus me-2"></i> Add Role');
        $('#roleId').val('');
        $('#roleName').val('');
        loadPermissions([]);
        $('#roleModal').fadeIn();
        $('body').css('overflow', 'hidden');
    });

    // ============================================
    // EDIT ROLE MODAL
    // ============================================
    $(document).on('click', '.edit-role', function() {
        let roleId = $(this).data('id');
        let roleName = $(this).data('name');
        
        $('#modalTitle').html('<i class="fas fa-edit me-2"></i> Edit Role');
        $('#roleId').val(roleId);
        $('#roleName').val(roleName);
        
        $.ajax({
            url: '/roles/' + roleId + '/permissions',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                loadPermissions(response.permissions);
                $('#roleModal').fadeIn();
                $('body').css('overflow', 'hidden');
            },
            error: function(xhr) {
                console.error('Error loading permissions:', xhr);
                loadPermissions([]);
                $('#roleModal').fadeIn();
                $('body').css('overflow', 'hidden');
            }
        });
    });

    // ============================================
    // SAVE ROLE
    // ============================================
    $('#saveRoleBtn').click(function() {
        let roleId = $('#roleId').val();
        let roleName = $('#roleName').val().trim();
        let permissions = [];
        
        $('.perm-checkbox:checked').each(function() {
            permissions.push($(this).val());
        });
        
        if (!roleName) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please enter role name',
                confirmButtonColor: '#d33'
            });
            return;
        }
        
        Swal.fire({
            title: 'Saving...',
            text: 'Please wait',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
        
        let url = roleId ? '/roles/' + roleId : '/roles';
        let method = 'POST';
        let requestData = {
            _token: '{{ csrf_token() }}',
            name: roleName,
            permissions: permissions
        };
        
        if (roleId) {
            requestData._method = 'PUT';
        }
        
        $.ajax({
            url: url,
            method: method,
            data: requestData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: response.message,
                        confirmButtonColor: '#0b7a33'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: response.message || 'Failed to save role',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function(xhr) {
                let errorMsg = 'Failed to save role';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                } else if (xhr.status === 422) {
                    errorMsg = 'Validation error. Please check the role name.';
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMsg,
                    confirmButtonColor: '#d33'
                });
            }
        });
    });

    // ============================================
    // DELETE ROLE
    // ============================================
    $(document).on('click', '.delete-role', function() {
        let roleId = $(this).data('id');
        let roleName = $(this).data('name');
        
        Swal.fire({
            title: 'Delete Role?',
            text: `Are you sure you want to delete "${roleName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/roles/' + roleId,
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: response.message || 'Role deleted successfully',
                            confirmButtonColor: '#0b7a33'
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: xhr.responseJSON?.message || 'Failed to delete role',
                            confirmButtonColor: '#d33'
                        });
                    }
                });
            }
        });
    });

    // ============================================
    // CLOSE MODAL
    // ============================================
    function closeModal() {
        $('#roleModal').fadeOut(function() {
            $('body').css('overflow', '');
        });
    }

    $('.closeModal, .closeModalBtn').click(function() {
        closeModal();
    });

    $(window).click(function(e) {
        if ($(e.target).is('#roleModal')) {
            closeModal();
        }
    });

    $(document).keydown(function(e) {
        if (e.key === 'Escape' && $('#roleModal').is(':visible')) {
            closeModal();
        }
    });
});

function showTableLoading() {
    $('#rolesTableBody').html('<tr><td colspan="3" class="text-center py-5"><i class="fas fa-spinner fa-pulse fa-2x text-success"></i><p class="mt-2" style="font-size: 14px;">Loading roles...</p></td></tr>');
}
</script>
@endsection