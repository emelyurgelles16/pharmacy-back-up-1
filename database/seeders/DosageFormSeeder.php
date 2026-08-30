<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DosageForm;
use Illuminate\Support\Str;

class DosageFormSeeder extends Seeder
{
    public function run()
    {
        $forms = [
            ['name' => 'Tablet', 'abbreviation' => 'Tab', 'description' => 'Solid dosage form'],
            ['name' => 'Capsule', 'abbreviation' => 'Cap', 'description' => 'Gelatin shell containing medication'],
            ['name' => 'Syrup', 'abbreviation' => 'Syr', 'description' => 'Liquid oral medication'],
            ['name' => 'Drops', 'abbreviation' => 'Drp', 'description' => 'Liquid drops for oral or topical use'],
            ['name' => 'Ointment', 'abbreviation' => 'Oint', 'description' => 'Topical semi-solid preparation'],
            ['name' => 'Injection', 'abbreviation' => 'Inj', 'description' => 'Sterile solution for injection'],
            ['name' => 'Cream', 'abbreviation' => 'Crm', 'description' => 'Topical emulsion'],
            ['name' => 'Sachet', 'abbreviation' => 'Sach', 'description' => 'Powder in a sachet'],
            ['name' => 'Powder', 'abbreviation' => 'Pwdr', 'description' => 'Dry powder form'],
            ['name' => 'Solution', 'abbreviation' => 'Sol', 'description' => 'Clear liquid solution'],
            ['name' => 'Suspension', 'abbreviation' => 'Susp', 'description' => 'Liquid with suspended particles'],
            ['name' => 'Emulsion', 'abbreviation' => 'Emul', 'description' => 'Liquid emulsion'],
        ];

        foreach ($forms as $form) {
            DosageForm::create([
                'name' => $form['name'],
                'slug' => Str::slug($form['name']),
                'abbreviation' => $form['abbreviation'],
                'description' => $form['description'],
                'is_active' => true,
            ]);
        }
    }
}