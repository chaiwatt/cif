<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScheduleTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schedule_types')->insert([
            [
            'name' =>'ตารางทำงานกะเต็มวัน'
            ],
            [
            'name' =>'ตารางทำงานกะเวียน'
            ]
        ]);
    }
}
