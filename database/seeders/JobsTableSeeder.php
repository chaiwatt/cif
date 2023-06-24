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
            'route' => 'jobs.shift.timeattendance',
            'view' => 'jobs.shift.timeattendance.index',
        ]);
        Job::create([
            'code' => 'YEARLY-HOLIDAY',
            'name' => 'วันหยุดประจำปี',
            'route' => 'jobs.shift.yearlyholiday',
            'view' => 'jobs.shift.yearlyholiday.index',
        ]);
        Job::create([
            'code' => 'WORK-SCHEDULE',
            'name' => 'ตารางทำงาน',
            'route' => 'jobs.schedule-work.schedule',
            'view' => 'jobs.schedule-work.schedule.index',
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
