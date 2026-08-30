<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['key' => 'pharmacy_name', 'value' => 'AER Pharmacy', 'group' => 'pharmacy', 'description' => 'Pharmacy Name'],
            ['key' => 'pharmacy_address', 'value' => 'Brgy: San Juan, Manila City', 'group' => 'pharmacy', 'description' => 'Pharmacy Address'],
            ['key' => 'pharmacy_contact', 'value' => '09123456789', 'group' => 'pharmacy', 'description' => 'Contact Number'],
            ['key' => 'pharmacy_email', 'value' => 'emelyurgelles16@gmail.com', 'group' => 'pharmacy', 'description' => 'Email Address'],
            ['key' => 'pharmacy_logo', 'value' => '', 'group' => 'pharmacy', 'description' => 'Pharmacy Logo'],
            ['key' => 'pharmacy_tin', 'value' => '123-456-789-000', 'group' => 'pharmacy', 'description' => 'TIN Number'],
            ['key' => 'backup_schedule', 'value' => 'weekly', 'group' => 'backup', 'description' => 'Backup Schedule'],
            ['key' => 'backup_retention', 'value' => '30', 'group' => 'backup', 'description' => 'Backup Retention Days'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}