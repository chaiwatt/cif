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
        ]);
        Group::create([
            'code' => 'SARALY-MANAGEMENT',
            'name' => 'ระบบเงินเดือน',
            'description' => 'รายละเอียดระบบเงินเดือน',
            'icon' => 'fa-wallet',
        ]);
        Group::create([
            'code' => 'TRAINING',
            'name' => 'ระบบฝึกอบรม',
            'description' => 'รายละเอียดระบบฝึกอบรม',
            'icon' => 'fa-user',
        ]);
    }
}
