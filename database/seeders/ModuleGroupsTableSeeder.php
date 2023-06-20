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
        $group1 = Group::find(1);
        $module1 = Module::find(1);
        $module2 = Module::find(2);
        $module3 = Module::find(3);
        $module4 = Module::find(4);

        // Assign modules to group
        $group1->modules()->attach([$module1->id, $module2->id,$module3->id, $module4->id]);
    }
}
