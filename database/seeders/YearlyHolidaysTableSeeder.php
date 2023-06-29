<?php

namespace Database\Seeders;

use App\Models\YearlyHoliday;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class YearlyHolidaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        YearlyHoliday::create([
            'name' => 'วันปิยะมหาราช',
            'holiday_date' => '2023-07-28',
            'day' => 28,
            'month' =>7,
            'year' => 2023
        ]);
        YearlyHoliday::create([
            'name' => 'วันอาสาฬบูชา',
            'holiday_date' => '2023-08-01',
            'day' => 1,
            'month' =>8,
            'year' => 2023
        ]);
        YearlyHoliday::create([
            'name' => 'วันเข้าพรรษา',
            'holiday_date' => '2023-08-02',
            'day' => 2,
            'month' =>8,
            'year' => 2023
        ]);
        YearlyHoliday::create([
            'name' => 'วันหยุดชดเชยวันแม่แห่งชาติ',
            'holiday_date' => '2023-08-12',
            'day' => 12,
            'month' =>8,
            'year' => 2023
        ]);
    }
}
