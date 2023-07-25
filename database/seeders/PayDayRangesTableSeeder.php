<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PayDayRangesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pay_day_ranges')->insert([
            [
                'name' =>'รอบเงินเดือน 1 - 15',
                'employee_type_id' => 2,
                'start' => 1,
                'end' => 15,
                'payday' => 22
            ],
            [
                'name' =>'รอบเงินเดือน 16 - 31',
                'employee_type_id' => 2,
                'start' => 16,
                'end' => 31,
                'payday' => 7
            ],
            [
                'name' =>'รอบเงินเดือน 1 - 25',
                'employee_type_id' => 1,
                'start' => 1,
                'end' => 25,
                'payday' => 30
            ],
            [
                'name' =>'รอบเงินเดือน 26 - 25',
                'employee_type_id' => 1,
                'start' => 26,
                'end' => 25,
                'payday' => 30
            ],
            [
                'name' =>'รอบเงินเดือน 5 - 20 (ทดสอบ)',
                'employee_type_id' => 2,
                'start' => 5,
                'end' => 20,
                'payday' => 27
            ]
        ]);
    }
}
