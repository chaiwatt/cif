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
            'name' => 'กะการทำงาน',
            'route' => 'jobs.shift.timeattendance',
            'view' => 'jobs.shift.timeattendance.index',
        ]);
        Job::create([
            'name' => 'วันหยุดประจำปี',
            'route' => 'jobs.shift.yearlyholiday',
            'view' => 'jobs.shift.yearlyholiday.index',
        ]);
        Job::create([
            'name' => 'ตารางทำงาน',
            'view' => Null
        ]);
        Job::create([
            'name' => 'มอบหมายตารางทำงาน',
            'view' => Null
        ]);
        Job::create([
            'name' => 'เพิ่มพนักงาน',
            'view' => Null
        ]);
        Job::create([
            'name' => 'ข้อตกลงเงินเพิ่ม',
        ]);
        Job::create([
            'name' => 'ข้อตกลงเงินหัก',
        ]);
        Job::create([
            'name' => 'Jobระบบเงินเดือน1',
            'view' => Null
        ]);
        Job::create([
            'name' => 'Jobระบบเงินเดือน2',
            'view' => Null
        ]);
        Job::create([
            'name' => 'Jobระบบเงินเดือน3',
            'view' => Null
        ]);
        Job::create([
            'name' => 'Jobระบบเงินเดือน4',
            'view' => Null
        ]);
    }
}
