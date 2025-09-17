<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Email;
use App\Models\EmailStatistic;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BulkEmail;
use App\Models\EmailQueue;

class SendSingleEmailJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 120;
    public $backoff = [10, 30, 60];

    public $emailId;
    public $subject;
    public $emailContent;
    public $attachmentPaths;
    public $queueId;

    /**
     * Create a new job instance.
     */
    public function __construct($emailId, $subject, $emailContent, $attachmentPaths = [], $queueId = null)
        {
        $this->emailId = $emailId;
        $this->subject = $subject;
        $this->emailContent = $emailContent;
        $this->attachmentPaths = $attachmentPaths;
        $this->queueId = $queueId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $email = Email::find($this->emailId);
            if (!$email) {
                Log::error("Email not found for id: " . $this->emailId);
                if ($this->queueId) {
                    EmailQueue::find($this->queueId)->markAsFailed("Email not found");
                }
                return;
            }
            Mail::to($email->email)->send(new BulkEmail($this->subject, $this->emailContent, $this->attachmentPaths));

            if ($this->queueId) {
                EmailQueue::find($this->queueId)->markAsSent();
            }

             // Track successful email
             $this->trackEmailStatistic(1, 0);

        } catch (\Exception $e) {
            Log::error("Failed to send email to ID:  {$this->emailId} ". $e->getMessage());

            if ($this->queueId) {
                EmailQueue::find($this->queueId)->markAsFailed($e->getMessage());
            }

            // Track failed email
            $this->trackEmailStatistic(0, 1);
            
            throw $e;
        }
    }

    private function trackEmailStatistic($successful, $failed)
    {
        try {
            $today = Carbon::today();
            $statistics = EmailStatistic::getOrCreateForDate($today);
            $statistics->incrementStats($successful + $failed, $successful, $failed);
        }
        catch (\Exception $e) {
            Log::error("Failed to track email statistic: " . $e->getMessage());
        }
    }
}
