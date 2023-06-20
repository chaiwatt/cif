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
            'name' => 'เจ้าหน้าที่สามารถดูสร้างแก้ไขลบ'
        ]);
        Role::create([
            'name' => 'เจ้าหน้าที่สามารถดูและสร้าง'
        ]);
        Role::create([
            'name' => 'เจ้าหน้าที่สามารถดูอย่างเดียว'
        ]);

    }
}
