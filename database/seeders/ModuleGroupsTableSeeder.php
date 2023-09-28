<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModuleGroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve groups and modules
        $timeRecord = Group::where('code','TIME-RECORD')->first();
        $shift = Module::where('code','SHIFT')->first();
        $workSchedule = Module::where('code','WORK-SCHEDULE')->first();
        $timeRecordingSetting = Module::where('code','TIME-RECORDING-SETTING')->first();
        // $timeRecordingReport = Module::where('code','TIME-RECORDING-REPORT')->first();

        // Assign modules to group
        $timeRecord->modules()->attach([
            $shift->id, 
            $workSchedule->id,
            $timeRecordingSetting->id,
            // $timeRecordingReport->id
        ]);

        $salaryManagement = Group::where('code','SALARY-MANAGEMENT')->first();
        $salaryModuleSetting = Module::where('code','SALARY-MODULE-SETTING')->first();
        $salaryManagement->modules()->attach([
            $salaryModuleSetting->id
        ]);

        $document = Group::where('code','DOCUMENT')->first();
        $documentLeave = Module::where('code','DOCUMENT-LEAVE')->first();
        $documentOvertime = Module::where('code','DOCUMENT-OVERTIME')->first();
        $documentApproveSetting = Module::where('code','DOCUMENT-APPROVE-SETTING')->first();
        $document->modules()->attach([
            $documentLeave->id,
            $documentOvertime->id,
            $documentApproveSetting->id,
        ]);

        $userManagement = Group::where('code','USER-MANAGEMENT')->first();
        $userManagementModuleSetting = Module::where('code','USER-MANAGEMENT-MODULE-SETTING')->first();

        $userManagement->modules()->attach([
            $userManagementModuleSetting->id
        ]);

        $assessment = Group::where('code','ASSESSMENT')->first();
        $assessmentModuleSetting = Module::where('code','ASSESSMENT-MODULE-SETTING')->first();

        $assessment->modules()->attach([
            $assessmentModuleSetting->id
        ]);

        $announcement = Group::where('code','ANNOUNCEMENT')->first();
        $announcementModule = Module::where('code','ANNOUNCEMENT-MODULE')->first();

        $announcement->modules()->attach([
            $announcementModule->id
        ]);

        $jobApplication = Group::where('code','JOB-APPLICATION')->first();
        $jobApplicationModule = Module::where('code','JOB-APPLICATION-MODULE')->first();

        $jobApplication->modules()->attach([
            $jobApplicationModule->id
        ]);

        $learning = Group::where('code','LEARNING')->first();
        $learningModuleSetting = Module::where('code','LEARNING-SETTING')->first();
        $learningModule = Module::where('code','LEARNING')->first();

        $learning->modules()->attach([
            $learningModule->id,
            $learningModuleSetting->id
        ]);
    }
}
