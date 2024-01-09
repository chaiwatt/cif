<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\Shift;
use App\Models\Payday;
use App\Models\Approver;
use App\Models\LeaveType;
use App\Models\UserLeave;
use App\Models\UserPayday;
use App\Models\LeaveDetail;
use App\Models\ApproverUser;
use App\Models\PaydayDetail;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Exports\OvertimePS02;
use App\Models\LeaveIncrement;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\WorkScheduleAssignment;
use PhpOffice\PhpWord\TemplateProcessor;
use App\Helpers\PayDaySameMonthGenerator;
use App\Helpers\PayDayCrossMonthGenerator;
use App\Models\WorkScheduleAssignmentUser;


class TestController extends Controller
{
    
}
