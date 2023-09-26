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
        $salaryManagementgroup = Group::where('code','SALARY-MANAGEMENT')->first();
        $documentGroup = Group::where('code','DOCUMENT')->first();
        $userManagementGroup = Group::where('code','USER-MANAGEMENT')->first();
        $assessmentGroup = Group::where('code','ASSESSMENT')->first();
        $announcementGroup = Group::where('code','ANNOUNCEMENT')->first();
        $jobApplicationGroup = Group::where('code','JOB-APPLICATION')->first();
        $learningGroup = Group::where('code','LEARNING')->first();
        // Module
        $shiftModule = Module::where('code','SHIFT')->first();
        $workScheduleModule = Module::where('code','WORK-SCHEDULE')->first();
        $timeRecordingSettingModule = Module::where('code','TIME-RECORDING-SETTING')->first();
        $timeRecordingReportModule = Module::where('code','TIME-RECORDING-REPORT')->first();
        $sararyModuleOne = Module::where('code','SALARY')->first();
        $sararyModuleSetting = Module::where('code','SALARY-MODULE-SETTING')->first();
        $approveModuleSetting = Module::where('code','DOCUMENT-APPROVE-SETTING')->first();
        $ducumentLeaveModule = Module::where('code','DOCUMENT-LEAVE')->first();
        $ducumentOvertimeModule = Module::where('code','DOCUMENT-OVERTIME')->first();
        $userManagementModuleSetting = Module::where('code','USER-MANAGEMENT-MODULE-SETTING')->first();
        $assessmentModule = Module::where('code','ASSESSMENT-MODULE')->first();
        $assessmentModuleSetting = Module::where('code','ASSESSMENT-MODULE-SETTING')->first();
        $announcementModule = Module::where('code','ANNOUNCEMENT-MODULE')->first();
        $jobApplicationModule = Module::where('code','JOB-APPLICATION-MODULE')->first();
        $learningModuleSetting = Module::where('code','LEARNING-SETTING')->first();
        $learningModule = Module::where('code','LEARNING')->first();
        
        
        
        // Job
        $shiftManagementJob = Job::where('code','SHIFT-MANAGEMENT')->first();
        $yearlyHolidayJob = Job::where('code','YEARLY-HOLIDAY')->first();
        $workScheduleJob = Job::where('code','WORK-SCHEDULE')->first();
        $workScheduleTimeRecording = Job::where('code','TIME-RECORDING')->first();
        $workScheduleTimeRecordingPayday = Job::where('code','TIME-RECORDING-CURRENT-PAYDAY')->first();
        $workScheduleTimeRecordingCheck = Job::where('code','TIME-RECORDING-CHECK')->first();
        $workScheduleTimeRecordingCheckCurrentPayday = Job::where('code','TIME-RECORDING-CHECK-CURRENT-PAYDAY')->first();
        $workScheduleEmployeeGroup = Job::where('code','EMPLOYEE-GROUP')->first();
        $workScheduleVisibility = Job::where('code','WORK-SCHEDULR-VISIBILITY')->first();
        $workScheduleReport = Job::where('code','WORK-SCHEDULR-REPORT')->first();
        // $sararyCalculation = Job::where('code','SALARY-CALCULATION')->first();
        // $sararyIncomeDeductAssignment = Job::where('code','INCOME-DEDUCT-ASSIGNMENT')->first();
        // $sararySummary = Job::where('code','SALARY-SUMMARY')->first();
        $sararyPayday = Job::where('code','SALARY-PAYDAY')->first();
        $sararySkillBasedCost = Job::where('code','SALARY-SKILL-BASED-COST')->first();
        $sararyIncomeDeduct = Job::where('code','INCOME-DEDUCT')->first();
        $diligenceAllowance = Job::where('code','DILIGENCE-ALLOWANCE')->first();
        $documentApprove = Job::where('code','DOCUMENT-APPROVE')->first();
        $documentLeave = Job::where('code','DOCUMENT-LEAVE')->first();
        $documentLeaveApproval = Job::where('code','DOCUMENT-LEAVE-APPROVAL')->first();
        $documentOvertime = Job::where('code','DOCUMENT-OVERTIME')->first();
        $documentOvetimeApproval = Job::where('code','DOCUMENT-OVERTIME-APPROVAL')->first();
        $userInfo = Job::where('code','USER-INFO')->first();
        $userLeave = Job::where('code','USER-LEAVE')->first();
        $assessment = Job::where('code','ASSESSMENT')->first();
        $assessmentGroupMenu = Job::where('code','ASSESSMENT-GROUP')->first();
        $assessmentCriteria = Job::where('code','ASSESSMENT-CRITERIA')->first();
        $assessmentScore = Job::where('code','ASSESSMENT-SCORE')->first();
        $assessmentScoreMultiplication = Job::where('code','ASSESSMENT-SCORE-MULTIPLICATION')->first();
        $announcementList = Job::where('code','ANNOUNCEMENT-LIST')->first();
        $jobApplicationList = Job::where('code','JOB-APPLICATION-LIST')->first();
        $calculationList = Job::where('code','CALCULATION-LIST')->first();
        $calculationExtraList = Job::where('code','CALCULATION-EXTRA-LIST')->first();
        $learningSetting = Job::where('code','LEARNING-SETTING')->first();
        $learning = Job::where('code','LEARNING-LIST')->first();


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
            'job_id' => $workScheduleTimeRecordingPayday->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $workScheduleModule->id,
            'job_id' => $workScheduleTimeRecordingCheck->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $workScheduleModule->id,
            'job_id' => $workScheduleTimeRecordingCheckCurrentPayday->id,
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
            'module_id' => $timeRecordingReportModule->id,
            'job_id' => $workScheduleReport->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleOne->id,
            'job_id' => $calculationList->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleOne->id,
            'job_id' => $calculationExtraList->id,
        ]);
        // GroupModuleJob::create([
        //     'group_id' => $salaryManagementgroup->id,
        //     'module_id' => $sararyModuleOne->id,
        //     'job_id' => $sararyIncomeDeductAssignment->id,
        // ]);
        // GroupModuleJob::create([
        //     'group_id' => $salaryManagementgroup->id,
        //     'module_id' => $sararyModuleOne->id,
        //     'job_id' => $sararyCalculation->id,
        // ]);
        // GroupModuleJob::create([
        //     'group_id' => $salaryManagementgroup->id,
        //     'module_id' => $sararyModuleOne->id,
        //     'job_id' => $sararySummary->id,
        // ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleSetting->id,
            'job_id' => $sararyPayday->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleSetting->id,
            'job_id' => $sararySkillBasedCost->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleSetting->id,
            'job_id' => $sararyIncomeDeduct->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleSetting->id,
            'job_id' => $diligenceAllowance->id,
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
        GroupModuleJob::create([
            'group_id' => $userManagementGroup->id,
            'module_id' => $userManagementModuleSetting->id,
            'job_id' => $userInfo->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $userManagementGroup->id,
            'module_id' => $userManagementModuleSetting->id,
            'job_id' => $userLeave->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $assessmentGroup->id,
            'module_id' => $assessmentModule->id,
            'job_id' => $assessment->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $assessmentGroup->id,
            'module_id' => $assessmentModuleSetting->id,
            'job_id' => $assessmentGroupMenu->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $assessmentGroup->id,
            'module_id' => $assessmentModuleSetting->id,
            'job_id' => $assessmentCriteria->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $assessmentGroup->id,
            'module_id' => $assessmentModuleSetting->id,
            'job_id' => $assessmentScore->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $assessmentGroup->id,
            'module_id' => $assessmentModuleSetting->id,
            'job_id' => $assessmentScoreMultiplication->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $announcementGroup->id,
            'module_id' => $announcementModule->id,
            'job_id' => $announcementList->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $jobApplicationGroup->id,
            'module_id' => $jobApplicationModule->id,
            'job_id' => $jobApplicationList->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $learningGroup->id,
            'module_id' => $learningModule->id,
            'job_id' => $learning->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $learningGroup->id,
            'module_id' => $learningModuleSetting->id,
            'job_id' => $learningSetting->id,
        ]);
    }
}

