<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SkillBasedCostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('skill_based_costs')->insert([
            [
            'name' =>'ทักษะ20',
            'cost' => 20
            ],
            [
            'name' =>'ทักษะ40',
            'cost' => 40
            ],
            [
            'name' =>'ทักษะ50',
            'cost' => 50
            ],
            [
            'name' =>'ทักษะ60',
            'cost' => 60
            ]
        ]);
    }
}
