<?php

namespace Database\Seeders;

use App\Models\Job;
use App\Models\Group;
use App\Models\Module;
use App\Models\GroupModuleJob;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GroupModuleJobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        // Group
        $timeRecordGroup = Group::where('code','TIME-RECORD')->first();
        $salaryManagementgroup = Group::where('code','SARALY-MANAGEMENT')->first();
        $documentGroup = Group::where('code','DOCUMENT')->first();
        // Module
        $shiftModule = Module::where('code','SHIFT')->first();
        $workScheduleModule = Module::where('code','WORK-SCHEDULE')->first();
        $timeRecordingSettingModule = Module::where('code','TIME-RECORDING-SETTING')->first();
        $timeRecordingReportModule = Module::where('code','TIME-RECORDING-REPORT')->first();
        $sararyModuleOne = Module::where('code','SARALY-MODULE-ONE')->first();
        $sararyModuleSetting = Module::where('code','SARALY-MODULE-SETTING')->first();
        $approveModuleSetting = Module::where('code','DOCUMENT-APPROVE-SETTING')->first();
        $ducumentLeaveModule = Module::where('code','DOCUMENT-LEAVE')->first();
        $ducumentOvertimeModule = Module::where('code','DOCUMENT-OVERTIME')->first();
        // Job
        $shiftManagementJob = Job::where('code','SHIFT-MANAGEMENT')->first();
        $yearlyHolidayJob = Job::where('code','YEARLY-HOLIDAY')->first();
        $workScheduleJob = Job::where('code','WORK-SCHEDULE')->first();
        $workScheduleTimeRecording = Job::where('code','TIME-RECORDING')->first();
        $workScheduleTimeRecordingCheck = Job::where('code','TIME-RECORDING-CHECK')->first();
        $workScheduleEmployeeGroup = Job::where('code','EMPLOYEE-GROUP')->first();
        $workScheduleVisibility = Job::where('code','WORK-SCHEDULR-VISIBILITY')->first();
        $workScheduleReport = Job::where('code','WORK-SCHEDULR-REPORT')->first();
        $extraEarnAgreementJob = Job::where('code','EXTRA-EARN-AGREEMENT')->first();
        $deductionAgreementJob = Job::where('code','DEDUCTION-AGREEMENT')->first();
        $sararyJobOne = Job::where('code','SARALY-JOB-ONE')->first();
        $sararyJobTwo = Job::where('code','SARALY-JOB-TWO')->first();
        $sararyJobThree = Job::where('code','SARALY-JOB-THREE')->first();
        $sararyPayday = Job::where('code','SARALY-PAYDAY')->first();
        $documentApprove = Job::where('code','DOCUMENT-APPROVE')->first();
        $documentLeave = Job::where('code','DOCUMENT-LEAVE')->first();
        $documentLeaveApproval = Job::where('code','DOCUMENT-LEAVE-APPROVAL')->first();
        $documentOvertime = Job::where('code','DOCUMENT-OVERTIME')->first();
        $documentOvetimeApproval = Job::where('code','DOCUMENT-OVERTIME-APPROVAL')->first();
     
        
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $shiftModule->id,
            'job_id' => $shiftManagementJob->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $shiftModule->id,
            'job_id' => $yearlyHolidayJob->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $workScheduleModule->id,
            'job_id' => $workScheduleJob->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $workScheduleModule->id,
            'job_id' => $workScheduleTimeRecording->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $workScheduleModule->id,
            'job_id' => $workScheduleTimeRecordingCheck->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $timeRecordingSettingModule->id,
            'job_id' => $workScheduleEmployeeGroup->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $timeRecordingSettingModule->id,
            'job_id' => $workScheduleVisibility->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $timeRecordingSettingModule->id,
            'job_id' => $extraEarnAgreementJob->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $timeRecordingSettingModule->id,
            'job_id' => $deductionAgreementJob->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $timeRecordingReportModule->id,
            'job_id' => $workScheduleReport->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleOne->id,
            'job_id' => $sararyJobOne->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleOne->id,
            'job_id' => $sararyJobTwo->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleOne->id,
            'job_id' => $sararyJobThree->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleSetting->id,
            'job_id' => $sararyPayday->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $documentGroup->id,
            'module_id' => $ducumentLeaveModule->id,
            'job_id' => $documentLeave->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $documentGroup->id,
            'module_id' => $ducumentLeaveModule->id,
            'job_id' => $documentLeaveApproval->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $documentGroup->id,
            'module_id' => $ducumentOvertimeModule->id,
            'job_id' => $documentOvertime->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $documentGroup->id,
            'module_id' => $ducumentOvertimeModule->id,
            'job_id' => $documentOvetimeApproval->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $documentGroup->id,
            'module_id' => $approveModuleSetting->id,
            'job_id' => $documentApprove->id,
        ]);
    }
}

