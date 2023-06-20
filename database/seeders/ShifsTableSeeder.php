<?php

namespace Database\Seeders;

use App\Models\Shift;
use Illuminate\Database\Seeder;
use App\Helpers\AddDefaultShiftDependency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ShifsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDefaultShifts();
    }
    public function createDefaultShifts()
    {
        // กำหนดอาร์เรย์ของช่วงเวลาเริ่มต้นประจำวัน
        $defaultShifts = [
            [
                'name' => 'ทำงานปกติ 08.00-17.00',
                'code' => 'W1',
                'start' => '08:00:00',
                'end' => '17:00:00',
                'record_start' => '05:00:00',
                'record_end' => '15:00:00',
                'break_start' => '12:00:00',
                'break_end' => '13:00:00',
            ],
            [
                'name' => 'ทำงานปกติ 07.00-16.00',
                'code' => 'W2',
                'start' => '07:00:00',
                'end' => '16:00:00',
                'record_start' => '05:00:00',
                'record_end' => '14:00:00',
                'break_start' => '11:30:00',
                'break_end' => '12:30:00',
            ]
        ];

        // สร้างกะ
        foreach ($defaultShifts as $shiftData) {
            // สร้างอินสแตนซ์ของคลาส Shift ใหม่
            $shift = new Shift();

            // กำหนดค่าเริ่มต้นของกะจากข้อมูลในอาร์เรย์
            $shift->name = $shiftData['name'];
            $shift->code = $shiftData['code'];
            $shift->start = $shiftData['start'];
            $shift->end = $shiftData['end'];
            $shift->record_start = $shiftData['record_start'];
            $shift->record_end = $shiftData['record_end'];
            $shift->break_start = $shiftData['break_start'];
            $shift->break_end = $shiftData['break_end'];
            $shift->base_shift = 1;
            $shift->common_code = $shiftData['code'];
            // บันทึกกะทำงาน
            $shift->save();

            // สร้างค่าเริ่มต้นของโมเดลอื่น ๆ ที่สัมพันธ์กันกับโมเดล Shift โดยเรียกใช้คลาส AddDefaultShiftDependency
            $dependencyAdder = new AddDefaultShiftDependency();
            $dependencyAdder->addDependencies($shift);
        }

    }
}
