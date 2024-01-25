<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShiftColorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shift_colors')->insert([
            [
            'regular' =>'#47CA88',
            'holiday' =>'#FD6F8E',
            'public_holiday' =>'#7C7AD6',
            ],
            [
            'regular' =>'#47CA88',
            'holiday' =>'#FD6F8E',
            'public_holiday' =>'#7C7AD6',
            ],
        ]);
    }
}
