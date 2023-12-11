<?php

namespace App\Http\Controllers\ReportSystem;

use Carbon\Carbon;
use App\Models\Month;
use App\Models\Payday;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Models\SalarySummary;
use App\Helpers\ActivityLogger;
use App\Models\CompanyDepartment;
use App\Http\Controllers\Controller;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class ReportSystemReportSalaryController extends Controller
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
    public function index()
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
        
        $salarySummaries = SalarySummary::all();
        $year = Carbon::now()->year;;
        $paydayDetails = PaydayDetail::whereHas('payday', function ($query) use ($year) {
                    $query->where('year', $year);
                })->get();

        $previousMonth = Carbon::now()->month-1;
        $currentPaydayDetailIds = PaydayDetail::where(function ($query) use ($previousMonth,$year) {
            $query->whereHas('payday', function ($subQuery) use ($year) {
                $subQuery->where('cross_month', 2)
                        ->where('year', $year);
            })->whereMonth('start_date', $previousMonth);

            $query->orWhere(function ($query) use ($previousMonth,$year) {
                $query->whereHas('payday', function ($subQuery) use ($year) {
                    $subQuery->where('cross_month', 1)
                    ->where('year', $year);
                })->whereMonth('start_date', $previousMonth - 1);
            });
        })
        ->pluck('id')
        ->toArray();
        $previousPaydayDetails = PaydayDetail::whereIn('id',$currentPaydayDetailIds)->get();
        $month = Month::find($previousMonth);

        $paydays = Payday::where('year',$year)->get();     

        return view($viewName, [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'salarySummaries' => $salarySummaries,
            'paydayDetails' => $paydayDetails,
            'paydays' => $paydays,
            'previousPaydayDetails' => $previousPaydayDetails,
            'month' => $month
        ]);
    }

    public function view($id)
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
        
        $companyDepartments = CompanyDepartment::all();
        
        $paydayDetail = PaydayDetail::find($id);

        return view('groups.report-system.report.salary.view', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'companyDepartments' => $companyDepartments,
            'paydayDetail' => $paydayDetail
        ]);
    }

    public function attendance($id){
        // กำหนดค่าตัวแปร $action ให้เป็น 'show'
        $action = 'show';
        // ดึงค่า 'groupUrl' จาก session และแปลงเป็นข้อความ
        $groupUrl = strval(session('groupUrl'));

        // เรียกใช้งานเซอร์วิส updatedRoleGroupCollectionService เพื่อดึงข้อมูล updatedRoleGroupCollection, permission, viewName โดยใช้ค่า $action
        $roleGroupCollection = $this->updatedRoleGroupCollectionService->getUpdatedRoleGroupCollection($action);
        $updatedRoleGroupCollection = $roleGroupCollection['updatedRoleGroupCollection'];
        $permission = $roleGroupCollection['permission'];
        $viewName = $roleGroupCollection['viewName'];
        
        $companyDepartments = CompanyDepartment::all();
        
        $paydayDetail = PaydayDetail::find($id);

        return view('groups.report-system.report.salary.attendance', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'companyDepartments' => $companyDepartments,
            'paydayDetail' => $paydayDetail
        ]);
    }
}
