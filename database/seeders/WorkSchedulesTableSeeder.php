<?php

namespace Database\Seeders;

use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class WorkSchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $this->createExampleSchedule();
    }
    public function createExampleSchedule()
    {
        // กำหนดอาร์เรย์ของช่วงเวลาเริ่มต้นประจำวัน
        $workSchedules = [
            [
                'name' => 'ตารางทำงาน 08.00-17.00 กลางวันตลอด'
            ],
            [
                'name' => 'ตารางทำงาน 07.00-16.00 กะเช้า'
            ]
        ];

        // สร้างตารางการทำงาน
        foreach ($workSchedules as $workScheduleData) {
            // สร้างอินสแตนซ์ของคลาส Shift ใหม่
            $workSchedule = new WorkSchedule();
            // กำหนดค่าเริ่มต้นของตารางทำงานจากข้อมูลในอาร์เรย์
            $workSchedule->name = $workScheduleData['name'];
            // บันทึกตารางทำงาน
            $workSchedule->save();
        }
    }
}
