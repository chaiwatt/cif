<?php

namespace App\Http\Controllers\TimeRecordingSystems;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payday;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\WorkScheduleAssignmentUser;
use App\Services\UpdatedRoleGroupCollectionService;

class TimeRecordingSystemScheduleWorkTimeRecordingCurrentPaydayController extends Controller
{
    private $updatedRoleGroupCollectionService;

    public function __construct(UpdatedRoleGroupCollectionService $updatedRoleGroupCollectionService) 
    {
        $this->updatedRoleGroupCollectionService = $updatedRoleGroupCollectionService;
    }
    public function index()
    {
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];

        $date = Carbon::now();
        $monthId = intval(Carbon::now()->month);
        $currentDate = $date->format('Y-m-d');
        $type = 1;
        $paydayDetails = PaydayDetail::whereDate('end_date', '<=', Carbon::parse($currentDate))
                    ->whereHas('payday', function ($query) use ($type) {
                        $query->where('type', '=', $type);
                    })
                    ->whereDate('payment_date', '>=', Carbon::parse($currentDate))
                    ->get();

        if (count($paydayDetails) === 0)   
        {
            return redirect()->route('groups.time-recording-system.schedulework.time-recording')
            ->withErrors(['error_out_payday_range' => __('validation.error_specific')]);
        }

        $userIds = [];
        
        foreach($paydayDetails as $paydayDetail)
        {
            $payday = Payday::find($paydayDetail->payday_id);
            $startDate = $paydayDetail->start_date;
            $endDate = $paydayDetail->end_date;
            $ids = WorkScheduleAssignmentUser::whereHas('workScheduleAssignment', function ($query) use ($startDate, $endDate) {
                $query->whereBetween('short_date', [$startDate, $endDate]);
            })->pluck('user_id')->unique()->toArray();
            $userIds = array_merge($userIds, $ids);
        }  
        $userIds = array_unique($userIds);
        $users = User::whereIn('id',$userIds)->get();

        $paydayIds = $paydayDetails->pluck('payday_id')->toArray();
        
        $paydays = Payday::whereIn('id',$paydayIds)->get();
        // ส่งค่าตัวแปรไปยัง view 'groups.time-recording-system.schedulework.time-recording.import.index'
        return view('groups.time-recording-system.schedulework.time-recording-current-payday.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'users' => $users,
            'paydays' => $paydays,
            'paydayDetails' => $paydayDetails
        ]);

    }
   
}
