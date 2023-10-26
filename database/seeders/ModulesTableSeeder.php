<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create([
            'prefix' => 'groups.time-recording-system.shift',
            'code' => 'SHIFT',
            'name' => 'กะการทำงาน',
            'icon' => 'fa-clock'
        ]);
        Module::create([
            'prefix' => 'groups.time-recording-system.schedulework',
            'code' => 'WORK-SCHEDULE',
            'name' => 'ตารางทำงาน',
            'icon' => 'fa-calendar-alt'
        ]);
        Module::create([
            'prefix' => 'groups.time-recording-system.setting',
            'code' => 'TIME-RECORDING-SETTING',
            'name' => 'การตั้งค่า',
            'icon' => 'fa-cog'
        ]);
        // Module::create([
        //     'code' => 'TIME-RECORDING-REPORT',
        //     'name' => 'รายงาน',
        //     'icon' => 'fa-chart-pie'
        // ]);
        Module::create([
            'prefix' => 'groups.salary-system.salary',
            'code' => 'SALARY',
            'name' => 'จัดการเงินเดือน',
            'icon' => 'fa-wallet'
        ]);
        Module::create([
            'prefix' => 'groups.salary-system.setting',
            'code' => 'SALARY-MODULE-SETTING',
            'name' => 'ตั้งค่า',
            'icon' => 'fa-cog'
        ]);
        Module::create([
            'prefix' => 'groups.document-system.leave',
            'code' => 'DOCUMENT-LEAVE',
            'name' => 'การลา',
            'icon' => 'fa-calendar-alt'
        ]);
        Module::create([
            'prefix' => 'groups.document-system.overtime',
            'code' => 'DOCUMENT-OVERTIME',
            'name' => 'ล่วงเวลา',
            'icon' => 'fa-clock'
        ]);
        Module::create([
            'prefix' => 'groups.document-system.setting',
            'code' => 'DOCUMENT-APPROVE-SETTING',
            'name' => 'ตั้งค่า',
            'icon' => 'fa-cog'
        ]);
        Module::create([
            'prefix' => 'groups.user-management-system.setting',
            'code' => 'USER-MANAGEMENT-MODULE-SETTING',
            'name' => 'ตั้งค่า',
            'icon' => 'fa-cog'
        ]);
        Module::create([
            'prefix' => 'groups.assessment-system.assessment',
            'code' => 'ASSESSMENT-MODULE',
            'name' => 'การประเมิน',
            'icon' => 'fa-medal'
        ]);
        Module::create([
            'prefix' => 'groups.assessment-system.setting',
            'code' => 'ASSESSMENT-MODULE-SETTING',
            'name' => 'ตั้งค่า',
            'icon' => 'fa-cog'
        ]);
        Module::create([
            'prefix' => 'groups.announcement-system.announcement',
            'code' => 'ANNOUNCEMENT-MODULE',
            'name' => 'ข่าวประกาศ',
            'icon' => 'fa-bullhorn'
        ]);
        Module::create([
            'prefix' => 'groups.job-application-system.job-application',
            'code' => 'JOB-APPLICATION-MODULE',
            'name' => 'ข่าวสมัครงาน',
            'icon' => 'fa-user-tie'
        ]);
        Module::create([
            'prefix' => 'groups.learning-system.learning',
            'code' => 'LEARNING',
            'name' => 'การเรียนรู้',
            'icon' => 'fa-user-graduate'
        ]);
        Module::create([
            'prefix' => 'groups.learning-system.setting',
            'code' => 'LEARNING-SETTING',
            'name' => 'ตั้งค่า',
            'icon' => 'fa-cog'
        ]);
        Module::create([
            'prefix' => 'groups.dashboard.report',
            'code' => 'DASHBOARD-REPORT',
            'name' => 'รายงาน',
            'icon' => 'fa-chart-pie'
        ]);
    }
}
