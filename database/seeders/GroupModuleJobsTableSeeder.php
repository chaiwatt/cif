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
        // Module
        $shiftModule = Module::where('code','SHIFT')->first();
        $workScheduleModule = Module::where('code','WORK-SCHEDULE')->first();
        $extraEarnModule = Module::where('code','EXTRA-EARN')->first();
        $deductionModule = Module::where('code','DEDUCTION')->first();
        $sararyModuleOne = Module::where('code','SARALY-MODULE-ONE')->first();
        $sararyModuleTwo = Module::where('code','SARALY-MODULE-TWO')->first();
        // Job
        $shiftManagementJob = Job::where('code','SHIFT-MANAGEMENT')->first();
        $yearlyHolidayJob = Job::where('code','YEARLY-HOLIDAY')->first();
        $workScheduleJob = Job::where('code','WORK-SCHEDULE')->first();
        $workScheduleTimeRecording = Job::where('code','TIME-RECORDING')->first();
        $extraEarnAgreementJob = Job::where('code','EXTRA-EARN-AGREEMENT')->first();
        $deductionAgreementJob = Job::where('code','DEDUCTION-AGREEMENT')->first();
        $sararyJobOne = Job::where('code','SARALY-JOB-ONE')->first();
        $sararyJobTwo = Job::where('code','SARALY-JOB-TWO')->first();
        $sararyJobThree = Job::where('code','SARALY-JOB-THREE')->first();
        $sararyJobFour = Job::where('code','SARALY-JOB-FOUR')->first();
        
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
            'module_id' => $extraEarnModule->id,
            'job_id' => $extraEarnAgreementJob->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $timeRecordGroup->id,
            'module_id' => $deductionModule->id,
            'job_id' => $deductionAgreementJob->id,
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
            'module_id' => $sararyModuleTwo->id,
            'job_id' => $sararyJobThree->id,
        ]);
        GroupModuleJob::create([
            'group_id' => $salaryManagementgroup->id,
            'module_id' => $sararyModuleTwo->id,
            'job_id' => $sararyJobFour->id,
        ]);
    }
}
