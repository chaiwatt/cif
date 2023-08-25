<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PaydaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('paydays')->insert([
            [
            'name' =>'รอบเงินเดือน รายเดือน 26 - 25',
            'year' => 2023
            ],
            [
            'name' =>'รอบเงินเดือน รายเดือน 1 - 25',
            'year' => 2023
            ],
            [
            'name' =>'รอบเงินเดือน รายวัน 1 - 15',
            'year' => 2023
            ],
            [
            'name' =>'รอบเงินเดือน รายวัน 16 - 31',
            'year' => 2023
            ]
        ]);
    }
}
