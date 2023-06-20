<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EthnicitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('ethnicities')->insert([
            [
            'name' =>'ไทย'
            ],
            [
            'name' =>'เมียนมา'
            ],
            [
            'name' =>'กัมพูชา'
            ],
            [
            'name' =>'ลาว'
            ],
            [
            'name' =>'ฟิลลิปปินส์'
            ]
        ]);
    }
}
