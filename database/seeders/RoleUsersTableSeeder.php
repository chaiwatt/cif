<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Retrieve users and roles
        $user1 = User::find(1);
        // $user2 = User::find(2);
        $role1 = Role::find(1);
        // $role2 = Role::find(2);

        // Assign roles to users
        $user1->roles()->attach($role1);
        // $user2->roles()->attach($role2);
    }
}
