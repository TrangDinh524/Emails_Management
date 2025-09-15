<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AdminController;

class SendDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send-daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report to admin at 5pm Vietnam time';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $adminController = new AdminController();
        $result = $adminController->generateDailyReport();
        $this->info($result);
    }
}
