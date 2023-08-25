<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Leave;
use App\Models\Shift;
use App\Models\Payday;
use App\Models\Approver;
use App\Models\ApproverUser;
use App\Models\PaydayDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\WorkScheduleAssignment;
use App\Helpers\PayDaySameMonthGenerator;
use App\Helpers\PayDayCrossMonthGenerator;
use App\Models\WorkSchedule;
use App\Models\WorkScheduleAssignmentUser;

class TestController extends Controller
{
    public function isDateValid()
    {
        $datein = '2023-05-19';
        // $time1 = '02:54:00';
        $time1 = '15:45:00';
        $dateout = '2023-05-20';
        // $time2 = '15:45:00';
        $time2 = '02:54:00';

        // Combine the date and time values
        $datetimein = Carbon::parse($datein . ' ' . $time1);
        $datetimeout = Carbon::parse($dateout . ' ' . $time2);

        // Calculate the initial hour difference
        $hourDifference = $datetimein->diffInHours($datetimeout);

        if ($hourDifference > 24) {
            $datetimein = Carbon::parse($datein . ' ' . $time2);
            $datetimeout = Carbon::parse($dateout . ' ' . $time1);
            $hourDifference = $datetimein->diffInHours($datetimeout);
            $datein = $datetimein;
            $dateout = $datetimeout;
        } else {
            $datein = $datetimein;
            $dateout = $datetimeout;
        }

        echo "Date In: $datein \n";
        echo "Date Out: $dateout \n";
        echo "Hour Difference: $hourDifference\n";

    }

    public function clearDB()
    {
        DB::table('work_schedule_assignments')
        ->update(['start_shift' => 0]);
        DB::table('work_schedule_assignment_users')
        ->update(
            [
                'date_in' => null,
                'date_out' =>null,
                'time_in' => null,
                'time_out' =>null,
                'original_time' =>null,
                'code' =>null
        ]);
    }

    public function classifyDate()
    {
        $currentDate = '2023-05-25';
       
        $time = '15:35 02:50';
        $startShiftTime = '16:00';
        $endShiftTime = '01:00';
        // $shiftType = 'FULL_DAY_SHIFT';
        $shiftType = 'CROSS_DAY_SHIFT';
        $timeIn = $this->getStartTime($time,$currentDate,$startShiftTime);
        $timeOut = $this->getEndTime($time,$currentDate,$endShiftTime,$shiftType);
        dd($timeIn,$timeOut);

    }

    public function getStartTime($time, $date, $startShiftTime)
    {
        $shiftTime = $date . ' ' . $startShiftTime;
        $timeParts = explode(' ', $time);

        foreach ($timeParts as $timePart) {
            $timeToCheck = $date . ' ' . $timePart;
            $times = $this->calculateBeginEndTime($shiftTime);
            if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                return $timePart;
            }
        }

