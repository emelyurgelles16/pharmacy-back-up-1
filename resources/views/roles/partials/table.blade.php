@php
    // ============================================================
    // DEFINE PERMISSION GROUPS
    // ============================================================
    $permissionGroups = [
        '📊 Dashboard' => ['view dashboard', 'view sales metrics', 'view inventory metrics'],
        '📦 Inventory' => ['view inventory', 'view inventory read only', 'create inventory', 'edit inventory', 'update stock', 'delete product', 'edit product', 'view inventory reports'],
        '🛒 POS' => ['view pos', 'process payment', 'void transaction', 'print receipts', 'view receipts', 'view own receipts'],
        '🏷️ Promos & Discounts' => ['view promos', 'manage promos', 'view discounts', 'manage discounts'],
        '📁 Categories' => ['view categories', 'manage categories'],
        '💊 Prescriptions' => ['view prescriptions'],
        '📈 Reports' => ['view sales reports', 'view inventory reports', 'export reports'],
        '👥 Users' => ['view users', 'create users', 'edit users', 'delete users', 'reset user passwords'],
        '🔑 Roles' => ['view roles', 'create roles', 'edit roles', 'delete roles', 'manage roles'],
        '🔒 Permissions' => ['view permissions', 'create permissions', 'edit permissions', 'delete permissions', 'manage permissions'],
        '⚙️ Settings' => ['view settings', 'edit settings'],
        '📜 Logs' => ['view logs', 'delete logs'],
    ];
@endphp

@forelse(\Spatie\Permission\Models\Role::with('permissions')->get() as $role)
@php
    // ============================================================
    // GROUP THE PERMISSIONS
    // ============================================================
    $permNames = $role->permissions->pluck('name')->toArray();
    $groupedPermissions = [];
    
    foreach ($permissionGroups as $group => $perms) {
        $matched = array_intersect($permNames, $perms);
        if (!empty($matched)) {
            $groupedPermissions[$group] = $matched;
        }
    }
    
    // ============================================================
    // HANDLE UNGROUPED PERMISSIONS
    // ============================================================
    $allGrouped = array_merge(...array_values($permissionGroups));
    $ungrouped = array_diff($permNames, $allGrouped);
    if (!empty($ungrouped)) {
        $groupedPermissions['🧩 Others'] = $ungrouped;
    }
    
    // ============================================================
    // ROLE ICON
    // ============================================================
    $roleIcon = 'user';
    if($role->name == 'Admin') { $roleIcon = 'crown'; }
    elseif($role->name == 'Cashier') { $roleIcon = 'cash-register'; }
    elseif($role->name == 'Pharmacist') { $roleIcon = 'prescription-bottle'; }
    elseif($role->name == 'Pharmacy Assistant') { $roleIcon = 'user'; }
    
    // ============================================================
    // ROLE CLASS FOR BADGE
    // ============================================================
    $roleClass = strtolower(str_replace(' ', '.', $role->name));
@endphp
<tr data-role="{{ $role->name }}" data-permissions="{{ $role->permissions->count() }}">
    <!-- ROLE NAME COLUMN -->
    <td style="vertical-align: top; padding-top: 15px;">
        <span class="role-badge {{ $roleClass }}">
            <i class="fas fa-{{ $roleIcon }}"></i>
            {{ $role->name }}
        </span>
        <br>
        <small class="text-muted" style="font-size: 10px;">
            <i class="fas fa-key"></i> {{ $role->permissions->count() }} permission(s)
        </small>
    </td>
    
    <!-- PERMISSIONS COLUMN (GROUPED) -->
    <td style="padding: 8px 10px;">
        @if(!empty($groupedPermissions))
            <div class="permissions-scroll">
                @foreach($groupedPermissions as $group => $perms)
                <div class="perm-group-container">
                    <span class="perm-group-label">{{ $group }}</span>
                    <div class="d-flex flex-wrap gap-1">
                        @foreach($perms as $perm)
                            <span class="perm-badge">
                                <i class="fas fa-check-circle"></i>
                                {{ str_replace('view ', '', $perm) }}
                            </span>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <span class="text-muted small">
                <i class="fas fa-info-circle"></i> No permissions assigned
            </span>
        @endif
    </td>
    
    <!-- ACTIONS COLUMN -->
    <td style="vertical-align: top; padding-top: 15px;">
        <div class="d-flex gap-1">
            <button class="btn-action edit" title="Edit Role" onclick="editRole({{ $role->id }})">
                <i class="fa-solid fa-pen"></i>
            </button>
            @if(!in_array($role->name, ['Admin', 'Cashier', 'Pharmacist', 'Pharmacy Assistant']))
            <button class="btn-action delete" title="Delete Role" onclick="deleteRole({{ $role->id }})">
                <i class="fa-solid fa-trash"></i>
            </button>
            @endif
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="3" class="text-center py-4 text-muted">
        <i class="fas fa-key fa-2x d-block mb-2 opacity-50"></i>
        No roles found.
        <br>
        <small class="text-muted">Click "Add Role" to create your first role.</small>
    </td>
</tr>
@endforelse