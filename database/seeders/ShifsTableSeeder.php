<?php

namespace Database\Seeders;

use App\Models\Shift;
use App\Models\ShiftColor;
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
                'duration' => 8,
                'record_start' => '07:50:00',
                'record_end' => '17:10:00',
                'break_start' => '12:00:00',
                'break_end' => '13:00:00',
                'shift_type_id' => 1
            ],
            [
                'name' => 'ทำงานกะ 05.00-14.00',
                'code' => 'W2',
                'start' => '05:00:00',
                'end' => '14:00:00',
                'duration' => 8,
                'record_start' => '04:50:00',
                'record_end' => '14:10:00',
                'break_start' => '09:00:00',
                'break_end' => '10:00:00',
                'shift_type_id' => 1
            ],
            [
                'name' => 'ทำงานกะ 06.30-15.30',
                'code' => 'W3',
                'start' => '06:30:00',
                'end' => '15:30:00',
                'duration' => 8,
                'record_start' => '06:20:00',
                'record_end' => '15:40:00',
                'break_start' => '10:30:00',
                'break_end' => '11:30:00',
                'shift_type_id' => 1
            ],
            [
                'name' => 'ทำงานกะ 07.00-16.00',
                'code' => 'W4',
                'start' => '07:00:00',
                'end' => '16:00:00',
                'duration' => 8,
                'record_start' => '06:50:00',
                'record_end' => '16:10:00',
                'break_start' => '11:00:00',
                'break_end' => '12:00:00',
                'shift_type_id' => 1
            ],
            [
                'name' => 'ทำงานกะ 14.00-23.00',
                'code' => 'W5',
                'start' => '14:00:00',
                'end' => '23:00:00',
                'duration' => 8,
                'record_start' => '13:50:00',
                'record_end' => '23:10:00',
                'break_start' => '18:00:00',
                'break_end' => '19:00:00',
                'shift_type_id' => 1
            ],
            [
                'name' => 'ทำงานกะ 16.00-01.00',
                'code' => 'W6',
                'start' => '16:00:00',
                'end' => '01:00:00',
                'duration' => 8,
                'record_start' => '15:50:00',
                'record_end' => '01:10:00',
                'break_start' => '20:00:00',
                'break_end' => '21:00:00',
                'shift_type_id' => 2
            ],
            [
                'name' => 'ทำงานกะ 17.00-02.00',
                'code' => 'W7',
                'start' => '17:00:00',
                'end' => '02:00:00',
                'duration' => 8,
                'record_start' => '16:50:00',
                'record_end' => '02:10:00',
                'break_start' => '21:00:00',
                'break_end' => '22:00:00',
                'shift_type_id' => 2
            ],
            [
                'name' => 'ทำงานกะ 18.00-03.00',
                'code' => 'W8',
                'start' => '18:00:00',
                'end' => '03:00:00',
                'duration' => 8,
                'record_start' => '17:50:00',
                'record_end' => '03:10:00',
                'break_start' => '22:00:00',
                'break_end' => '23:00:00',
                'shift_type_id' => 2
            ]
        ];

        // สร้างกะ
        foreach ($defaultShifts as $key => $shiftData) {
            $randomShiftColor = ShiftColor::find($key+1);
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
            $shift->color = $randomShiftColor->regular;
            $shift->common_code = $shiftData['code'];
            $shift->shift_type_id = $shiftData['shift_type_id'];
            // บันทึกกะทำงาน
            $shift->save();

            // สร้างค่าเริ่มต้นของโมเดลอื่น ๆ ที่สัมพันธ์กันกับโมเดล Shift โดยเรียกใช้คลาส AddDefaultShiftDependency
            $dependencyAdder = new AddDefaultShiftDependency();
            $dependencyAdder->addDependencies($shift,$randomShiftColor);
        }

    }
}
