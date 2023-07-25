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
            'code' => 'SARALY-MANAGEMENT',
            'name' => 'ระบบเงินเดือน',
            'description' => 'รายละเอียดระบบเงินเดือน',
            'icon' => 'fa-wallet',
            'dashboard' => 'groups.dashboard.salary-system'
        ]);
        Group::create([
            'code' => 'DOCUMENT',
            'name' => 'ระบบเอกสาร',
            'description' => 'รายละเอียดระบบเอกสาร',
            'icon' => 'fa-book',
            'dashboard' => 'groups.dashboard.document-system'
        ]);
        Group::create([
            'code' => 'TRAINING',
            'name' => 'ระบบฝึกอบรม',
            'description' => 'รายละเอียดระบบฝึกอบรม',
            'icon' => 'fa-user',
            'dashboard' => 'groups.dashboard.training-system'
        ]);
    }
}
