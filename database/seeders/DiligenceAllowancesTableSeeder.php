<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DiligenceAllowancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('diligence_allowances')->insert([
            [
                'name' => 'พนักงานรายวัน',
            ],
            [
                'name' => 'พนักงานรายเดือน',
            ]
        ]);
    }
}
