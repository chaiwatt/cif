<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class IncomeDeductsTableSeeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('income_deducts')->insert([
            [
            'name' =>'ค่าล่วงเวลาx1',
            'assessable_type_id' => 1,
            'unit_id' => 2
            ],
            [
            'name' =>'ค่าล่วงเวลาx1.5',
            'assessable_type_id' => 1,
            'unit_id' => 2
            ],
            [
            'name' =>'ค่าล่วงเวลาx2',
            'assessable_type_id' => 1,
            'unit_id' => 2
            ],
            [
            'name' =>'ค่าล่วงเวลาx3',
            'assessable_type_id' => 1,
            'unit_id' => 2
            ],
            [
            'name' =>'ค่ากะ',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าทักษะ',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าตำแหน่ง',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าครองชีพ',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าเบี้ยประชุม',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าเช่าบ้าน',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าอาหาร',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่ารักษาพยาบาล',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าน้ำ / ไฟ /โทรศัพท์',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'เบี้ยขยัน',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'เบี้ยขยันประจำวัน',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'เบี้ยขยันประจำเดือน',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าเหมา',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'วันหยุดประเพณี',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'เงินได้จากหน้าที่',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าน้ำมันรถ',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าจ้างตามผลงาน',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'เงินได้ค้างรับ',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'เงินได้อื่นๆ / โบนัส',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าเบี้ยเลี้ยง',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ค่าพาหนะ',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'เงินเยียวยา',
            'assessable_type_id' => 1,
            'unit_id' => 1
            ],
            [
            'name' =>'ลาพักร้อน',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'ลาคลอด',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'ลาบวช',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'ลาป่วยมีใบรับรองแพทย์',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'ลาป่วยไม่มีใบรับรองแพทย์',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักขาดงาน',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักมาสาย',
            'assessable_type_id' => 2,
            'unit_id' => 2
            ],
            [
            'name' =>'หักกลับก่อนเวลา',
            'assessable_type_id' => 2,
            'unit_id' => 2
            ],
            [
            'name' =>'ลาคลอด (หักเงิน)',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักค่าเช่าบ้าน',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักค่าน้ำ / ค่าไฟ / ค่าโทรศัพท',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักค่าเครื่องแบบ',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักค่าของเสียหาย',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักอื่นๆ',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักเงินกู้ กยศ',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ],
            [
            'name' =>'หักส่งกองบังคับคดี',
            'assessable_type_id' => 2,
            'unit_id' => 1
            ]
        ]);
    }
}
