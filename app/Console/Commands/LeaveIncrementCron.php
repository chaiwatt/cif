<?php

namespace App\Console\Commands;

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
        $leaveIncrements = LeaveIncrement::all();

        foreach ($leaveIncrements as $leaveIncrement)
        {
            //check each user with each leave, if month match then change quantity field.
        }
    }
}
