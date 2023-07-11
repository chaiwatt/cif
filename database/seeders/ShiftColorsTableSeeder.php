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
            'regular' =>'#fe4a49',
            'holiday' =>'#011f4b',
            'public_holiday' =>'#2ab7ca',
            ],
            [
            'regular' =>'#011f4b',
            'holiday' =>'#851e3e',
            'public_holiday' =>'#009688',
            ],
            [
            'regular' =>'#49657b',
            'holiday' =>'#ff3377',
            'public_holiday' =>'#3b7dd8',
            ],
            [
            'regular' =>'#d11141',
            'holiday' =>'#29a8ab',
            'public_holiday' =>'#343d46',
            ],
            [
            'regular' =>'#00b159',
            'holiday' =>'#edc951',
            'public_holiday' =>'#3d1e6d',
            ],
            [
            'regular' =>'#00aedb',
            'holiday' =>'#eb6841',
            'public_holiday' =>'#3d2352',
            ],
            [
            'regular' =>'#ff3377',
            'holiday' =>'#cc2a36',
            'public_holiday' =>'#2e003e',
            ],
            [
            'regular' =>'#ffc425',
            'holiday' =>'#4f372d',
            'public_holiday' =>'#00a0b0',
            ],
            [
            'regular' =>'#58668b',
            'holiday' =>'#00a0b0',
            'public_holiday' =>'#ffc425',
            ],
            [
            'regular' =>'#edc951',
            'holiday' =>'#cc2a36',
            'public_holiday' =>'#00a0b0',
            ],
            [
            'regular' =>'#f37735',
            'holiday' =>'#3d1e6d',
            'public_holiday' =>'#ff5588',
            ],
            [
            'regular' =>'#536878',
            'holiday' =>'#008744',
            'public_holiday' =>'#3b7dd8',
            ],
            [
            'regular' =>'#ff6f69',
            'holiday' =>'#36454f',
            'public_holiday' =>'#be9b7b',
            ],
            [
            'regular' =>'#7bc043',
            'holiday' =>'#4b3832',
            'public_holiday' =>'#0057e7',
            ],
            [
            'regular' =>'#283655',
            'holiday' =>'#0392cf',
            'public_holiday' =>'#ffcc5c',
            ],
            [
            'regular' =>'#be9b7b',
            'holiday' =>'#008744',
            'public_holiday' =>'#0057e7',
            ],
            [
            'regular' =>'#d62d20',
            'holiday' =>'#ffa700',
            'public_holiday' =>'#3385c6',
            ],
            [
            'regular' =>'#f37735',
            'holiday' =>'#5e5656',
            'public_holiday' =>'#ff5588',
            ],
            [
            'regular' =>'#3385c6',
            'holiday' =>'#854442',
            'public_holiday' =>'#ff3377',
            ],
            [
            'regular' =>'#3d1e6d',
            'holiday' =>'#343d46',
            'public_holiday' =>'#00a0b0',
            ],
        ]);
    }
}