        return null;
    }

    function calculateBeginEndTime($shiftTime)
    {
        $beginTime = Carbon::createFromFormat('Y-m-d H:i', $shiftTime)->subHours(2)->format('Y-m-d H:i');
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $shiftTime)->addHours(6)->addMinutes(30)->format('Y-m-d H:i');

        return [
            'beginTime' => $beginTime,
            'endTime' => $endTime,
        ];
    }

    function isTimeInRange($time, $start, $end) {
        $time = Carbon::createFromFormat('Y-m-d H:i', $time);
        $start = Carbon::createFromFormat('Y-m-d H:i', $start);
        $end = Carbon::createFromFormat('Y-m-d H:i', $end);

        return $time->gte($start) && $time->lte($end);
    }

    public function getEndTime($time,$date,$endShiftTime,$shiftType)
    {
        if ($shiftType == 'CROSS_DAY_SHIFT')
        {
            $date = Carbon::createFromFormat('Y-m-d', $date)->addDay()->format('Y-m-d');
        }
        $shiftTime = $date . ' ' . $endShiftTime;
        
        $timeParts = explode(' ', $time);
        foreach ($timeParts as $timePart) {
            $timeToCheck = $date . ' ' . $timePart;
            $times = $this->calculateBeginEndTime($shiftTime);

            if ($this->isTimeInRange($timeToCheck, $times['beginTime'], $times['endTime'])) {
                
                return $timePart;
            }
        }
        return null;
    }

    public function testRoute()
    {
        // $user = User::where('employee_no',170107)->first();
        // $workScheduleAssignmentUsers = $user->getWorkScheduleAssignmentUsersByConditions('2023-05-26','2023-06-25', '2023');
        // dd($workScheduleAssignmentUsers);
        // $user = User::where('employee_no',170107)->first();
        // $approvers = $user->approvers->first();
        
        // $user = User::where('employee_no',170107)->first();
        // $holidays = $user->getHolidayDates('2023-05-01','2023-05-15');
        // dd($holidays);

        // $data = [
        //     ['user_id' => 1, 'status' => 0],
        //     ['user_id' => 2, 'status' => 1]
        // ];
        // $approverId = 1;
        // $userId = 1;
        // $approverUser = new ApproverUser();
        // $approverUser->approver_id = $approverId; // Replace $approverId with the actual value
        // $approverUser->user_id = $userId; // Replace $userId with the actual value
        // $approverUser->approved_list = json_encode($data);
        // $approverUser->save();
        // $approver = Approver::find($approverId);
        // $checkId = 4; // Replace 1 with the actual user ID you want to retrieve the related ApproverUser for
        // $approverUser = $approver->getApproverUserByUserId($userId);
        
        // if ($approverUser) {
        //     $approvalStatus = $approverUser->getApprovalStatusForUser($checkId);

        //     if ($approvalStatus === null) {
        //         echo 'User ID not found in the approved_list';
        //     } elseif ($approvalStatus == 1) {
        //         echo 'User approved';
        //     } elseif ($approvalStatus == 2) {
        //         echo 'User rejected';
        //     } elseif ($approvalStatus == 0) {
        //         echo 'User not approved yet';
        //     }
        // } else {
        //     echo 'No user found for the specified user ID';
        // }


//         $startDate = '2022-12-26';
//         $endDate = '2023-01-25';
//         $numPayDays = 12;
//         $numDayToPayment = 5;
//         $useEndMonth = true;    
//         $generator = new PayDayCrossMonthGenerator();
//         $payDays = $generator->generateCrossMonthPayDays($startDate, $endDate, $numPayDays, $useEndMonth,$numDayToPayment); // or false based on your use case
// // return $payDays;
//         $startDate = '2023-01-01';
//         $endDate = '2023-01-15';
//         $numPayDays = 12; 
//         $numDayToPayment = 7;
//         $generator = new PayDaySameMonthGenerator();
//         $payDays = $generator->generateSameMonthPayDays($startDate, $endDate, $numPayDays, $useEndMonth,$numDayToPayment); // or false based on your use case
// //    return $payDays;
//         $startDate = '2023-01-16';
//         $endDate = '2023-01-31';
//         $numPayDays = 12; 
//         $numDayToPayment = 7;
//         $generator = new PayDaySameMonthGenerator();
//         $payDays = $generator->generateSameMonthPayDays($startDate, $endDate, $numPayDays, $useEndMonth,$numDayToPayment); // or false based on your use case
   
//         return $payDays;

        // $monthId = 5; // Replace with the actual month_id
        // $currentDate = '2023-06-02';
        // $date = Carbon::now();
        // $monthId = intval(Carbon::now()->month);
        // $currentDate = $date->format('Y-m-d');
        // // $date = Carbon::now();

        // $paydayDetails = PaydayDetail::where('month_id', $monthId)
        //     ->whereDate('end_date', '<=', Carbon::parse($currentDate))
        //     ->whereDate('payment_date', '>=', Carbon::parse($currentDate))
        //     ->get();

        // // dd($paydayDetails)    ;
        // foreach($paydayDetails as $paydayDetail)
        // {
        //     $payday = Payday::find($paydayDetail->payday_id);
        //     echo($payday->name . ' <br>');
        // }  

        // $user = User::find(311);
        // $startDateInput = '05/05/2023';
        // $startDate = Carbon::createFromFormat('d/m/Y', $startDateInput)->format('Y-m-d');
        // dd($user->isShiftAssignment($startDate));

        // Call the function with your start and end dates
        // $startDate = '25/05/2023 07:00';
        // $endDate = '26/05/2023 19:00';
        // $startDateTime = Carbon::createFromFormat('d/m/Y H:i', $startDate);
        // $endDateTime = Carbon::createFromFormat('d/m/Y H:i', $endDate);
        // $dateList = $this->generateDateList($startDateTime, $endDateTime);

        // // Display the result
        // print_r($dateList);

        // $dateInput = '2023-05-02';
        // $userId = 312;

        // $leave = $this->getAttachmentForDate($dateInput,$userId);
        // dd($leave);

        // $workScheduleAssignmentUserId = 2; // Your work schedule assignment user ID

        // $shift = WorkScheduleAssignmentUser::findOrFail($workScheduleAssignmentUserId)
        //     ->workScheduleAssignment
        //     ->shift;
        //     dd($shift);



        // $shiftId = WorkScheduleAssignmentUser::findOrFail($workScheduleAssignmentUserId)
        //     ->workScheduleAssignment
        //     ->shift
        //     ->pluck('id');
        //     dd()

        // $user = User::find(311);
        // $year = '2023';
        // $month = 5;
        // $workSchedule = $user->workScheduleAssignmentUsers()
        //     ->whereHas('workScheduleAssignment', function ($query) use ($month, $year) {
        //         $query->where('month_id', $month)
        //             ->where('year', $year);
        //     })
        //     ->orderBy('date_in')
        //     ->with('workScheduleAssignment.workSchedule')
        //     ->get()
        //     ->pluck('workScheduleAssignment.workSchedule')
        //     ->unique('work_schedule_id')->first();

        // dd($workSchedule) ;
        // $user = User::find(311); // Replace with the actual user ID

        // $firstApprover = $user->approvers->where('document_type_id', 1)->first();

        // if ($firstApprover) {
        //     $authorizedUserIds = $firstApprover->authorizedUsers->pluck('id');
        //     dd($authorizedUserIds);
        // }

        // $authoIds = $this->getAuthorizedUserIdsForLeave();
        // dd($authoIds);

        // $user = User::find(311);
        // $firstApprover = $user->approvers->where('document_type_id', 1)->first();
        // dd($firstApprover);
        

        // Define your start and end date range
        // $startDate = Carbon::parse('2023-08-01'); // Replace with your start date
        // $endDate = Carbon::parse('2023-08-15');   // Replace with your end date

        // $userIds = WorkScheduleAssignmentUser::whereHas('workScheduleAssignment', function ($query) use ($startDate, $endDate) {
        //     $query->whereBetween('short_date', [$startDate, $endDate]);
        // })->pluck('user_id')->unique()->toArray();


        // dd($userIds);


            // $paydayDetail = PaydayDetail::where('payday_id', 3)
            // ->whereDate('end_date', '<=', '2023-08-23')   // Check if today is before or equal to end_date
            // ->whereDate('payment_date', '>=', '2023-08-23') // Check if payment_date is not in the future
            // ->first();
            // dd($paydayDetail);


        // $user = User::where('employee_no','900214')->first();
        // $today = Carbon::today();

        // $paydaysWithToday = $user->paydays()->whereHas('paydayDetails', function ($query) use ($today) {
        //     $query->whereDate('end_date', '<=', $today)
        //         ->whereDate('payment_date', '>=', $today);
        // })->first();

        // dd($paydaysWithToday);


    //     $paydayDetail = PaydayDetail::whereDate('end_date', '<=', $today)
    //         ->whereDate('payment_date', '>=', $today)
    //         ->whereHas('payday', function ($query) use ($user) {
    //             $query->whereHas('users', function ($subQuery) use ($user) {
    //                 $subQuery->where('user_id', $user->id);
    //             });
    //         })
    //         ->first();

    // dd($paydayDetail);

    // dd($user->getErrorDate());
        






        // // Loop through each user's payday
        // foreach ($user->paydays as $payday) {
        //     $end_date = Carbon::parse($payday->pivot->end_date);
        //     $payment_date = Carbon::parse($payday->pivot->payment_date);
        //     // echo($payday->name . ' ' . $end_date . ' ' . $payment_date . '<br>');
            
        //     $paydayDetail = PaydayDetail::where('payday_id', $payday->id)
        //     ->whereDate('end_date', '<=', $today)   // Check if today is before or equal to end_date
        //     ->whereDate('payment_date', '>=', $today) // Check if payment_date is not in the future
        //     ->first();



        //     if ($paydayDetail) {
        //         dd('aha');
        //         // There is a payday detail for the given payday that matches the criteria
        //         // You can access $paydayDetail->start_date, $paydayDetail->end_date, etc.
        //     }

        //     // Check if today's date is within the range of start_date and end_date
        //     if ($today->between($end_date, $payment_date)) {
        //         // Today is within the payday range for this user
        //         // You can perform your desired action here
        //         // For example, you can access $payday->pivot->payment_date to get the payment date
        //         // $payday->pivot->payment_date will be null if no payment date has been set
        //         // $payday->name will give you the name of the payday
        //     }
        // }

        // $today = now()->toDateString();

        // $paydays = Payday::whereHas('paydayDetails', function ($query) use ($today) {
        //     $query->whereDate('end_date', '<=', $today)
        //         ->whereDate('payment_date', '>=', $today);
        // })->get();

        // foreach($paydays as $payday)
        // {
        //     $paydayDetailId = PaydayDetail::where('payday_id',$payday->id)
        //     ->whereDate('end_date', '<=', $today)
        //     ->whereDate('payment_date', '>=', $today)
        //     ->first()->id;
        // }

        // dd($paydays);
        // $today = now()->toDateString();

        // $paydayDetails = PaydayDetail::whereDate('end_date', '<=', $today)
        //     ->whereDate('payment_date', '>=', $today)
        //     ->get();

        // $paydayDetailIds = $paydayDetails->pluck('id');

        // // dd($paydayDetailIds);

        // $paydaysWithMatchingDetails = Payday::whereHas('paydayDetails', function ($query) use ($paydayDetailIds) {
        //     $query->whereIn('id', $paydayDetailIds);
        // })->get();

        // dd($paydaysWithMatchingDetails);

        // $user = User::where('employee_no','900214')->first();
        // dd($user->getPaydayDetailWithToday());

        // $user = User::find(765);
        // $user->getTimeRecordInfo('2023-08-01','2023-08-15');

        // dd($user->IsvalidTimeInOut('2023-08-01','2023-08-15'));

        // $originalHours = 8;
        // $minutesToSubtract = 52;

        // // Convert the total hours to minutes and subtract the given minutes
        // $totalMinutes = ($originalHours * 60) - $minutesToSubtract;

        // // Calculate the remaining hours and minutes
        // $remainingHours = floor($totalMinutes / 60);
        // $remainingMinutes = $totalMinutes % 60;

        // echo "Remaining Time: $remainingHours hours $remainingMinutes minutes\n";

        // dd(intval((52 / 60)),(52 % 60)/100);

$originalHours = 8;
$minutesToSubtract = 52;

// Convert minutes to decimal hours
$decimalHoursToSubtract = $minutesToSubtract / 60;

// Subtract decimal hours from original hours
$remainingHours = $originalHours - $decimalHoursToSubtract;

// Calculate the remaining minutes
$remainingMinutes = round(($remainingHours - floor($remainingHours)) * 60);

echo "Original Hours: $originalHours\n";
echo "Minutes to Subtract: $minutesToSubtract\n";
echo "Remaining Hours: " . floor($remainingHours) . " hours\n";
echo "Remaining Minutes: $remainingMinutes minutes\n";





    }

    public function getAuthorizedUserIdsForLeave()
    {
        $user = User::find(311);
        $firstApprover = $user->approvers->where('document_type_id', '1')->first();

        if ($firstApprover) {
            return $firstApprover->authorizedUsers->pluck('id');
        } else {
            return collect(); // Return an empty collection if no approver is found
        }
    }
    

    public function getAttachmentForDate($dateIn,$uerId) {
        $date = $dateIn;
        $leave = Leave::where('user_id', $uerId)
        ->whereDate('from_date', '<=', $date)
        ->whereDate('to_date', '>=', $date)
        ->first();

        if ($leave) {
            return $leave->attachment;
        } else {
            return null;
        }
    }

    public function generateDateList($startDateTime, $endDateTime)
    {
        $dateList = [];
        if ($startDateTime->format('Y-m-d') === $endDateTime->format('Y-m-d')) {
            $dateList[] = $startDateTime->format('d/m/Y');
        } else {
            // Generate and add intermediate dates to the list
            while ($startDateTime->lte($endDateTime)) {
                $dateList[] = $startDateTime->format('d/m/Y');
                $startDateTime->addDay();
            }
        }
        return $dateList;
    }



    
}
