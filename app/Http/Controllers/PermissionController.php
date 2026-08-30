<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view permissions']);
    }

    public function index()
    {
        $roles = Role::with('permissions')->paginate(15);
        $permissions = Permission::all();
        return view('permissions.index', compact('roles', 'permissions'));
    }

    public function create()
    {
        $this->authorize('create permissions');
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create permissions');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
        ]);

        Permission::create(['name' => $request->name, 'guard_name' => 'web']);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission created successfully!');
    }

    public function edit(Permission $permission)
    {
        $this->authorize('edit permissions');
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $this->authorize('edit permissions');
        
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully!');
    }

    public function destroy(Permission $permission)
    {
        $this->authorize('delete permissions');
        $permission->delete();
        return response()->json(['success' => true, 'message' => 'Permission deleted successfully!']);
    }

    public function getPermissionsData()
    {
        try {
            $roles = Role::with('permissions')->get();
            
            $rolesData = [];
            foreach ($roles as $role) {
                $rolesData[] = [
                    'id' => $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions->map(function($perm) {
                        return [
                            'id' => $perm->id,
                            'name' => $perm->name
                        ];
                    })
                ];
            }
            
            return response()->json([
                'success' => true,
                'roles' => $rolesData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPermissionsList()
    {
        try {
            $permissions = Permission::all();
            
            $permissionsData = [];
            foreach ($permissions as $perm) {
                $permissionsData[] = [
                    'id' => $perm->id,
                    'name' => $perm->name
                ];
            }
            
            return response()->json([
                'success' => true,
                'permissions' => $permissionsData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}