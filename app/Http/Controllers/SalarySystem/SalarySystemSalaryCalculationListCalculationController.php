<?php

namespace App\Http\Controllers\SalarySystem;

use Carbon\Carbon;
use App\Models\User;
use App\Models\IncomeDeduct;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Models\IncomeDeductUser;
use App\Http\Controllers\Controller;
use App\Models\UserDiligenceAllowance;
use App\Models\DiligenceAllowanceClassify;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSalaryCalculationListCalculationController extends Controller
{
    private $updatedRoleGroupCollectionService;
    private $addDefaultWorkScheduleAssignment;
    private $activityLogger;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService, AddDefaultWorkScheduleAssignment $addDefaultWorkScheduleAssignment,ActivityLogger $activityLogger) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
        $this->addDefaultWorkScheduleAssignment = $addDefaultWorkScheduleAssignment;
        $this->activityLogger = $activityLogger;
    }
    public function index($id)
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        
        $date = Carbon::now();
        $monthId = intval(Carbon::now()->month);
        $currentDate = $date->format('Y-m-d');
        $type = 1;
        $paydayDetail = PaydayDetail::find($id);

        $userIds = [];
        // foreach($paydayDetails as $paydayDetail)
        // { 
        $startDate = $paydayDetail->start_date;
        $endDate = $paydayDetail->end_date;
        $ids = $this->getUsersByWorkScheduleAssignment($startDate, $endDate)->pluck('id')->toArray();
        
        $paydayDetailWithMaxEndDate = PaydayDetail::where('end_date', '<', $startDate)
            ->where('end_date', function ($query) use ($startDate) {
                $query->selectRaw('MAX(end_date)')
                    ->from('payday_details')
                    ->where('end_date', '<', $startDate);
            })
            ->first();
            
        if ($paydayDetailWithMaxEndDate) {
            $paydayDetailWithMaxEndDateId= $paydayDetailWithMaxEndDate->id;
            foreach ($ids as $userId)
            {
                $userDiligenceAllowance = UserDiligenceAllowance::where('user_id',$userId)->where('payday_detail_id',$paydayDetailWithMaxEndDateId)->first();
                
                if(!$userDiligenceAllowance)
                {
                    $user = User::find($userId);
                    $diligenceAllowanceId = $user->diligence_allowance_id;
                    // dd($user->id,$diligenceAllowanceId);
                    if($diligenceAllowanceId != null){
                        
                        $diligenceAllowanceClassifyId = DiligenceAllowanceClassify::where('diligence_allowance_id',$diligenceAllowanceId)->min('id');
                        UserDiligenceAllowance::create([
                            'user_id' => $userId,
                            'payday_detail_id' => $paydayDetailWithMaxEndDateId,
                            'diligence_allowance_classify_id' => $diligenceAllowanceClassifyId,
                        ]);
                    }

                }
            }
            
        } 
        $userIds = array_merge($userIds, $ids);
        // }  
        $userIds = array_unique($userIds);

        $users = User::whereIn('id', $userIds)->paginate(20);
        $incomeDeducts = IncomeDeduct::all();

        return view('groups.salary-system.salary.calculation-list.calculation.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'paydayDetail' => $paydayDetail,
            'incomeDeducts' => $incomeDeducts
        ]);
    }
    public function importIncomeDeduct(Request $request)
    {
        $paydayDetailId = $request->data['paydayDetailId'];
        $incomeDeductId = $request->data['incomeDeductId'];
        

        foreach ($request->data['employeeNos'] as $employeeNo) {
            [$userId, $value] = explode('-', $employeeNo, 2);
            $userIds[] = $userId;
            $values[] = $value;
        }

        $users = User::whereIn('employee_no',$userIds)->get();
        foreach($users as $index => $user)
        {
                IncomeDeductUser::create([
                    'user_id' => $user->id,
                    'payday_detail_id' => $paydayDetailId,
                    'income_deduct_id' => $incomeDeductId,
                    'value' => $values[$index],
                ]);
        }
    }
    public function getUsersByWorkScheduleAssignment($startDate,$endDate)
    {
        // Convert the start and end date to the correct format
        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));

        // ค้นหาผู้ใช้ที่มีการกำหนดงานเรียกงานใน workScheduleId และ date_in อยู่ในช่วง startDate ถึง endDate
        $users = User::whereHas('workScheduleAssignmentUsers', function ($query) use ($startDate, $endDate) {
            $query->whereNotNull('date_in')
                ->whereBetween('date_in', [$startDate, $endDate]);
        })->get();

        return $users;

    }

}
