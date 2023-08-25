<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AssessableTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('assessable_types')->insert([
            [
                'name' => 'เงินได้'
            ],
            [
                'name' => 'เงินหัก'
            ]
        ]);
    }
}
