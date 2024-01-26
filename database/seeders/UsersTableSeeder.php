<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\LeaveType;
use App\Models\UserLeave;
use App\Models\SalaryRecord;
use App\Models\PositionHistory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
            'address' => '503/15 ม.3 ตำบลหนองขาม อำเภอศรีราชา จังหวัดชลบุรี',
            'user_position_id' => 63,
            'employee_type_id' => 1,
            'diligence_allowance_id' => 2,
            'company_department_id' => 2,
            'employee_no' => 11111111,
            'username' => 11111111,
            'name' => 'super',
            'lastname' => 'user',
            'phone' => '065000000',
            'hid' => '6511770771292',
            'start_work_date' => Carbon::createFromFormat('m/d/Y', '1/16/1995')->format('Y-m-d'),
            'birth_date' => Carbon::createFromFormat('m/d/Y', '02/17/1980')->format('Y-m-d'),
            'visa_expiry_date' => Null,
            'permit_expiry_date' => Null,
            'work_schedule_id' => 1,
            'email' => '11111111@gmail.com',
            'password' => bcrypt('11111111'),
            'district'=> "home",
            'subdistrict'=> "home",
            'city'=> "home",
            'country'=> "home",
            'avatar'=> null
        ]);

       
        
        $user = User::find(1);
       
        $leaveTypes = LeaveType::all();
       
        SalaryRecord::create([
            'user_id' => $user->id,
            'salary' => 354,
            'record_date' => Carbon::today(),
        ]);

        foreach($leaveTypes as $leaveType)
        {
            UserLeave::create([
                'user_id' => $user->id,
                'leave_type_id' => $leaveType->id,
                'count' => rand(3, 10)
            ]);
        }    

        $this->createLeaveTypesForUser($user);

    }
        /**
     * Create leave types data for a specific user.
     *
     * @param \App\User $user
     * @return void
     */
    private function createLeaveTypesForUser($user)
    {
        $leaveTypes = [
            [
                'user_id' => $user->id,
                'leave_type_id' => 1,
                'type' => 1,
                'months' => $this->generateMonthsData([1]),
                'quantity' => 10,
            ],
            [
                'user_id' => $user->id,
                'leave_type_id' => 2,
                'type' => 1,
                'months' => $this->generateMonthsData([1]),
                'quantity' => 10,
            ],
            [
                'user_id' => $user->id,
                'leave_type_id' => 3,
                'type' => 1,
                'months' => $this->generateMonthsData([1]),
                'quantity' => 30,
            ],
            [
                'user_id' => $user->id,
                'leave_type_id' => 4,
                'type' => 1,
                'months' => $this->generateMonthsData([1]),
                'quantity' => 30,
            ],
            [
                'user_id' => $user->id,
                'leave_type_id' => 5,
                'type' => 2,
                'months' => $this->generateMonthsData([1, 3, 5, 7, 9, 11]),
                'quantity' => 1,
            ],
            [
                'user_id' => $user->id,
                'leave_type_id' => 6,
                'type' => 1,
                'months' => $this->generateMonthsData([1]),
                'quantity' => 90,
            ],
            [
                'user_id' => $user->id,
                'leave_type_id' => 7,
                'type' => 1,
                'months' => $this->generateMonthsData([1]),
                'quantity' => 120,
            ],
        ];

        // Insert data into the table
        DB::table('leave_increments')->insert($leaveTypes);
    }

    /**
     * Generate months data with initial values.
     *
     * @param array $checkedMonths
     * @return array
     */
    private function generateMonthsData($checkedMonths)
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $isChecked = in_array($i, $checkedMonths) ? 1 : 0;
            $months[] = ['monthId' => $i, 'isChecked' => $isChecked];
        }
        return json_encode($months);
    }
}
