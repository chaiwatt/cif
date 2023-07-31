<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create([
            'code' => 'SHIFT',
            'name' => 'กะการทำงาน',
            'icon' => 'fa-clock'
        ]);
        Module::create([
            'code' => 'WORK-SCHEDULE',
            'name' => 'ตารางทำงาน',
            'icon' => 'fa-calendar-alt'
        ]);
        Module::create([
            'code' => 'TIME-RECORDING-SETTING',
            'name' => 'การตั้งค่า',
            'icon' => 'fa-cog'
        ]);
        Module::create([
            'code' => 'TIME-RECORDING-REPORT',
            'name' => 'รายงาน',
            'icon' => 'fa-chart-pie'
        ]);
        Module::create([
            'code' => 'SARALY-MODULE-ONE',
            'name' => 'โมดูลเงินเดือน1',
            'icon' => 'fa-wallet'
        ]);
        Module::create([
            'code' => 'SARALY-MODULE-SETTING',
            'name' => 'ตั้งค่า',
            'icon' => 'fa-cog'
        ]);
        Module::create([
            'code' => 'DOCUMENT-LEAVE',
            'name' => 'การลา',
            'icon' => 'fa-calendar-alt'
        ]);
        Module::create([
            'code' => 'DOCUMENT-OVERTIME',
            'name' => 'ล่วงเวลา',
            'icon' => 'fa-clock'
        ]);
        Module::create([
            'code' => 'DOCUMENT-APPROVE-SETTING',
            'name' => 'ตั้งค่า',
            'icon' => 'fa-cog'
        ]);
    }
}
