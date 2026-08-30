@extends('layouts.app')

@section('title', 'Permission Management')

@section('content')
<style>
    .permissions-list {
        max-width: 400px;
    }
    .perm-badge {
        display: inline-block;
        background: #e8f5e9;
        color: #2e7d32;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        margin: 2px 4px 2px 0;
        white-space: nowrap;
    }
    .perm-badge i {
        margin-right: 4px;
        font-size: 10px;
    }
    .table-permissions {
        max-width: 500px;
    }
    .role-icon {
        font-size: 16px;
        margin-right: 8px;
    }
    .role-admin { color: #dc3545; }
    .role-cashier { color: #28a745; }
    .role-pa { color: #17a2b8; }
    .role-pharmacist { color: #6f42c1; 
    } 

    /* Custom Scrollbar for table */
.card-body.p-0::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

.card-body.p-0::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
}

.card-body.p-0::-webkit-scrollbar-thumb {
    background: #1b5e20;
    border-radius: 10px;
}

.card-body.p-0::-webkit-scrollbar-thumb:hover {
    background: #2e7d32;
}

/* Sticky header */
.table thead th {
    position: sticky;
    top: 0;
    background: #f8f9fa;
    z-index: 10;
}

 .modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
    }
    .form-check {
        padding: 5px;
    }
    .form-check:hover {
        background: #f8f9fa;
        border-radius: 5px;
    }
</style>

<div class="container-fluid">
<!-- Header Box -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card" style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%);">
            <div class="card-body" style="padding: 25px 30px;">
                <div>
                    <h4 class="mb-1 text-white">
                        <i class="fas fa-key me-2"></i> Permission Management
                    </h4>
                    <p class="mb-0 text-white-50">Manage system roles and their permissions</p>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Search Bar and Add Button -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="input-group">
            <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-search text-muted"></i>
            </span>
            <input type="text" id="searchRole" class="form-control border-start-0" placeholder="Search role...">
        </div>
    </div>
    <div class="col-md-6 text-end">
        <button id="addRoleBtn" class="btn btn-success">
            <i class="fas fa-plus me-2"></i> Add Role with Permissions
        </button>
    </div>
</div>

    
    <div class="card shadow-sm">
    <div class="card-header bg-white py-3">
        <h5 class="mb-0">
            <i class="fas fa-list me-2 text-success"></i> Roles & Permissions
        </h5>
    </div>
    <div class="card-body p-0" style="max-height: 500px; overflow-y: auto;">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light" style="position: sticky; top: 0; z-index: 10;">
                    <tr>
                        <th style="width: 20%; position: sticky; top: 0; background: #f8f9fa;">Role</th>
                        <th style="width: 65%; position: sticky; top: 0; background: #f8f9fa;">Permissions</th>
                        <th style="width: 15%; position: sticky; top: 0; background: #f8f9fa;">Actions</th>
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
                        <td style="vertical-align: middle;">
                            <span class="role-icon {{ $roleClass }}">{{ $roleIcon }}</span>
                            <strong>{{ $role->name }}</strong>
                        </td>
                        <td class="permissions-cell" style="vertical-align: middle;">
                            @foreach($role->permissions as $perm)
                            <span class="perm-badge">
                                <i class="fas fa-check-circle text-success"></i> {{ $perm->name }}
                            </span>
                            @endforeach
                            @if($role->permissions->count() == 0)
                            <span class="text-muted">No permissions assigned</span>
                            @endif
                        </td>
                        <td style="vertical-align: middle;">
                            <button class="btn btn-sm btn-warning edit-role" data-id="{{ $role->id }}" data-name="{{ $role->name }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            @if(!in_array($role->name, ['Admin', 'Cashier', 'Pharmacy Assistant', 'Pharmacist']))
                            <button class="btn btn-sm btn-danger delete-role" data-id="{{ $role->id }}" data-name="{{ $role->name }}">
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
    <div class="card-footer bg-white">
        {{ $roles->links() }}
    </div>
</div>

<!-- Add/Edit Role Modal -->
<div id="roleModal" class="modal" style="display: none;">
    <div style="background: white; margin: 5% auto; padding: 0; width: 90%; max-width: 800px; border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #0b7a33 0%, #056b28 100%); color: white; padding: 15px 20px; border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
            <h4 style="margin: 0;" id="modalTitle"><i class="fas fa-plus me-2"></i> Add Role</h4>
            <button class="closeModal" style="background: none; border: none; color: white; font-size: 28px; cursor: pointer;">&times;</button>
        </div>
        <div style="padding: 20px; max-height: 500px; overflow-y: auto;">
            <div class="mb-3">
                <label class="form-label">Role Name</label>
                <input type="text" id="roleName" class="form-control" placeholder="Enter role name">
                <input type="hidden" id="roleId">
            </div>
            <div class="mb-3">
                <label class="form-label fw-bold">Permissions</label>
                <div class="row" id="permissionsList">
                    <!-- Permissions will be loaded here -->
                </div>
            </div>
            <div class="text-end">
                <button type="button" class="btn btn-secondary closeModalBtn">Cancel</button>
                <button type="button" id="saveRoleBtn" class="btn btn-success">Save Role</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    let allPermissions = @json($permissions ?? []);

    // Search Role
$('#searchRole').on('keyup', function() {
    let search = $(this).val().toLowerCase();
    let visibleCount = 0;
    
    $('.role-row').each(function() {
        let roleName = $(this).data('role-name').toLowerCase();
        let isVisible = roleName.indexOf(search) > -1;
        $(this).toggle(isVisible);
        if (isVisible) visibleCount++;
    });
    
    // Show/hide no results message
    if (visibleCount === 0 && $('#rolesTableBody').children().length > 0) {
        if ($('#noResultsRow').length === 0) {
            $('#rolesTableBody').append('<tr id="noResultsRow"><td colspan="3" class="text-center text-muted py-4">No roles found matching your search.</td></tr>');
        }
    } else {
        $('#noResultsRow').remove();
    }
});
    
// Load permissions list (using permission IDs)
function loadPermissions(selectedPermissions = []) {
    let html = '<div class="row">';
    allPermissions.forEach(perm => {
        let isChecked = selectedPermissions.includes(perm.id) ? 'checked' : '';
        html += `
            <div class="col-md-6 mb-2">
                <div class="form-check">
                    <input class="form-check-input perm-checkbox" type="checkbox" value="${perm.id}" id="perm_${perm.id}" ${isChecked}>
                    <label class="form-check-label" for="perm_${perm.id}">
                        <i class="fas fa-check-circle text-success"></i> ${perm.name}
                    </label>
                </div>
            </div>
        `;
    });
    html += '</div>';
    $('#permissionsList').html(html);
}
    
    // Add Role Modal
    $('#addRoleBtn').click(function() {
        $('#modalTitle').html('<i class="fas fa-plus me-2"></i> Add Role');
        $('#roleId').val('');
        $('#roleName').val('');
        loadPermissions([]);
        $('#roleModal').fadeIn();
    });
    
    // Edit Role Modal
    $(document).on('click', '.edit-role', function() {
        let roleId = $(this).data('id');
        let roleName = $(this).data('name');
        
        $('#modalTitle').html('<i class="fas fa-edit me-2"></i> Edit Role');
        $('#roleId').val(roleId);
        $('#roleName').val(roleName);
        
        // Get current permissions for this role
        $.ajax({
            url: '/roles/' + roleId + '/permissions',
            method: 'GET',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                loadPermissions(response.permissions);
                $('#roleModal').fadeIn();
            },
            error: function(xhr) {
                console.error('Error loading permissions:', xhr);
                loadPermissions([]);
                $('#roleModal').fadeIn();
            }
        });
    });
    
// Save Role (Create/Update)
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
                    text: response.message,
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
    
    // Delete Role
    $(document).on('click', '.delete-role', function() {
        let roleId = $(this).data('id');
        let roleName = $(this).data('name');
        
        Swal.fire({
            title: 'Delete Role?',
            text: `Are you sure you want to delete "${roleName}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, delete!'
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
                            text: response.message,
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
    
    // Search Role
    $('#searchRole').on('keyup', function() {
        let search = $(this).val().toLowerCase();
        $('.role-row').each(function() {
            let roleName = $(this).data('role-name').toLowerCase();
            $(this).toggle(roleName.indexOf(search) > -1);
        });
    });
    
    // Close modal
    $('.closeModal, .closeModalBtn').click(function() {
        $('#roleModal').fadeOut();
    });
    
    // Click outside modal to close
    $(window).click(function(e) {
        if ($(e.target).is('#roleModal')) {
            $('#roleModal').fadeOut();
        }
    });
});

// Show loading state
function showTableLoading() {
    $('#rolesTableBody').html('<tr><td colspan="3" class="text-center py-5"><i class="fas fa-spinner fa-pulse fa-2x text-success"></i><p class="mt-2">Loading roles...</p></td></tr>');
}

</script>
@endsection