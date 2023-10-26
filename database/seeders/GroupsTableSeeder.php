<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Group::create([
            'code' => 'TIME-RECORD',
            'name' => 'ระบบบันทึกเวลา',
            'description' => 'รายละเอียดระบบบันทึกเวลา',
            'icon' => 'fa-clock',
            'dashboard' => 'groups.dashboard.time-recording-system',
            'default_route' => 'groups.time-recording-system.schedulework.time-recording'
        ]);
        Group::create([
            'code' => 'DOCUMENT',
            'name' => 'ระบบเอกสาร',
            'description' => 'รายละเอียดระบบเอกสาร',
            'icon' => 'fa-book',
            'dashboard' => 'groups.dashboard.document-system',
            'default_route' => 'groups.document-system.setting.approve-document'
        ]);
        Group::create([
            'code' => 'SALARY-MANAGEMENT',
            'name' => 'ระบบเงินเดือน',
            'description' => 'รายละเอียดระบบเงินเดือน',
            'icon' => 'fa-wallet',
            'dashboard' => 'groups.dashboard.salary-system',
            'default_route' => 'groups.salary-system.salary.calculation-list'
        ]);
        Group::create([
            'code' => 'USER-MANAGEMENT',
            'name' => 'ระบบจัดการพนักงาน',
            'description' => 'รายละเอียดระบบจัดการพนักงาน',
            'icon' => 'fa-user',
            'dashboard' => 'groups.dashboard.user-management-system',
            'default_route' => 'groups.user-management-system.setting.userinfo'
        ]);
        Group::create([
            'code' => 'LEARNING',
            'name' => 'ระบบจัดการเรียนรู้',
            'description' => 'รายละเอียดระบบจัดการเรียนรู้',
            'icon' => 'fa-user-graduate',
            'dashboard' => 'groups.dashboard.learning-system',
            'default_route' => 'groups.learning-system.learning.learning-list'
        ]);
        Group::create([
            'code' => 'ASSESSMENT',
            'name' => 'ระบบประเมินพนักงาน',
            'description' => 'รายละเอียดระบบประเมินพนักงาน',
            'icon' => 'fa-medal',
            'dashboard' => 'groups.dashboard.assessment-system',
            'default_route' => 'groups.assessment-system.assessment.assessment'
        ]);
        Group::create([
            'code' => 'ANNOUNCEMENT',
            'name' => 'ระบบข่าวประกาศ',
            'description' => 'รายละเอียดระบบข่าวประกาศ',
            'icon' => 'fa-bullhorn',
            'dashboard' => 'groups.dashboard.announcement-system',
            'default_route' => 'groups.announcement-system.announcement.list'
        ]);
        Group::create([
            'code' => 'JOB-APPLICATION',
            'name' => 'ระบบสมัครงาน',
            'description' => 'รายละเอียดระบบสมัครงาน',
            'icon' => 'fa-user-tie',
            'dashboard' => 'groups.dashboard.job-application-system',
            'default_route' => 'groups.job-application-system.job-application.list'
        ]);
        Group::create([
            'code' => 'REPORT',
            'name' => 'ระบบรายงานผู้บริหาร',
            'description' => 'รายละเอียดระบบรายงานผู้บริหาร',
            'icon' => 'fa-chart-pie',
            'dashboard' => 'groups.dashboard.report-system',
            'default_route' => 'groups.report-system.report.salary'
        ]);
    }
}
