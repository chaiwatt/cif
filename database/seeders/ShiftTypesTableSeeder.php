<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShiftTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('shift_types')->insert([
            [
            'name' =>'กะภายในวัน'
            ],
            [
            'name' =>'กะข้ามวัน'
            ]
        ]);
    }
}
