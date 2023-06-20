<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EducationLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('education_levels')->insert([
            [
                'name' => 'ปริญญาตรี'
            ],
            [
                'name' => 'ปริญญาโท'
            ],
            [
                'name' => 'ปริญญาเอก'
            ],
            [
                'name' => 'ปวส.'
            ],
            [
                'name' => 'ปวช.'
            ],
            [
                'name' => 'อนุปริญญา'
            ],
            [
                'name' => 'ม.6'
            ],
            [
                'name' => 'ม.3'
            ],
            [
                'name' => 'ป.6'
            ]
        ]);
    }
}
