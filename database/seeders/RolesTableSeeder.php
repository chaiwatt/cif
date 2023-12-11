<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'แอดมิน'
        ]);
        Role::create([
            'name' => 'เจ้าหน้าที่ HR'
        ]);
        Role::create([
            'name' => 'หัวหน้างาน / ผู้จัดการ'
        ]);
        Role::create([
            'name' => 'ข้อมูลส่วนตัว'
        ]);
    }
}
