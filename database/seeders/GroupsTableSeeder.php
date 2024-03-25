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
            'icon' => '<span class="material-symbols-outlined" style="color: #175CD3; font-size: 36px;">schedule</span>',
            'dashboard' => 'groups.dashboard.time-recording-system',
            'default_route' => 'groups.time-recording-system.schedulework.time-recording'
        ]);
        Group::create([
            'code' => 'DOCUMENT',
            'name' => 'ระบบเอกสาร',
            'description' => 'รายละเอียดระบบเอกสาร',
            'icon' => '<span class="material-symbols-outlined" style="color: #41B87C; font-size: 36px;">folder_open</span>',
            'dashboard' => 'groups.dashboard.document-system',
            'default_route' => 'groups.document-system.setting.approve-document'
        ]);
        Group::create([
            'code' => 'SALARY-MANAGEMENT',
            'name' => 'ระบบเงินเดือน',
            'description' => 'รายละเอียดระบบเงินเดือน',
            'icon' => '<span class="material-symbols-outlined" style="color: #7C7AD6; font-size: 36px;">request_page</span>',
            'dashboard' => 'groups.dashboard.salary-system',
            'default_route' => 'groups.salary-system.salary.calculation-list'
        ]);
        Group::create([
            'code' => 'USER-MANAGEMENT',
            'name' => 'ระบบจัดการพนักงาน',
            'description' => 'รายละเอียดระบบจัดการพนักงาน',
            'icon' => '<span class="material-symbols-outlined" style="color: #9695DE; font-size: 36px;">person</span>',
            'dashboard' => 'groups.dashboard.user-management-system',
            'default_route' => 'groups.user-management-system.setting.userinfo'
        ]);
        Group::create([
            'code' => 'LEARNING',
            'name' => 'ระบบจัดการเรียนรู้',
            'description' => 'รายละเอียดระบบจัดการเรียนรู้',
            'icon' => '<span class="material-symbols-outlined" style="color: #FB6514; font-size: 36px;">menu_book</span>',
            'dashboard' => 'groups.dashboard.learning-system',
            'default_route' => 'groups.learning-system.learning.learning-list'
        ]);
        Group::create([
            'code' => 'ASSESSMENT',
            'name' => 'ระบบประเมินพนักงาน',
            'description' => 'รายละเอียดระบบประเมินพนักงาน',
            'icon' => '<span class="material-symbols-outlined" style="color: #EE46BC; font-size: 36px;">assignment_turned_in</span>',
            'dashboard' => 'groups.dashboard.assessment-system',
            'default_route' => 'groups.assessment-system.assessment.assessment'
        ]);
        Group::create([
            'code' => 'ANNOUNCEMENT',
            'name' => 'ระบบข่าวประกาศ',
            'description' => 'รายละเอียดระบบข่าวประกาศ',
            'icon' => '<span class="material-symbols-outlined" style="color: #FE872B; font-size: 36px;">campaign</span>',
            'dashboard' => 'groups.dashboard.announcement-system',
            'default_route' => 'groups.announcement-system.announcement.list'
        ]);
        Group::create([
            'code' => 'JOB-APPLICATION',
            'name' => 'ระบบสมัครงาน',
            'description' => 'รายละเอียดระบบสมัครงาน',
            'icon' => '<span class="material-symbols-outlined" style="color: #ADD258; font-size: 36px;">group</span>',
            'dashboard' => 'groups.dashboard.job-application-system',
            'default_route' => 'groups.job-application-system.job-application.list'
        ]);
        Group::create([
            'code' => 'EMPLOYEE',
            'name' => 'ระบบพนักงาน',
            'description' => 'รายละเอียดระบบพนักงาน',
            'icon' => '<span class="material-symbols-outlined" style="color: #9695DE; font-size: 36px;">person</span>',
            'dashboard' => 'groups.dashboard.employee-system',
            'default_route' => 'groups.employee-system.employee.info'
        ]);
        Group::create([
            'code' => 'REPORT',
            'name' => 'ระบบรายงานผู้บริหาร',
            'description' => 'รายละเอียดระบบรายงานผู้บริหาร',
            'icon' => '<span class="material-symbols-outlined" style="color: #DDB761; font-size: 36px;">finance_mode</span>',
            'dashboard' => 'groups.dashboard.report-system',
            'default_route' => 'groups.report-system.report.salary'
        ]);
        Group::create([
            'code' => 'REPORT-SYSTEM',
            'name' => 'ระบบรายงานทั่วไป',
            'description' => 'รายละเอียดระบบรายงานพนักงาน',
            'icon' => '<span class="material-symbols-outlined" style="color: #3500E6; font-size: 36px;">lab_profile</span>',
            'dashboard' => 'groups.dashboard.report-system',
            'default_route' => 'report.index'
        ]);
    }
}
