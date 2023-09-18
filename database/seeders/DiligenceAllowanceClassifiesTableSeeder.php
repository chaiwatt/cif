<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiligenceAllowanceClassifiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('diligence_allowance_classifies')->insert([
            [
                'diligence_allowance_id' => 1,
                'level' => 1,
                'cost' => 0,
            ],
            [
                'diligence_allowance_id' => 1,
                'level' => 2,
                'cost' => 150,
            ],
            [
                'diligence_allowance_id' => 1,
                'level' => 3,
                'cost' => 200,
            ],
            [
                'diligence_allowance_id' => 1,
                'level' => 4,
                'cost' => 250,
            ],
            [
                'diligence_allowance_id' => 1,
                'level' => 5,
                'cost' => 300,
            ],
            [
                'diligence_allowance_id' => 2,
                'level' => 1,
                'cost' => 0,
            ],
            [
                'diligence_allowance_id' => 2,
                'level' => 2,
                'cost' => 300,
            ],
            [
                'diligence_allowance_id' => 2,
                'level' => 3,
                'cost' => 500,
            ],
            [
                'diligence_allowance_id' => 2,
                'level' => 4,
                'cost' => 600,
            ],
            [
                'diligence_allowance_id' => 2,
                'level' => 5,
                'cost' => 700,
            ],
        ]);
    }
}
