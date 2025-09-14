<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailStatistic;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\DailyReport;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Generate and send daily report (for scheduled task)
     */
    public function generateDailyReport()
    {
        // Get today's date in Hanoi timezone
        $today = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $todayDate = Carbon::parse($today);
        
        $statistics = EmailStatistic::where('date', $today)->first();

        if (!$statistics) {
            // Create empty statistics for today if none exist
            $statistics = EmailStatistic::create([
                'date' => $todayDate,
                'total_emails_sent' => 0,
                'successful_emails' => 0,
                'failed_emails' => 0,
            ]);
        }

        // Get admin email from config or first user
        $adminEmail = config('mail.admin_email', User::first()?->email);
        
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new DailyReport($todayDate, $statistics));
                \Log::info("Daily report sent successfully to {$adminEmail} for {$today} (Hanoi time)");
                return "Daily report sent successfully to {$adminEmail} for {$today}";
            } catch (\Exception $e) {
                \Log::error("Failed to send daily report: " . $e->getMessage());
                return "Failed to send daily report: " . $e->getMessage();
            }
        }
        
        return "No admin email configured";
    }
}