@extends('layouts.app')

@section('title', 'Users & Roles')

@section('content')
<style>
    /* ========== HEADER ========== */
    .user-header {
        background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);
        border-radius: 12px;
        padding: 20px 25px;
        margin-bottom: 25px;
        color: white;
    }
    .user-header h4 { margin: 0; font-weight: 700; }
    .user-header p { margin: 5px 0 0; opacity: 0.8; font-size: 14px; }

    /* ========== STATS ========== */
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 15px 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        transition: all 0.3s;
        border-left: 4px solid #0b7a33;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,0.08); }
    .stat-card .number { font-size: 24px; font-weight: 700; color: #1a1a2e; }
    .stat-card .label { font-size: 13px; color: #6c757d; margin-top: 2px; }
    .stat-card .icon { font-size: 28px; opacity: 0.3; }

    /* ========== TABS ========== */
    .user-tabs {
        display: flex;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        margin-bottom: 25px;
        border: 1px solid #e9ecef;
    }
    .user-tab {
        flex: 1;
        padding: 12px 20px;
        text-align: center;
        text-decoration: none;
        color: #6c757d;
        font-weight: 500;
        font-size: 14px;
        border-bottom: 3px solid transparent;
        transition: all 0.3s;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: white;
    }
    .user-tab:hover { background: #f8f9fa; color: #0b7a33; }
    .user-tab.active {
        color: #0b7a33;
        border-bottom-color: #0b7a33;
        background: #f0fdf4;
    }
    .user-tab i { font-size: 16px; }
    .user-tab .badge-tab {
        background: #0b7a33;
        color: white;
        font-size: 11px;
        padding: 2px 10px;
        border-radius: 20px;
    }

    /* ========== TOOLBAR ========== */
    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 15px;
    }
    .toolbar .search-box {
        display: flex;
        align-items: center;
        background: white;
        border-radius: 10px;
        padding: 4px 15px;
        border: 1px solid #e9ecef;
        transition: all 0.3s;
        flex: 1;
        max-width: 350px;
    }
    .toolbar .search-box:focus-within { border-color: #0b7a33; box-shadow: 0 0 0 3px rgba(11,122,51,0.1); }
    .toolbar .search-box input {
        border: none;
        padding: 10px 12px;
        flex: 1;
        outline: none;
        font-size: 14px;
        background: transparent;
    }
    .toolbar .search-box i { color: #adb5bd; font-size: 16px; }

    .toolbar .filter-group {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .toolbar .filter-group select {
        padding: 8px 32px 8px 14px;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        background: white;
        font-size: 13px;
        outline: none;
        transition: all 0.3s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%236c757d' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
        min-width: 150px;
        cursor: pointer;
    }
    .toolbar .filter-group select:focus { border-color: #0b7a33; box-shadow: 0 0 0 3px rgba(11,122,51,0.1); }
    .toolbar .filter-group select:hover { border-color: #0b7a33; }

    .toolbar .btn-add {
        background: #0b7a33;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 500;
        transition: all 0.3s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .toolbar .btn-add:hover { background: #056b28; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(11,122,51,0.3); }

    /* ========== TABLE ========== */
    .table-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        border: 1px solid #e9ecef;
    }
    .table-card .table-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e9ecef;
        background: #fafbfc;
    }
    .table-card .table-header h5 { margin: 0; font-weight: 600; font-size: 15px; color: #1a1a2e; }
    .table-card .table-header h5 i { color: #0b7a33; margin-right: 8px; }

    .table-card table {
        margin: 0;
        font-size: 13px;
        width: 100%;
    }
    .table-card table th {
        background: #f8f9fa;
        font-weight: 600;
        color: #495057;
        border-bottom: 2px solid #e9ecef;
        padding: 12px 15px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
    }
    .table-card table td {
        padding: 12px 15px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f5;
    }
    .table-card table tbody tr:hover { background: #f8f9fa; }

    /* ========== USER AVATAR ========== */
    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 14px;
        color: white;
        flex-shrink: 0;
    }
    .user-avatar.admin { background: linear-gradient(135deg, #dc3545, #b02a37); }
    .user-avatar.cashier { background: linear-gradient(135deg, #28a745, #1e7e34); }
    .user-avatar.pharmacist { background: linear-gradient(135deg, #6f42c1, #5a32a3); }
    .user-avatar.assistant { background: linear-gradient(135deg, #17a2b8, #0f7c8f); }
    .user-avatar.default { background: linear-gradient(135deg, #6c757d, #495057); }

    /* ========== ROLE BADGE ========== */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    .role-badge.admin { background: #fce4ec; color: #c62828; }
    .role-badge.cashier { background: #e8f5e9; color: #2e7d32; }
    .role-badge.pharmacist { background: #f3e5f5; color: #6a1b9a; }
    .role-badge.pharmacy.assistant { background: #e0f7fa; color: #00695c; }
    .role-badge.no-role { background: #f5f5f5; color: #757575; }

    /* ========== STATUS BADGE ========== */
    .status-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .status-badge.active { background: #e8f5e9; color: #2e7d32; }
    .status-badge.inactive { background: #fce4ec; color: #c62828; }

    /* ========== PERMISSION BADGE ========== */
    .perm-badge {
        font-size: 10px;
        font-weight: 400;
        padding: 2px 10px;
        border-radius: 12px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        color: #333;
        display: inline-block;
        margin: 1px 2px;
    }
    .perm-badge i {
        color: #28a745;
        font-size: 8px;
        margin-right: 3px;
    }

    /* ========== PERMISSION GROUP LABEL ========== */
    .perm-group-label {
        font-size: 10px;
        font-weight: 600;
        color: #0b7a33;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        display: block;
        margin-bottom: 2px;
    }
    .perm-group-container {
        margin-bottom: 6px;
    }
    .perm-group-container:last-child {
        margin-bottom: 0;
    }

    /* ========== PERMISSIONS SCROLL ========== */
    .permissions-scroll {
        max-height: 180px;
        overflow-y: auto;
        padding-right: 4px;
    }
    .permissions-scroll::-webkit-scrollbar {
        width: 3px;
    }
    .permissions-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .permissions-scroll::-webkit-scrollbar-thumb {
        background: #0b7a33;
        border-radius: 10px;
    }

    /* ========== ACTION BUTTONS ========== */
    .btn-action {
        width: 34px;
        height: 34px;
        border: none;
        border-radius: 8px;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-action:hover { transform: scale(1.05); }
    .btn-action.edit { background: #e3f2fd; color: #0d47a1; }
    .btn-action.edit:hover { background: #bbdefb; }
    .btn-action.toggle { background: #fff3e0; color: #e65100; }
    .btn-action.toggle:hover { background: #ffe0b2; }
    .btn-action.delete { background: #fce4ec; color: #c62828; }
    .btn-action.delete:hover { background: #f8bbd0; }
    .btn-action .fa-solid { font-size: 13px; }

    /* ========== PERMISSIONS IN MODAL ========== */
    .perm-checkbox {
        display: inline-block;
        margin-right: 8px;
        margin-bottom: 4px;
    }
    .perm-checkbox label {
        font-size: 12px;
        margin-left: 4px;
        cursor: pointer;
    }
    .perm-checkbox input[type="checkbox"] {
        accent-color: #0b7a33;
        width: 15px;
        height: 15px;
        cursor: pointer;
    }

    /* ========== PAGINATION ========== */
    .pagination-wrapper {
        padding: 15px 20px;
        border-top: 1px solid #e9ecef;
        background: #fafbfc;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 768px) {
        .toolbar { flex-direction: column; align-items: stretch; }
        .toolbar .search-box { max-width: 100%; }
        .toolbar .filter-group { flex-wrap: wrap; }
        .toolbar .filter-group select { flex: 1; min-width: 120px; }
        .user-tabs { flex-direction: column; }
        .user-tab { border-bottom: 1px solid #e9ecef; }
        .user-tab.active { border-bottom: 2px solid #0b7a33; }
        .stat-card .number { font-size: 20px; }
        .table-card table { font-size: 12px; }
        .table-card table th, .table-card table td { padding: 8px 10px; }
    }
</style>

<div class="container-fluid">

    <!-- ========== HEADER ========== -->
    <div class="user-header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h4><i class="fas fa-users-gear me-2"></i> Users & Roles</h4>
                <p>Manage employees, roles, and permissions</p>
            </div>
            <div>
                <span class="badge bg-light text-dark px-3 py-2">
                    <i class="fas fa-user me-1"></i> {{ $users->total() }} Employees
                </span>
            </div>
        </div>
    </div>

    <!-- ========== STATS ========== -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="stat-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="number">{{ $totalUsers ?? $users->total() }}</div>
                        <div class="label">Total Employees</div>
                    </div>
                    <div class="icon"><i class="fas fa-users"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card" style="border-left-color: #28a745;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="number">{{ $activeUsers ?? 0 }}</div>
                        <div class="label">Active Employees</div>
                    </div>
                    <div class="icon"><i class="fas fa-user-check"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card" style="border-left-color: #ffc107;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="number">{{ $totalRoles ?? 0 }}</div>
                        <div class="label">Total Roles</div>
                    </div>
                    <div class="icon"><i class="fas fa-tags"></i></div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="stat-card" style="border-left-color: #17a2b8;">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="number">{{ $totalPermissions ?? 0 }}</div>
                        <div class="label">Permissions</div>
                    </div>
                    <div class="icon"><i class="fas fa-lock"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== TABS ========== -->
    <div class="user-tabs">
        <div class="user-tab active" data-tab="users">
            <i class="fas fa-users"></i> Users
            <span class="badge-tab">{{ $users->total() }}</span>
        </div>
        <div class="user-tab" data-tab="roles">
            <i class="fas fa-key"></i> Roles & Permissions
            <span class="badge-tab">{{ $totalRoles ?? 0 }}</span>
        </div>
    </div>

    <!-- ========== TAB 1: USERS ========== -->
    <div id="tab-users" class="tab-content">
        <div class="toolbar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchUser" placeholder="Search by name, username, or email...">
            </div>
            <div class="filter-group">
                <select id="filterRole">
                    <option value="all">All Roles</option>
                    @foreach(\Spatie\Permission\Models\Role::all() as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                <select id="filterStatus">
                    <option value="all">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button id="applyFilterBtn" class="btn btn-sm btn-outline-secondary" title="Apply Filter">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button id="resetFilterBtn" class="btn btn-sm btn-outline-secondary" title="Reset Filter">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div>
                <button id="addUserBtn" class="btn-add">
                    <i class="fas fa-user-plus"></i> Add Employee
                </button>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h5><i class="fas fa-table"></i> Employee Directory</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 35%;">User</th>
                            <th style="width: 20%;">Role</th>
                            <th style="width: 20%;">Status</th>
                            <th style="width: 25%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="usersTableBody">
                        @include('user-access.users.partials.table')
                    </tbody>
                </table>
            </div>
            @if($users->hasPages())
            <div class="pagination-wrapper">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- ========== TAB 2: ROLES & PERMISSIONS ========== -->
    <div id="tab-roles" class="tab-content" style="display: none;">
        <div class="toolbar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" id="searchRole" placeholder="Search role...">
            </div>
            <div>
                <button id="addRoleBtn" class="btn-add">
                    <i class="fas fa-plus"></i> Add Role
                </button>
            </div>
        </div>

        <div class="table-card">
            <div class="table-header">
                <h5><i class="fas fa-key"></i> Roles & Permissions</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 18%;">Role</th>
                            <th style="width: 67%;">Permissions</th>
                            <th style="width: 15%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="rolesTableBody">
                        @include('roles.partials.table')
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- ========== MODAL: Add/Edit User ========== -->
<div id="userModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="userModalTitle"><i class="fas fa-user-plus me-2"></i> Add Employee</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="userId">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="full_name" id="userFullName" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" id="userUsername" class="form-control" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="userEmail" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3" id="passwordFields">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" id="userPassword" class="form-control">
                            <small class="text-muted">Leave blank to keep current password (edit mode)</small>
                        </div>
                        <div class="col-md-6 mb-3" id="confirmPasswordFields">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="userPasswordConfirm" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Role <span class="text-danger">*</span></label>
                            <select name="role" id="userRole" class="form-select">
                                <option value="Admin">👑 Admin</option>
                                <option value="Cashier">💰 Cashier</option>
                                <option value="Pharmacist">💊 Pharmacist</option>
                                <option value="Pharmacy Assistant">📦 Pharmacy Assistant</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="is_active" id="userStatus" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Number</label>
                            <input type="text" name="contact_number" id="userContact" class="form-control" placeholder="Optional">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" id="userAddress" class="form-control" rows="2" placeholder="Optional"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="saveUserBtn"><i class="fas fa-save me-2"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- ========== MODAL: Add/Edit Role ========== -->
<div id="roleModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="roleModalTitle"><i class="fas fa-edit me-2"></i> Edit Role</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="roleId">
                <div class="mb-3">
                    <label class="form-label fw-bold">Role Name</label>
                    <input type="text" id="roleName" class="form-control" placeholder="Enter role name">
                </div>
                <div class="mb-3" id="permissionsContainer">
                    <label class="form-label fw-bold">Permissions</label>
                    <div id="permissionsList">
                        <div class="text-center py-3 text-muted">
                            <i class="fas fa-spinner fa-pulse me-2"></i> Loading permissions...
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="saveRoleBtn"><i class="fas fa-save me-2"></i> Save Role</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // ========== TABS ==========
    $('.user-tab').click(function() {
        $('.user-tab').removeClass('active');
        $(this).addClass('active');
        $('.tab-content').hide();
        const tabId = $(this).data('tab');
        $('#tab-' + tabId).show();
    });

    // ========== USERS SEARCH ==========
    $('#searchUser').on('input', function() {
        applyUserFilters();
    });

    $('#filterRole, #filterStatus').on('change', function() {
        applyUserFilters();
    });

    $('#applyFilterBtn').on('click', function() {
        applyUserFilters();
    });

    $('#resetFilterBtn').on('click', function() {
        $('#filterRole').val('all');
        $('#filterStatus').val('all');
        $('#searchUser').val('');
        applyUserFilters();
    });

    function applyUserFilters() {
        const search = $('#searchUser').val().toLowerCase();
        const roleFilter = $('#filterRole').val();
        const statusFilter = $('#filterStatus').val();

        $('#usersTableBody tr').each(function() {
            const name = $(this).data('name') || '';
            const email = $(this).data('email') || '';
            const role = $(this).data('role') || '';
            const status = $(this).data('status') || '';

            let show = true;
            if (search && !name.includes(search) && !email.includes(search)) show = false;
            if (roleFilter !== 'all' && role !== roleFilter) show = false;
            if (statusFilter !== 'all' && status !== statusFilter) show = false;
            $(this).toggle(show);
        });
    }

    // ========== ROLES SEARCH ==========
    $('#searchRole').on('input', function() {
        const search = $(this).val().toLowerCase();
        $('#rolesTableBody tr').each(function() {
            const role = $(this).data('role') || '';
            const show = role.includes(search);
            $(this).toggle(show);
        });
    });

    // ========== ADD USER ==========
    $('#addUserBtn').click(function() {
        $('#userModalTitle').html('<i class="fas fa-user-plus me-2"></i> Add Employee');
        $('#userForm')[0].reset();
        $('#userId').val('');
        $('#passwordFields').show();
        $('#confirmPasswordFields').show();
        $('#userPassword').prop('required', true);
        $('#userPasswordConfirm').prop('required', true);
        $('#userModal').modal('show');
    });

    // ========== SAVE USER ==========
    $('#saveUserBtn').click(function() {
        const formData = new FormData($('#userForm')[0]);
        const userId = $('#userId').val();
        const url = userId ? '/users/' + userId : '/users';
        const method = 'POST';
        if (userId) formData.append('_method', 'PUT');

        Swal.fire({ title: 'Saving...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        fetch(url, {
            method: method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ icon: 'success', title: 'Success!', text: data.message, timer: 1500, showConfirmButton: false })
                .then(() => location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Error!', text: data.message || 'Failed to save user.' });
            }
        })
        .catch(() => {
            Swal.fire({ icon: 'error', title: 'Error!', text: 'Something went wrong. Please try again.' });
        });
    });

    // ========== ADD ROLE WITH PERMISSIONS ==========
    $('#addRoleBtn').click(function() {
        $('#roleModalTitle').html('<i class="fas fa-plus me-2"></i> Add New Role');
        $('#roleId').val('');
        $('#roleName').val('');
        $('#permissionsList').html(`
            <div class="text-center py-3 text-muted">
                <i class="fas fa-spinner fa-pulse me-2"></i> Loading permissions...
            </div>
        `);
        $('#roleModal').modal('show');
        loadPermissions([]);
    });

    // ========== SAVE ROLE (Add & Edit) ==========
    $('#saveRoleBtn').off('click').on('click', function() {
        const roleId = $('#roleId').val();
        const roleName = $('#roleName').val();
        const permissions = [];
        $('.perm-checkbox:checked').each(function() { 
            permissions.push(parseInt($(this).val())); 
        });

        if (!roleName) {
            Swal.fire({ icon: 'error', title: 'Error!', text: 'Please enter role name.' });
            return;
        }

        Swal.fire({ title: 'Saving...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        const url = roleId ? '/roles/' + roleId : '/roles';
        const method = roleId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: { 
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            body: JSON.stringify({ 
                name: roleName, 
                permissions: permissions 
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || (roleId ? 'Role updated successfully!' : 'Role created successfully!'),
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    location.reload();
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: data.message || 'Failed to save role'
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Something went wrong. Please try again.'
            });
        });
    });
});

// ========== EDIT USER ==========
function editUser(id) {
    fetch('/users/' + id + '/edit-data')
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            const u = data.user;
            $('#userId').val(u.id);
            $('#userFullName').val(u.full_name);
            $('#userUsername').val(u.username);
            $('#userEmail').val(u.email);
            $('#userContact').val(u.contact_number);
            $('#userRole').val(u.role);
            $('#userStatus').val(u.is_active ? '1' : '0');
            $('#passwordFields').hide();
            $('#confirmPasswordFields').hide();
            $('#userPassword').prop('required', false);
            $('#userPasswordConfirm').prop('required', false);
            $('#userModalTitle').html('<i class="fas fa-user-edit me-2"></i> Edit Employee');
            $('#userModal').modal('show');
        }
    });
}

// ========== TOGGLE STATUS ==========
function toggleStatus(id, currentStatus) {
    const action = currentStatus ? 'deactivate' : 'activate';
    Swal.fire({
        title: action.toUpperCase() + ' Employee?',
        text: 'Are you sure you want to ' + action + ' this employee?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, ' + action + '!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/users/' + id + '/toggle-status', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => location.reload());
                }
            });
        }
    });
}

// ========== DELETE USER ==========
function deleteUser(id, name) {
    Swal.fire({
        title: 'Delete Employee?',
        text: 'Are you sure you want to delete "' + name + '"? This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/users/' + id, {
                method: 'DELETE',
                headers: { 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => location.reload());
                }
            });
        }
    });
}

// ========== EDIT ROLE ==========
function editRole(id) {
    $('#roleId').val(id);
    $('#roleModalTitle').html('<i class="fas fa-edit me-2"></i> Edit Role');
    $('#permissionsList').html(`
        <div class="text-center py-3 text-muted">
            <i class="fas fa-spinner fa-pulse me-2"></i> Loading permissions...
        </div>
    `);
    $('#roleModal').modal('show');
    
    fetch('/roles/' + id + '/permissions')
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            $('#roleId').val(id);
            $('#roleName').val(data.role_name || '');
            loadPermissions(data.permissions);
        }
    })
    .catch(() => {
        $('#permissionsList').html(`
            <div class="text-center py-3 text-danger">
                <i class="fas fa-exclamation-circle me-2"></i> Failed to load permissions
            </div>
        `);
    });
}

// ========== LOAD PERMISSIONS ==========
function loadPermissions(selected) {
    fetch('/permissions/list')
    .then(res => res.json())
    .then(data => {
        let html = '';
        data.permissions.forEach(perm => {
            const checked = selected && selected.includes(perm.id) ? 'checked' : '';
            html += `
                <div class="col-md-4 mb-2">
                    <div class="perm-checkbox">
                        <input type="checkbox" class="perm-checkbox" value="${perm.id}" id="perm_${perm.id}" ${checked}>
                        <label for="perm_${perm.id}">${perm.name}</label>
                    </div>
                </div>
            `;
        });
        $('#permissionsList').html(html);
    });
}

// ========== DELETE ROLE ==========
function deleteRole(id) {
    Swal.fire({
        title: 'Delete Role?',
        text: 'Are you sure you want to delete this role?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/roles/' + id, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => location.reload());
                }
            });
        }
    });
}
</script>
@endsection