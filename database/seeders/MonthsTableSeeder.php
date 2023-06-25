<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MonthsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('months')->insert([
            [
            'name' =>'มกราคม'
            ],
            [
            'name' =>'กุมภาพันธ์'
            ],
            [
            'name' =>'มีนาคม'
            ],
            [
            'name' =>'เมษายน'
            ],
            [
            'name' =>'พฤษภาคม'
            ],
            [
            'name' =>'มิถุนายน'
            ],
            [
            'name' =>'กรกฎาคม'
            ],
            [
            'name' =>'สิงหาคม'
            ],
            [
            'name' =>'กันยายน'
            ],
            [
            'name' =>'ตุลาคม'
            ],
            [
            'name' =>'พฤศจิกายน'
            ],
            [
            'name' =>'ธันวาคม'
            ]
        ]);
    }
}
