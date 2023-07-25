<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;
use App\Models\WorkScheduleShift;
use App\Helpers\AddDefaultWorkScheduleAssignment;

class WorkSchedulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $currentYear = Carbon::now()->year;
        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน DDDDD 07.00-16.00',
            'year' => $currentYear,
            'description' => 'เดย์ตลอด',
            'schedule_type_id' => 1
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(1); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน DDNND (07.00-16.00 เวียน 16.00-01.00)',
            'year' => $currentYear,
            'description' => 'เดย์ เดย์ ไนท์ ไนท์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 16,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 17,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 18,
        ]);
        $workSchedule = WorkSchedule::findOrFail(2); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NNDDN (16.00-01.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ ไนท์ เดย์ เดย์ ไนท์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 16,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 17,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 18,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(3); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);


        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน DDNND (08.00-17.00 เวียน 17.00-02.00)',
            'year' => $currentYear,
            'description' => 'เดย์ เดย์ ไนท์ ไนท์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 1,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 2,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 3,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 19,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 20,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 21,
        ]);

        $workSchedule = WorkSchedule::findOrFail(4); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NNDDN (17.00-02.00 เวียน 08.00-17.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ ไนท์ เดย์ เดย์ ไนท์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 19,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 20,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 21,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 1,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 2,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 3,
        ]);

        $workSchedule = WorkSchedule::findOrFail(5); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);
        
        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน DNNND (07.00-16.00 เวียน 18.00-03.00)',
            'year' => $currentYear,
            'description' => 'เดย์ ไนท์ ไนท์ ไนท์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);

        $workSchedule = WorkSchedule::findOrFail(6); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NNNDN (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ ไนท์ ไนท์ เดย์ ไนท์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(7); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NDDNN (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ เดย์ เดย์ ไนท์ ไนท์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(8); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);
                
        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NDNNN (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ เดย์ ไนท์ ไนท์ ไนท์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(9); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NNNDD (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ ไนท์ ไนท์ เดย์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(10); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NNDNN (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ ไนท์ เดย์ ไนท์ ไนท์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(11); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน DDDNN (07.00-16.00 เวียน 18.00-03.00)',
            'year' => $currentYear,
            'description' => 'เดย์ เดย์ เดย์ ไนท์ ไนท์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);

        $workSchedule = WorkSchedule::findOrFail(12); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NDNND (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ เดย์ ไนท์ ไนท์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(13); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);    

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน DNNDD (07.00-16.00 เวียน 18.00-03.00)',
            'year' => $currentYear,
            'description' => 'เดย์ ไนท์ ไนท์ เดย์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);

        $workSchedule = WorkSchedule::findOrFail(14); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);    

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NNDDD (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ ไนท์ เดย์ เดย์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(15); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);  
        
        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NDDDN (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ เดย์ เดย์ เดย์ ไนท์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(16); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear); 

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NDDDD (07.00-16.00 เวียน 18.00-03.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ เดย์ เดย์ เดย์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(17); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear); 

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน NNNND (18.00-03.00 เวียน 07.00-16.00)',
            'year' => $currentYear,
            'description' => 'ไนท์ ไนท์ ไนท์ ไนท์ เดย์',
            'schedule_type_id' => 2
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 22,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 23,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 24,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(18); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear); 

        $workSchedule = WorkSchedule::create([
            'name' => 'รายวัน DDDDD 06.30-15.30 + 07.00-16.00',
            'year' => $currentYear,
            'description' => 'เดย์ตลอดสลับเวลา',
            'schedule_type_id' => 1
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 7,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 8,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 9,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 10,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 11,
        ]);
        WorkScheduleShift::create([
            'work_schedule_id' => $workSchedule->id,
            'shift_id' => 12,
        ]);

        $workSchedule = WorkSchedule::findOrFail(19); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear); 

    }
}
