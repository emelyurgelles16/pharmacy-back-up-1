<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\ActivityLog;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view roles']);
    }

    public function index()
    {
        $roles = Role::with('permissions')->paginate(15);
        return view('user-access.roles.index', compact('roles'));
    }

    public function create()
    {
        $this->authorize('create roles');
        $permissions = Permission::all();
        return view('user-access.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create roles');
        
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles',
            ]);

            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web'
            ]);
            
            if ($request->has('permissions') && is_array($request->permissions)) {
                $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
                if (!empty($permissionNames)) {
                    $role->syncPermissions($permissionNames);
                }
            }

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'create',
                'Roles',
                'Created role: ' . $request->name
            );

            return response()->json([
                'success' => true,
                'message' => 'Role created successfully!'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Role $role)
    {
        $this->authorize('edit roles');
        
        try {
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
            ]);

            $oldName = $role->name;
            $role->update(['name' => $request->name]);
            
            if ($request->has('permissions')) {
                $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
                $role->syncPermissions($permissionNames);
            } else {
                $role->syncPermissions([]);
            }

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'update',
                'Roles',
                'Updated role: ' . $oldName . ' → ' . $request->name
            );

            return response()->json([
                'success' => true,
                'message' => 'Role updated successfully!'
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed: ' . implode(', ', array_merge(...array_values($e->errors())))
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete roles');
        
        $protectedRoles = ['Admin', 'Cashier', 'Pharmacy Assistant', 'Pharmacist'];
        
        if (in_array($role->name, $protectedRoles)) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete system role.'
            ], 422);
        }
        
        $roleName = $role->name;
        $role->delete();
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'delete',
            'Roles',
            'Deleted role: ' . $roleName
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully!'
        ]);
    }

    public function getPermissions($id)
    {
        try {
            $role = Role::findOrFail($id);
            $permissions = $role->permissions->pluck('id')->toArray();
            return response()->json([
                'success' => true,
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPermissionList()
    {
        try {
            $permissions = Permission::all(['id', 'name']);
            return response()->json([
                'success' => true,
                'permissions' => $permissions
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}