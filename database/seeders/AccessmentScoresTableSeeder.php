<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AccessmentScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('accessment_scores')->insert([
            [
                'score' => 1
            ],
            [
                'score' => 2
            ],
            [
                'score' => 3
            ],
            [
                'score' => 4
            ],
            [
                'score' => 5
            ]
        ]);
    }
}
