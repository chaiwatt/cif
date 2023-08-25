<?php

namespace App\Http\Controllers\UserManagementSystem;

use Carbon\Carbon;
use App\Models\User;
use App\Models\SalaryRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserManagementSystemSettingUserInfoSalaryController extends Controller
{
    public function store(Request $request)
    {
        $userId = $request->data['userId'];
        $salary = $request->data['salary'];
        $salaryAdjustDate = $request->data['salaryAdjustDate'];
        
        SalaryRecord::create([
            'user_id' => $userId,
            'salary' => $salary,
            'record_date' => Carbon::createFromFormat('m/d/Y', $salaryAdjustDate)->format('Y-m-d'), 
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.salary-table-render',[
            'user' => $user
            ])->render();
        
    }

    public function getSalary(Request $request)
    {
        $salaryRecordId = $request->data['salaryRecordId'];
        $salaryRecord = SalaryRecord::find($salaryRecordId);
        return response()->json($salaryRecord);
    }

    public function update(Request $request)
    {
        $userId = $request->data['userId'];
        $salaryRecordId = $request->data['salaryRecordId'];
        $salary = $request->data['salary'];
        $salaryAdjustDate = $request->data['salaryAdjustDate'];
        SalaryRecord::find($salaryRecordId)->update([
            'salary' => $salary,
            'record_date' => Carbon::createFromFormat('m/d/Y', $salaryAdjustDate)->format('Y-m-d'), 
        ]);
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.salary-table-render',[
            'user' => $user
            ])->render();
    }

    public function delete(Request $request)
    {
        $userId = $request->data['userId'];
        $salaryRecordId = $request->data['salaryRecordId'];

        SalaryRecord::find($salaryRecordId)->delete();
        $user = User::find($userId);
        return view('groups.user-management-system.setting.userinfo.table-render.salary-table-render',[
            'user' => $user
            ])->render();
    }

}
