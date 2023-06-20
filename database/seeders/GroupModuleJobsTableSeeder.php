<?php

namespace Database\Seeders;

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
        GroupModuleJob::create([
            'group_id' => 1,
            'module_id' => 1,
            'job_id' => 1,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 1,
            'module_id' => 1,
            'job_id' => 2,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 1,
            'module_id' => 2,
            'job_id' => 3,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 1,
            'module_id' => 2,
            'job_id' => 4,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 1,
            'module_id' => 2,
            'job_id' => 5,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 1,
            'module_id' => 3,
            'job_id' => 6,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 1,
            'module_id' => 4,
            'job_id' => 7,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 2,
            'module_id' => 5,
            'job_id' => 8,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 2,
            'module_id' => 5,
            'job_id' => 9,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 2,
            'module_id' => 6,
            'job_id' => 10,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
        GroupModuleJob::create([
            'group_id' => 2,
            'module_id' => 6,
            'job_id' => 11,
            'show' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ]);
    }
}
