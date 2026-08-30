<?php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create your existing roles
        $roles = [
            'Admin',
            'Cashier',
            'Pharmacy Assistant',
            'Pharmacist'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // Create permissions for User & Access module
        $userAccessPermissions = [
            'view users',
            'create users', 
            'edit users',
            'delete users',
            'reset user passwords',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
        ];

        foreach ($userAccessPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Assign all permissions to Admin role
        $adminRole = Role::findByName('Admin');
        $adminRole->givePermissionTo(Permission::all());

        // Assign limited permissions to Pharmacy Assistant
        $pharmacyRole = Role::findByName('Pharmacy Assistant');
        $pharmacyRole->givePermissionTo([
            'view users',
            'view roles',
            'view permissions',
        ]);

        // Cashier has no user access permissions
        // Pharmacist has no user access permissions

        // Create default admin user if not exists
        if (!User::where('email', 'admin@pharmacy.com')->exists()) {
            $admin = User::create([
                'username' => 'admin',
                'full_name' => 'System Administrator',
                'email' => 'admin@pharmacy.com',
                'password' => Hash::make('Admin@123'),
                'is_active' => true,
            ]);
            $admin->assignRole('Admin');
        }

        // Create sample users for testing (optional)
        if (!User::where('email', 'cashier@pharmacy.com')->exists()) {
            $cashier = User::create([
                'username' => 'cashier',
                'full_name' => 'Cashier User',
                'email' => 'cashier@pharmacy.com',
                'password' => Hash::make('Cashier@123'),
                'is_active' => true,
            ]);
            $cashier->assignRole('Cashier');
        }

        if (!User::where('email', 'pharmacy@pharmacy.com')->exists()) {
            $pharmacy = User::create([
                'username' => 'pharmacy',
                'full_name' => 'Pharmacy Staff',
                'email' => 'pharmacy@pharmacy.com',
                'password' => Hash::make('Pharmacy@123'),
                'is_active' => true,
            ]);
            $pharmacy->assignRole('Pharmacy Assistant');
        }
        
        if (!User::where('email', 'pharmacist@pharmacy.com')->exists()) {
            $pharmacist = User::create([
                'username' => 'pharmacist',
                'full_name' => 'Staff Pharmacist',
                'email' => 'pharmacist@pharmacy.com',
                'password' => Hash::make('Pharmacist@123'),
                'is_active' => true,
            ]);
            $pharmacist->assignRole('Pharmacist');
        }
    }
}