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
            'name' => 'ระบบลงเวลา',
            'description' => 'รายละเอียดระบบลงเวลา',
        ]);
        Group::create([
            'name' => 'ระบบเงินเดือน',
            'description' => 'รายละเอียดระบบเงินเดือน',
        ]);
        Group::create([
            'name' => 'ระบบฝึกอบรม',
            'description' => 'รายละเอียดระบบฝึกอบรม',
        ]);
    }
}
