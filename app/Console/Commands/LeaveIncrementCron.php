<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\CronCheck;
use App\Models\LeaveType;
use App\Models\UserLeave;
use App\Models\LeaveIncrement;
use Illuminate\Console\Command;

class LeaveIncrementCron extends Command
{
    protected $signature = 'app:leave-increment-cron';
    protected $description = 'Command description';

    public function __construct() {
         parent::__construct(); 
    }

    public function handle()
    {
        // $this->leaveIncrement();
        $this->addFromCron();
    }

    public function addFromCron()
    {
        $currentDateTime = Carbon::now();
        $formattedDateTime = $currentDateTime->format('d/m/Y H:i');
        CronCheck::create([
            'datetime_cron' => $formattedDateTime
        ]);
    }

    function leaveIncrement()
    {
        $month = Carbon::now()->month;
        $users = User::all();
        $leaveTypes = LeaveType::all();

        foreach ($users as $user) {
            foreach ($leaveTypes as $leaveType) {
                $leaveIncrement = LeaveIncrement::where('user_id', $user->id)
                    ->where('leave_type_id', $leaveType->id)
                    ->whereRaw("JSON_CONTAINS(months, ?)", [
                        json_encode(['monthId' => $month, 'isChecked' => 1]),
                    ])->first();
                    if($leaveIncrement != null){
                        $numIncrement = $leaveIncrement->quantity;
                        $userLeave = UserLeave::where('user_id',$user->id)->where('leave_type_id', $leaveType->id)->first();
                        if($userLeave != null){
                            $currentLeave = $userLeave->count;
                            $totalNum = $numIncrement;
                            if($leaveIncrement->type == 2){
                                $totalNum = $numIncrement + $currentLeave;
                            }
                            $userLeave->update([
                                'count' => $totalNum
                            ]);
                        }
                    }
            }
        }
    }
}
