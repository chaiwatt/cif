<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\LeaveIncrementCron;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    
    protected $commands = [
        LeaveIncrementCron::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('app:leave-increment-cron')->dailyAt('01:00');
        // เพิ่ม crontab -e ดังนี้
        // 0 1 * * * php /path/to/your/project/artisan schedule:run >> /dev/null 2>&1
        // ตย. centos8 ใช้ 0 1 * * * php /var/www/html/cif/artisan schedule:run >> /dev/null 2>&1
    }

    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
