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
        $group1 = Group::where('code','TIME-RECORD')->first();
        $module1 = Module::where('code','SHIFT')->first();
        $module2 = Module::where('code','WORK-SCHEDULE')->first();
        $module3 = Module::where('code','TIME-RECORDING-SETTING')->first();
        $module4 = Module::where('code','TIME-RECORDING-REPORT')->first();

        // Assign modules to group
        $group1->modules()->attach([
            $module1->id, 
            $module2->id,
            $module3->id,
            $module4->id
        ]);

        $group2 = Group::where('code','SARALY-MANAGEMENT')->first();
        $module5 = Module::where('code','SARALY-MODULE-SETTING')->first();
        $group2->modules()->attach([
            $module5->id
        ]);

        $group3 = Group::where('code','DOCUMENT')->first();
        $module6 = Module::where('code','APPROVE-MODULE-SETTING')->first();
        $group3->modules()->attach([
            $module6->id
        ]);
    }
}
