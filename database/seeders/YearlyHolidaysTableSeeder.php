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
            'name' => 'วันหยุดชดเชยวันแม่แห่งชาติ',
            'holiday_date' => '2023-08-12',
            'day' => 12,
            'month' =>8,
            'year' => 2023
        ]);
    }
}
