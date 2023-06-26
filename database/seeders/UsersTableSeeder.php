<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'is_admin' => 1,
            'prefix_id' => 1,
            'nationality_id' => 1,
            'ethnicity_id' => 1,
            'user_position_id' => 1,
            'employee_type_id' => 1,
            'company_department_id' => 1,
            'employee_no' => 6944,
            'username' => 6944,
            'name' => 'ชัยวัฒน์',
            'lastname' => 'ทวีจันทร์',
            'phone' => '0654867617',
            'hid' => '6511770771292',
            'birth_date' => Carbon::createFromFormat('m/d/Y', '02/17/1980')->format('Y-m-d'),
            'visa_expiry_date' => Null,
            'permit_expiry_date' => Null,
            'work_schedule_id' => 1,
            'email' => '6944@gmail.com',
            'password' => bcrypt('11111111')
        ]);
        User::create([
            'is_admin' => 0,
            'prefix_id' => 2,
            'nationality_id' => 1,
            'ethnicity_id' => 1,
            'user_position_id' => 1,
            'employee_type_id' => 1,
            'company_department_id' => 2,
            'employee_no' => 6945,
            'username' => 6945,
            'name' => 'ธัญพร',
            'lastname' => 'สุวรรณโชติ',
            'phone' => '0654867618',
            'hid' => '8075222458615',
            'birth_date' => Carbon::createFromFormat('m/d/Y', '02/17/1980')->format('Y-m-d'),
            'visa_expiry_date' => Null,
            'permit_expiry_date' => Null,
            'work_schedule_id' => 1,
            'email' => '6945@gmail.com',
            'password' => bcrypt('11111111')
        ]);
        User::create([
            'is_admin' => 0,
            'prefix_id' => 2,
            'nationality_id' => 1,
            'ethnicity_id' => 1,
            'user_position_id' => 1,
            'employee_type_id' => 1,
            'company_department_id' => 1,
            'employee_no' => 6946,
            'username' => 6946,
            'name' => 'ปรียาวดี',
            'lastname' => 'เกษมทรัพย์',
            'phone' => '0654867618',
            'hid' => '3657808855757',
            'birth_date' => Carbon::createFromFormat('m/d/Y', '02/17/1980')->format('Y-m-d'),
            'visa_expiry_date' => Null,
            'permit_expiry_date' => Null,
            'work_schedule_id' => 1,
            'email' => '6946@gmail.com',
            'password' => bcrypt('11111111')
        ]);
        User::create([
            'prefix_id' => 1,
            'nationality_id' => 1,
            'ethnicity_id' => 2,
            'user_position_id' => 5,
            'employee_type_id' => 2,
            'company_department_id' => 3,
            'employee_no' => 6947,
            'username' => 6947,
            'name' => 'วีรภพ',
            'lastname' => 'แสงอุไร',
            'phone' => Null,
            'hid' => Null,
            'birth_date' => Null,
            'visa_expiry_date' => Carbon::createFromFormat('m/d/Y', '08/15/2023')->format('Y-m-d'),
            'permit_expiry_date' => Carbon::createFromFormat('m/d/Y', '08/15/2023')->format('Y-m-d'),
            'work_schedule_id' => 1,
            'email' => '6947@gmail.com',
            'password' => bcrypt('11111111')
        ]);
    }
}
