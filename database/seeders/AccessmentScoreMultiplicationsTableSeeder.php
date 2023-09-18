<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccessmentScoreMultiplicationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accessment_score_multiplications')->insert([
            [
                'multiplication' => 2
            ],
            [
                'multiplication' => 3
            ],
            [
                'multiplication' => 4
            ],
            [
                'multiplication' => 5
            ]
        ]);
    }
}
