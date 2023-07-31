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
            'code' => 'TIME-RECORDING',
            'name' => 'บันทึกเวลา',
            'route' => 'groups.time-recording-system.schedulework.time-recording',  
            'view' => 'groups.time-recording-system.schedulework.time-recording.index',
        ]);
        Job::create([
            'code' => 'TIME-RECORDING-CHECK',
            'name' => 'ตรวจสอบบันทึกเวลา',
            'route' => 'groups.time-recording-system.schedulework.time-recording-check',  
            'view' => 'groups.time-recording-system.schedulework.time-recording-check.index',
        ]);
        Job::create([
            'code' => 'EMPLOYEE-GROUP',
            'name' => 'กลุ่มพนักงาน',
            'route' => 'groups.time-recording-system.setting.employee-group',  
            'view' => 'groups.time-recording-system.setting.employee-group.index',
        ]);
        Job::create([
            'code' => 'WORK-SCHEDULR-VISIBILITY',
            'name' => 'การมองเห็น',
            'route' => 'groups.time-recording-system.setting.work-schedule-visibility',  
            'view' => 'groups.time-recording-system.setting.work-schedule-visibility.index',
        ]);
        Job::create([
            'code' => 'WORK-SCHEDULR-REPORT',
            'name' => 'รายงาน',
            'route' => 'groups.time-recording-system.report',  
            'view' => 'groups.time-recording-system.report.index',
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
            'code' => 'SARALY-PAYDAY',
            'name' => 'รอบคำนวนเงินเดือน',
            'route' => 'groups.salary-system.setting.payday',
            'view' => 'groups.salary-system.setting.payday.index'
        ]);
        Job::create([
            'code' => 'DOCUMENT-LEAVE',
            'name' => 'รายการลา',
            'route' => 'groups.document-system.leave.document',
            'view' => 'groups.document-system.leave.document.index'
        ]);
        Job::create([
            'code' => 'DOCUMENT-LEAVE-APPROVAL',
            'name' => 'อนุมัติการลา',
            'route' => 'groups.document-system.leave.approval',
            'view' => 'groups.document-system.leave.approval.index'
        ]);
        Job::create([
            'code' => 'DOCUMENT-OVERTIME',
            'name' => 'รายการล่วงเวลา',
            'route' => 'groups.document-system.overtime.document',
            'view' => 'groups.document-system.overtime.document.index'
        ]);
        Job::create([
            'code' => 'DOCUMENT-OVERTIME-APPROVAL',
            'name' => 'อนุมัติล่วงเวลา',
            'route' => 'groups.document-system.overtime.approval',
            'view' => 'groups.document-system.overtime.approval.index'
        ]);
        Job::create([
            'code' => 'DOCUMENT-APPROVE',
            'name' => 'การอนุมัติ',
            'route' => 'groups.document-system.setting.approve-document',
            'view' => 'groups.document-system.setting.approve-document.index'
        ]);
    }
}
