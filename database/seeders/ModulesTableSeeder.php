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
            'name' => 'กะการทำงาน',
            'icon' => 'fa-clock'
        ]);
        Module::create([
            'name' => 'ตารางทำงาน',
            'icon' => 'fa-calendar-alt'
        ]);
        Module::create([
            'name' => 'การได้เงินเพิ่ม',
            'icon' => 'fa-arrow-up'
        ]);
        Module::create([
            'name' => 'การหักเงิน',
            'icon' => 'fa-arrow-down'
        ]);
        Module::create([
            'name' => 'โมดูลเงินเดือน1',
            'icon' => 'fa-wallet'
        ]);
        Module::create([
            'name' => 'โมดูลเงินเดือน2',
            'icon' => 'fa-wallet'
        ]);
    }
}
