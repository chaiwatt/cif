<?php

namespace Database\Seeders;

use App\Models\Approver;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ApproversTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Approver::create([
            'name' => 'เอกสารการลา1',
            'document_type_id' => 1,
            'company_department_id' => 1,
            'approver_one_id' => 1,
            'approver_two_id' => 2
        ]);
        Approver::create([
            'name' => 'เอกสารโอที1',
            'document_type_id' => 2,
            'company_department_id' => 1,
            'approver_one_id' => 1,
            'approver_two_id' => 3
        ]);

        $approver1 = Approver::find(1);
        $userID1 = 4;
        $approver2 = Approver::find(2);
        $userID2 = 4;

        $approver1->users()->attach($userID1);
        $approver2->users()->attach($userID2);
    }
}
