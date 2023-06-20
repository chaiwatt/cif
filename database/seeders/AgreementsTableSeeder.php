<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgreementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
        DB::table('agreements')->insert([
            [
                'name' => 'ค่าล่วงเวลา 1 เท่า',
                'type' => 0,
                'shift_agreemt_unit_id' => 2,
            ],
            [
                'name' => 'ค่าล่วงเวลา 1.5 เท่า',
                'type' => 0,
                'shift_agreemt_unit_id' => 2,
            ],
            [
                'name' => 'ค่าล่วงเวลา 2 เท่า',
                'type' => 0,
                'shift_agreemt_unit_id' => 2,
            ],
            [
                'name' => 'ค่าล่วงเวลา 3 เท่า',
                'type' => 0,
                'shift_agreemt_unit_id' => 2,
            ],
            [
                'name' => 'ค่าล่วงเวลา',
                'type' => 0,
                'shift_agreemt_unit_id' => 3,
            ],
            [
                'name' => 'ค่ากะ',
                'type' => 0,
                'shift_agreemt_unit_id' => 3,
            ],
            [
                'name' => 'ค่าอาหาร',
                'type' => 0,
                'shift_agreemt_unit_id' => 3,
            ],
            [
                'name' => 'ค่าอาหารโอที',
                'type' => 0,
                'shift_agreemt_unit_id' => 3,
            ],
            [
                'name' => 'เบี้ยขยัน',
                'type' => 0,
                'shift_agreemt_unit_id' => 3,
            ],
            [
                'name' => 'ค่าเดินทาง',
                'type' => 0,
                'shift_agreemt_unit_id' => 3,
            ],
            [
                'name' => 'หักขาดงาน',
                'type' => 1,
                'shift_agreemt_unit_id' => 1,
            ],
            [
                'name' => 'หักมาสาย',
                'type' => 1,
                'shift_agreemt_unit_id' => 2,
            ],
            [
                'name' => 'หักกลับก่อนเวลา',
                'type' => 1,
                'shift_agreemt_unit_id' => 2,
            ],
            [
                'name' => 'หักไม่บันทึกเวลาเข้างาน',
                'type' => 1,
                'shift_agreemt_unit_id' => 3,
            ],
            [
                'name' => 'หักไม่บันทึกเวลาออกงาน',
                'type' => 1,
                'shift_agreemt_unit_id' => 3,
            ]
        ]);
    }
}
