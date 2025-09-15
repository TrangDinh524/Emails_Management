<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send daily report every day at 5:00 PM Hanoi time
        $schedule->command('email:send-daily-report')
                 ->dailyAt('17:00')
                 ->timezone('Asia/Ho_Chi_Minh');
        
        // Process email queue every 10 seconds
        $schedule->command('email:process-queue')
                ->everyTenSeconds()
                ->withoutOverlapping()
                ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}