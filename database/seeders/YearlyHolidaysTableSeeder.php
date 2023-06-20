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
            'holiday_date' => '2023-07-28'
        ]);
        YearlyHoliday::create([
            'name' => 'วันอาสาฬบูชา',
            'holiday_date' => '2023-08-01'
        ]);
        YearlyHoliday::create([
            'name' => 'วันเข้าพรรษา',
            'holiday_date' => '2023-08-02'
        ]);
        YearlyHoliday::create([
            'name' => 'วันหยุดชดเชยวันแม่แห่งชาติ',
            'holiday_date' => '2023-08-12'
        ]);
    }
}
