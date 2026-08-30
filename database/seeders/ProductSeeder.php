<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Neosep',
            'brand' => 'Generic',
            'dosage' => '500mg',
            'type' => 'Generic',
            'category' => 'Antibiotic',
            'price' => 50.00,
            'quantity' => 20,
            'expiry_date' => '2025-12-31'
        ]);

        Product::create([
            'name' => 'Mefenamic',
            'brand' => 'Branded',
            'dosage' => '250mg',
            'type' => 'Branded',
            'category' => 'Painkiller',
            'price' => 30.00,
            'quantity' => 15,
            'expiry_date' => '2026-03-30'
        ]);
    }
}
