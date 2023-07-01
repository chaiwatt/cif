<?php

namespace Database\Seeders;

use App\Models\Job;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::create([
            'code' => 'SHIFT-MANAGEMENT',
            'name' => 'กะการทำงาน',
            'route' => 'groups.time-recording-system.shift.timeattendance',    
            'view' => 'groups.time-recording-system.shift.timeattendance.index',
        ]);
        Job::create([
            'code' => 'YEARLY-HOLIDAY',
            'name' => 'วันหยุดประจำปี',
            'route' => 'groups.time-recording-system.shift.yearlyholiday',
            'view' => 'groups.time-recording-system.shift.yearlyholiday.index',
        ]);
        Job::create([
            'code' => 'WORK-SCHEDULE',
            'name' => 'ตารางทำงาน',
            'route' => 'groups.time-recording-system.schedulework.schedule',  
            'view' => 'groups.time-recording-system.schedulework.schedule.index',
        ]);
        Job::create([
            'code' => 'EXTRA-EARN-AGREEMENT',
            'name' => 'ข้อตกลงเงินเพิ่ม',
            'route' => Null,
            'view' => Null
        ]);
        Job::create([
            'code' => 'DEDUCTION-AGREEMENT',
            'name' => 'ข้อตกลงเงินหัก',
            'route' => Null,
            'view' => Null
        ]);
        Job::create([
            'code' => 'SARALY-JOB-ONE',
            'name' => 'Jobระบบเงินเดือน1',
            'route' => Null,
            'view' => Null
        ]);
        Job::create([
            'code' => 'SARALY-JOB-TWO',
            'name' => 'Jobระบบเงินเดือน2',
            'route' => Null,
            'view' => Null
        ]);
        Job::create([
            'code' => 'SARALY-JOB-THREE',
            'name' => 'Jobระบบเงินเดือน3',
            'route' => Null,
            'view' => Null
        ]);
        Job::create([
            'code' => 'SARALY-JOB-FOUR',
            'name' => 'Jobระบบเงินเดือน4',
            'route' => Null,
            'view' => Null
        ]);
    }
}
