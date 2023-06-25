<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\WorkSchedule;
use Illuminate\Database\Seeder;
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
        WorkSchedule::create([
                'name' => 'กะทำงานปกติ 08.00-17.00',
                'year' => $currentYear,
            ]);
        WorkSchedule::create([
                'name' => 'กะทำงานเช้า 07.00-16.00',
                'year' => $currentYear,
            ]);
        WorkSchedule::create([
                'name' => 'กะทำงานดึก 20.00-05.00',
                'year' => $currentYear,
            ]);    

        $workSchedule = WorkSchedule::findOrFail(1); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::findOrFail(2); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);

        $workSchedule = WorkSchedule::findOrFail(3); 
        $addDefaultWorkScheduleAssignment = new AddDefaultWorkScheduleAssignment();
        $addDefaultWorkScheduleAssignment->addDefaultWorkScheduleAssignment($workSchedule,$currentYear);
    }
}
