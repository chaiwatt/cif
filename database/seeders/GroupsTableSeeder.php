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
            'dashboard' => 'groups.dashboard.time-recording-system'
        ]);
        Group::create([
            'code' => 'DOCUMENT',
            'name' => 'ระบบเอกสาร',
            'description' => 'รายละเอียดระบบเอกสาร',
            'icon' => 'fa-book',
            'dashboard' => 'groups.dashboard.document-system'
        ]);
        Group::create([
            'code' => 'SALARY-MANAGEMENT',
            'name' => 'ระบบเงินเดือน',
            'description' => 'รายละเอียดระบบเงินเดือน',
            'icon' => 'fa-wallet',
            'dashboard' => 'groups.dashboard.salary-system'
        ]);
        Group::create([
            'code' => 'USER-MANAGEMENT',
            'name' => 'ระบบจัดการพนักงาน',
            'description' => 'รายละเอียดระบบจัดการพนักงาน',
            'icon' => 'fa-user',
            'dashboard' => 'groups.dashboard.user-management-system'
        ]);
        Group::create([
            'code' => 'LEARNING',
            'name' => 'ระบบจัดการเรียนรู้',
            'description' => 'รายละเอียดระบบจัดการเรียนรู้',
            'icon' => 'fa-user-graduate',
            'dashboard' => 'groups.dashboard.learning-system'
        ]);
        Group::create([
            'code' => 'ASSESSMENT',
            'name' => 'ระบบประเมินพนักงาน',
            'description' => 'รายละเอียดระบบประเมินพนักงาน',
            'icon' => 'fa-medal',
            'dashboard' => 'groups.dashboard.assessment-system'
        ]);
        Group::create([
            'code' => 'ANNOUNCEMENT',
            'name' => 'ระบบข่าวประกาศ',
            'description' => 'รายละเอียดระบบข่าวประกาศ',
            'icon' => 'fa-bullhorn',
            'dashboard' => 'groups.dashboard.announcement-system'
        ]);
        Group::create([
            'code' => 'JOB-APPLICATION',
            'name' => 'ระบบสมัครงาน',
            'description' => 'รายละเอียดระบบสมัครงาน',
            'icon' => 'fa-user-tie',
            'dashboard' => 'groups.dashboard.job-application-system'
        ]);
    }
}
