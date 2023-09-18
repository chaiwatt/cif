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
            'name' =>'ลากิจ',
            'diligence_allowance_deduct' => 1
            ],
            [
            'name' =>'ลากิจพิเศษ',
            'diligence_allowance_deduct' => 0
            ],
            [
            'name' =>'ลาป่วยมีใบรับรองแพทย์',
            'diligence_allowance_deduct' => 1
            ],
            [
            'name' =>'ลาป่วยไม่มีใบรับรองแพทย์',
            'diligence_allowance_deduct' => 1
            ],
            [
            'name' =>'ลาพักร้อน',
            'diligence_allowance_deduct' => 0
            ],
            [
            'name' =>'ลาคลอด',
            'diligence_allowance_deduct' => 1
            ],
            [
            'name' =>'ลาบวช',
            'diligence_allowance_deduct' => 1
            ]
        ]);
    }
}
