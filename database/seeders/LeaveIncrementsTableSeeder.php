<?php

namespace Database\Seeders;

use App\Models\LeaveIncrement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LeaveIncrementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            $leaveIncrements = LeaveIncrement::where('user_id',$user->id)->get();
            if($leaveIncrements->count() == 0){
                $this->createLeaveTypesForUser($user);
            }
            
        }
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
