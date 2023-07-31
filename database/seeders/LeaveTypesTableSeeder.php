<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('leave_types')->insert([
            [
            'name' =>'ลากิจ'
            ],
            [
            'name' =>'ลาป่วย'
            ],
            [
            'name' =>'ลาพักร้อน'
            ],
            [
            'name' =>'ลาคลอด'
            ],
            [
            'name' =>'ลาบวช'
            ]
        ]);
    }
}
