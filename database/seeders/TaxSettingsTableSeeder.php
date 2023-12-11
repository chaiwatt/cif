<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TaxSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('tax_settings')->insert([
            [
            'social_contribution_salary' => 15000,
            'social_contribution_percent' => 5,
            'bonus_tax_percent' => 10
            ]
        ]);
    }
}
