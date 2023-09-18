<?php

namespace Database\Seeders;

use App\Models\User;
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
            'code' => 'L-001',
            'name' => 'เอกสารการลา',
            'document_type_id' => 1,
            'company_department_id' => 1
        ]);
        // Approver::create([
        //     'code' => 'OT-001',
        //     'name' => 'โอที รายวัน NNDDN (17.00-02.00 เวียน 08.00-17.00) กะดึก',
        //     'document_type_id' => 2,
        //     'company_department_id' => 1
        // ]);

        $approver1 = Approver::find(1);
        $approver1->authorizedUsers()->attach([1,4]);
        // $approver2 = Approver::find(2);
        // $approver2->authorizedUsers()->attach([1]);

        // $approver1->users()->attach(User::where('employee_no',170094)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',170107)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',180061)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',180119)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',180126)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',180142)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',180151)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',190040)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',190071)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',190109)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',200001)->first()->id);
        // $approver1->users()->attach(User::where('employee_no',200084)->first()->id);

        // $approver2->users()->attach(User::where('employee_no',100530)->first()->id);
    }
}
