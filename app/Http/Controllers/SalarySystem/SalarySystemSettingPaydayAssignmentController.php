<?php

namespace App\Http\Controllers\SalarySystem;

use Carbon\Carbon;
use App\Models\Payday;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Helpers\PayDaySameMonthGenerator;
use App\Helpers\PayDayCrossMonthGenerator;
use App\Helpers\AddDefaultWorkScheduleAssignment;
use App\Services\UpdatedRoleGroupCollectionService;

class SalarySystemSettingPaydayAssignmentController extends Controller
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

        $paydayDetials = PaydayDetail::where('payday_id',$id)->orderBy('month_id')->get();
        $payday = Payday::find($id);

        return view('groups.salary-system.setting.payday.assignment.index', [
            'groupUrl' => $groupUrl,
            'modules' => $updatedRoleGroupCollection,
            'permission' => $permission,
            'paydayDetials' => $paydayDetials,
            'payday' => $payday
        ]);
    }

    public function store(Request $request)
    {
        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');
        $numDayToPayment = $request->data['duration'];
        $paymentType = $request->data['paymentType'];
        $paydayId = $request->data['paydayId'];
        $useEndMonth = true;
        $numPayDays = 12;
        $payDays = [];

        if ($paymentType === "2") {
            $useEndMonth = false;
        }

        if (Carbon::parse($endDate)->greaterThan(Carbon::parse($startDate)) && Carbon::parse($endDate)->month !== Carbon::parse($startDate)->month) {
            $generator = new PayDayCrossMonthGenerator();
            $payDays = $generator->generateCrossMonthPayDays($startDate, $endDate, $numPayDays, $useEndMonth,$numDayToPayment); // or false based on your use case
        } else {
            
            $generator = new PayDaySameMonthGenerator();
            $payDays = $generator->generateSameMonthPayDays($startDate, $endDate, $numPayDays, $useEndMonth,$numDayToPayment); // or false based on your use case
        }

        foreach ($payDays as $payDay) {
            $existingRecord = PaydayDetail::where('payday_id', $paydayId)
                ->where('month_id', $payDay['month'])
                ->first();
            if ($existingRecord) {
                $existingRecord->update([
                    'start_date' => Carbon::createFromFormat('Y-m-d', $payDay['startDate']),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $payDay['endDate']),
                    'payment_date' => Carbon::createFromFormat('Y-m-d', $payDay['paymentDate']),
                ]);
            } else {
                PaydayDetail::create([
                    'payday_id' => $paydayId,
                    'month_id' => $payDay['month'],
                    'start_date' => Carbon::createFromFormat('Y-m-d', $payDay['startDate']),
                    'end_date' => Carbon::createFromFormat('Y-m-d', $payDay['endDate']),
                    'payment_date' => Carbon::createFromFormat('Y-m-d', $payDay['paymentDate']),
                ]);
            }
        }

        $paydayDetials = PaydayDetail::where('payday_id',$paydayId)->orderBy('month_id')->get();
        $payday = Payday::find($paydayId);
        return view('groups.salary-system.setting.payday.assignment.table-render.payday-table', [
            'paydayDetials' => $paydayDetials,
            'payday' => $payday,
            ])->render();
    }

    public function view(Request $request)
    {
        $paydayDetailId = $request->data['paydayDetailId'];
        $paydayDetail = paydayDetail::find($paydayDetailId);
        return view('groups.salary-system.setting.payday.assignment.modal-render.modal-update-payday-date', [
            'paydayDetail' => $paydayDetail
            ])->render();
    }

    public function update(Request $request)
    {
        $paydayDetailId = $request->data['paydayDetailId'];
        $paydayDetail = PaydayDetail::find($paydayDetailId);
        $startDate = Carbon::createFromFormat('d/m/Y', $request->data['startDate'])->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $request->data['endDate'])->format('Y-m-d');
        $paymentDate = Carbon::createFromFormat('d/m/Y', $request->data['paymentDate'])->format('Y-m-d');

        PaydayDetail::find($paydayDetailId)->update([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'payment_date' => $paymentDate,
                ]);

        $paydayDetail = PaydayDetail::find($paydayDetailId);
        $paydayId = $paydayDetail->payday_id;

        $paydayDetials = PaydayDetail::where('payday_id',$paydayId)->orderBy('month_id')->get();
        $payday = Payday::find($paydayId);
        return view('groups.salary-system.setting.payday.assignment.table-render.payday-table', [
            'paydayDetials' => $paydayDetials,
            'payday' => $payday,
            ])->render();        

    }
}
