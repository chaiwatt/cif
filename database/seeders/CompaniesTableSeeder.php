<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('companies')->insert([
            [
                'name' => 'ฉวีวรรณอินเตอร์เนชั่นแนลฟู๊ดส์ จำกัด',
                'address' => '83/5 หมู่10 ตำบลหนองขาม อำเภอศรีราชา จังหวัดชลบุรี 20230',
                'phone' => '038 111 630',
                'tax' => '0205538000999'
            ]
        ]);
    }
}
