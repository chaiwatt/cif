<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDiligenceAllowance;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserDiligenceAllowancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::all() as $user) {
         UserDiligenceAllowance::create([
                'user_id' => $user->id,
                'level' => 1,
                'diligence_allowance_id' => 1,
            ]);
        }
    }
}
