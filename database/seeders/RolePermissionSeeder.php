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

        // ============================================================
        // CREATE ROLES
        // ============================================================
        $roles = [
            'Admin',
            'Cashier',
            'Pharmacy Assistant',
            'Pharmacist'
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        // ============================================================
        // CREATE ALL PERMISSIONS
        // ============================================================
        $allPermissions = [
            // ===== Dashboard =====
            'view dashboard',
            'view sales metrics',
            'view inventory metrics',

            // ===== Inventory =====
            'view inventory',
            'view inventory read only',
            'create inventory',
            'edit inventory',
            'update stock',
            'view inventory reports',

            // ===== POS & Transactions =====
            'view pos',
            'process payment',
            'void transaction',
            'print receipts',
            'view receipts',
            'view own receipts',
            'view promos',
            'manage promos',
            'view discounts',
            'manage discounts',

            // ===== Products =====
            'view products',
            'create product',
            'edit product',
            'delete product',
            'view categories',
            'manage categories',

            // ===== Medicine Classification =====
            'view drug classifications',
            'create drug classifications',
            'edit drug classifications',
            'delete drug classifications',
            'view dosage forms',
            'create dosage forms',
            'edit dosage forms',
            'delete dosage forms',

            // ===== Sales & Reports =====
            'view sales reports',
            'export reports',

            // ===== User Management =====
            'view users',
            'create users',
            'edit users',
            'delete users',
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',
            'reset user passwords',

            // ===== Permissions =====
            'view permissions',
            'create permissions',
            'edit permissions',
            'delete permissions',
            'manage roles',
            'manage permissions',

            // ===== Prescriptions =====
            'view prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'delete prescriptions',

            // ===== System =====
            'view settings',
            'edit settings',
            'view logs',
            'delete logs',

            // ===== Others =====
            'test permission',
        ];

        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // ============================================================
        // ASSIGN PERMISSIONS TO ROLES
        // ============================================================

        // ✅ ADMIN — ALL permissions
        $adminRole = Role::findByName('Admin');
        $adminRole->syncPermissions(Permission::all());

        // ============================================================
        // ✅ CASHIER — Limited access (READ-ONLY sa inventory)
        // ============================================================
        $cashierRole = Role::findByName('Cashier');
        $cashierRole->syncPermissions([
            // Dashboard
            'view dashboard',
            
            // POS
            'view pos',
            'process payment',
            'print receipts',
            
            // Receipts
            'view receipts',
            'view own receipts',
            
            // Products — VIEW ONLY
            'view products',
            'view inventory read only',
            
            // Promos & Discounts — VIEW ONLY
            'view promos',
            'view discounts',
        ]);

        // ============================================================
        // ✅ PHARMACY ASSISTANT — Full access sa inventory & products
        // ============================================================
        $pharmacyRole = Role::findByName('Pharmacy Assistant');
        $pharmacyRole->syncPermissions([
            // Dashboard
            'view dashboard',
            'view sales metrics',
            'view inventory metrics',
            
            // Inventory
            'view inventory',
            'create inventory',
            'edit inventory',
            'update stock',
            'view inventory reports',
            
            // Products — FULL ACCESS
            'view products',
            'create product',
            'edit product',
            'delete product',
            
            // Categories
            'view categories',
            'manage categories',
            
            // Medicine Classification — FULL ACCESS
            'view drug classifications',
            'create drug classifications',
            'edit drug classifications',
            'delete drug classifications',
            'view dosage forms',
            'create dosage forms',
            'edit dosage forms',
            'delete dosage forms',
            
            // Promos & Discounts — FULL ACCESS
            'view promos',
            'manage promos',
            'view discounts',
            'manage discounts',
            
            // Prescriptions
            'view prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'delete prescriptions',
            
            // User Management — VIEW ONLY
            'view users',
            'view roles',
            'view permissions',
        ]);

        // ============================================================
        // ✅ PHARMACIST — Full access sa prescriptions & products
        // ============================================================
        $pharmacistRole = Role::findByName('Pharmacist');
        $pharmacistRole->syncPermissions([
            // Dashboard
            'view dashboard',
            'view sales metrics',
            'view inventory metrics',
            
            // Inventory
            'view inventory',
            'create inventory',
            'edit inventory',
            'update stock',
            'view inventory reports',
            
            // POS
            'view pos',
            'process payment',
            'print receipts',
            'view receipts',
            
            // Products — FULL ACCESS
            'view products',
            'create product',
            'edit product',
            'delete product',
            
            // Categories
            'view categories',
            'manage categories',
            
            // Medicine Classification — FULL ACCESS
            'view drug classifications',
            'create drug classifications',
            'edit drug classifications',
            'delete drug classifications',
            'view dosage forms',
            'create dosage forms',
            'edit dosage forms',
            'delete dosage forms',
            
            // Promos & Discounts — FULL ACCESS
            'view promos',
            'manage promos',
            'view discounts',
            'manage discounts',
            
            // Sales Reports
            'view sales reports',
            'export reports',
            
            // Prescriptions — FULL ACCESS
            'view prescriptions',
            'create prescriptions',
            'edit prescriptions',
            'delete prescriptions',
        ]);

        // ============================================================
        // CREATE DEFAULT USERS
        // ============================================================

        // ✅ Admin user
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

        // ✅ Cashier user
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

        // ✅ Pharmacy Assistant user
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

        // ✅ Pharmacist user
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

        $this->command->info('✅ Roles, permissions, and users seeded successfully!');
        $this->command->info('📊 Summary:');
        $this->command->info('   - Admin: ' . $adminRole->permissions->count() . ' permissions');
        $this->command->info('   - Cashier: ' . $cashierRole->permissions->count() . ' permissions');
        $this->command->info('   - Pharmacy Assistant: ' . $pharmacyRole->permissions->count() . ' permissions');
        $this->command->info('   - Pharmacist: ' . $pharmacistRole->permissions->count() . ' permissions');
    }
}