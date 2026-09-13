<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\ActivityLog;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'permission:view users']);
    }

    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('role') && $request->role != 'all') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        if ($request->filled('status') && $request->status != 'all') {
            $query->where('is_active', $request->status == 'active' ? 1 : 0);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('employee_id', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('user-access.users.partials.table', compact('users'))->render(),
                'pagination' => (string) $users->links()
            ]);
        }

        return view('user-access.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create users');
        $roles = Role::all();
        $permissions = Permission::all();
        return view('user-access.users.create', compact('roles', 'permissions'));
    }

    public function store(Request $request)
    {
        $this->authorize('create users');
        
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:users',
                'full_name' => 'required|string|max:30',
                'email' => 'required|email|max:30|unique:users',
                'employee_id' => 'nullable|string|max:20|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'contact_number' => 'nullable|string|max:15',
                'address' => 'nullable|string',
                'role' => 'required|string|exists:roles,name',
                'is_active' => 'nullable|boolean',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'resume' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
                'notes' => 'nullable|string',
            ]);

            // Create user
            $user = User::create([
                'username' => $validated['username'],
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'employee_id' => $validated['employee_id'] ?? null,
                'password' => Hash::make($validated['password']),
                'contact_number' => $validated['contact_number'] ?? null,
                'address' => $validated['address'] ?? null,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'notes' => $validated['notes'] ?? null,
                'is_verified' => 1,
            ]);

            // Assign role
            $user->assignRole($validated['role']);

            // Handle profile photo
            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/profile_photos', $filename);
                $user->profile_photo = 'profile_photos/' . $filename;
            }

            // Handle resume
            if ($request->hasFile('resume')) {
                $file = $request->file('resume');
                $filename = 'resume_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/resumes', $filename);
                $user->resume = 'resumes/' . $filename;
            }
            
            $user->save();

            // Log activity
            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'add_user',
                'User & Access',
                'Added new user: ' . $user->username . ' with role: ' . $validated['role'],
                'Success'
            );

            return response()->json([
                'success' => true,
                'message' => 'Employee created successfully!',
                'redirect' => route('user-access.index')
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please check the form for errors.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show(User $user)
    {
        $user->load('roles', 'permissions');
        return view('user-access.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('edit users');
        $roles = Role::all();
        $permissions = Permission::all();
        $userRoles = $user->roles->pluck('id')->toArray();
        $userPermissions = $user->permissions->pluck('id')->toArray();
        
        return view('user-access.users.edit', compact('user', 'roles', 'permissions', 'userRoles', 'userPermissions'));
    }

    public function editData($id)
    {
        try {
            $user = User::with('roles')->findOrFail($id);
            return response()->json([
                'success' => true,
                'user' => [
                    'id' => $user->id,
                    'full_name' => $user->full_name,
                    'username' => $user->username,
                    'employee_id' => $user->employee_id,
                    'email' => $user->email,
                    'contact_number' => $user->contact_number,
                    'address' => $user->address,
                    'notes' => $user->notes,
                    'role' => $user->roles->first()->name ?? 'Cashier',
                    'is_active' => $user->is_active
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('edit users');
        
        try {
            $validated = $request->validate([
                'username' => 'required|string|max:50|unique:users,username,' . $user->id,
                'full_name' => 'required|string|max:30',
                'email' => 'required|email|max:30|unique:users,email,' . $user->id,
                'employee_id' => 'nullable|string|max:20|unique:users,employee_id,' . $user->id,
                'contact_number' => 'nullable|string|max:15',
                'address' => 'nullable|string',
                'role' => 'nullable|string|exists:roles,name',
                'is_active' => 'nullable|boolean',
                'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'resume' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
                'notes' => 'nullable|string',
            ]);

            $oldValues = [
                'full_name' => $user->full_name,
                'email' => $user->email,
                'contact_number' => $user->contact_number,
                'address' => $user->address,
            ];

            $user->update([
                'username' => $validated['username'],
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'employee_id' => $validated['employee_id'] ?? null,
                'contact_number' => $validated['contact_number'] ?? null,
                'address' => $validated['address'] ?? null,
                'is_active' => $request->has('is_active') ? 1 : 0,
                'notes' => $validated['notes'] ?? null,
            ]);

            // Handle profile photo
            if ($request->hasFile('profile_photo')) {
                if ($user->profile_photo && file_exists(storage_path('app/public/' . $user->profile_photo))) {
                    unlink(storage_path('app/public/' . $user->profile_photo));
                }
                $file = $request->file('profile_photo');
                $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/profile_photos', $filename);
                $user->profile_photo = 'profile_photos/' . $filename;
            }

            // Handle resume
            if ($request->hasFile('resume')) {
                if ($user->resume && file_exists(storage_path('app/public/' . $user->resume))) {
                    unlink(storage_path('app/public/' . $user->resume));
                }
                $file = $request->file('resume');
                $filename = 'resume_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/resumes', $filename);
                $user->resume = 'resumes/' . $filename;
            }
            
            $user->save();

            // Handle role update
            if ($request->has('role')) {
                $oldRole = $user->roles->first()->name ?? 'none';
                $user->syncRoles([$request->role]);
                
                ActivityLog::log(
                    auth()->id(),
                    auth()->user()->username,
                    'update_role',
                    'User & Access',
                    'Changed role for user: ' . $user->username . ' from ' . $oldRole . ' to ' . $request->role,
                    'Success'
                );
            }

            // Log activity
            $changes = [];
            if ($user->full_name != $oldValues['full_name']) $changes[] = 'name';
            if ($user->email != $oldValues['email']) $changes[] = 'email';
            if ($user->contact_number != $oldValues['contact_number']) $changes[] = 'contact';
            if ($user->address != $oldValues['address']) $changes[] = 'address';
            $changeList = !empty($changes) ? ' (' . implode(', ', $changes) . ')' : '';

            ActivityLog::log(
                auth()->id(),
                auth()->user()->username,
                'update_user',
                'User & Access',
                'Updated user: ' . $user->username . $changeList,
                'Success'
            );

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully!',
                'redirect' => route('user-access.index')
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Please check the form for errors.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(User $user)
    {
        $this->authorize('delete users');
        
        if ($user->id === auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Cannot delete your own account.'], 422);
        }
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'delete_user',
            'User & Access',
            'Deleted user: ' . $user->username . ' (ID: ' . $user->id . ')',
            'Success'
        );
        
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully!']);
    }

    public function toggleStatus(User $user)
    {
        $this->authorize('edit users');
        $user->update(['is_active' => !$user->is_active]);
        
        $status = $user->is_active ? 'Activated' : 'Deactivated';
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'toggle_user_status',
            'User & Access',
            $status . ' user: ' . $user->username,
            'Success'
        );
        
        return response()->json(['success' => true, 'message' => 'User status updated!']);
    }

    public function resetPassword(Request $request, User $user)
    {
        $this->authorize('reset user passwords');
        
        $request->validate(['password' => 'required|min:6|confirmed']);
        $user->update(['password' => Hash::make($request->password)]);
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'reset_password',
            'User & Access',
            'Reset password for user: ' . $user->username,
            'Success'
        );
        
        return response()->json(['success' => true, 'message' => 'Password reset successfully!']);
    }

    public function deleted()
    {
        $users = User::onlyTrashed()->get();
        return response()->json(['users' => $users]);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'restore_user',
            'User & Access',
            'Restored deleted user: ' . $user->username,
            'Success'
        );
        
        return response()->json(['success' => true, 'message' => 'User restored!']);
    }

    public function syncRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $oldRole = $user->roles->first()->name ?? 'none';
        $user->syncRoles([$request->role]);
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'update_role',
            'User & Access',
            'Updated role for user: ' . $user->username . ' from ' . $oldRole . ' to ' . $request->role,
            'Success'
        );
        
        return response()->json(['success' => true, 'message' => 'Role updated successfully!']);
    }

    public function syncPermissions(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->syncPermissions($request->permissions);
        
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'update_permissions',
            'User & Access',
            'Updated permissions for user: ' . $user->username,
            'Success'
        );
        
        return response()->json(['success' => true, 'message' => 'Permissions updated successfully!']);
    }

    public function uploadDocuments(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'resume' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);
        
        $user = User::findOrFail($request->user_id);
        $uploaded = [];
        
        if ($request->hasFile('resume')) {
            if ($user->resume && file_exists(storage_path('app/public/' . $user->resume))) {
                unlink(storage_path('app/public/' . $user->resume));
            }
            $resume = $request->file('resume');
            $filename = 'resume_' . $user->id . '_' . time() . '.' . $resume->getClientOriginalExtension();
            $resume->storeAs('public/resumes', $filename);
            $user->resume = 'resumes/' . $filename;
            $uploaded[] = 'resume';
        }
        
        $user->save();
        
        $uploadList = implode(' and ', $uploaded);
        ActivityLog::log(
            auth()->id(),
            auth()->user()->username,
            'upload_documents',
            'User & Access',
            'Uploaded ' . $uploadList . ' for user: ' . $user->username,
            'Success'
        );
        
        return response()->json(['success' => true, 'message' => 'Documents uploaded successfully!']);
    }

    /**
     * Get all roles for dropdown/selection
     */
    public function getRoles()
    {
        $roles = Role::all();
        return response()->json([
            'success' => true,
            'roles' => $roles
        ]);
    }

    /**
     * Get role details with icon and description
     */
    public function getRoleDetails($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json([
            'success' => true,
            'role' => $role
        ]);
    }
}