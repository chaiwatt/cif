<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssessmentScoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assessment_scores')->insert([
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
