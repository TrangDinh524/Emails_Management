<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\EmailQueue;
use Carbon\Carbon;
use App\Jobs\SendSingleEmailJob;

class ProcessBatchEmailsJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $tries = 3;
    public $timeout = 120;
    
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("Start batch email processing ...");

        $pendingEmails = EmailQueue::where('status', 'pending')
            ->where('created_at', '<=', Carbon::now()->subMinutes(10))
            -> orderBy('created_at', 'asc')
            ->limit(5) // Process 10 emails at a time
            ->get();

        if ($pendingEmails->isEmpty()) {
            Log::info("No pending emails found.");
            return;
        }

        Log::info("Processing {$pendingEmails->count()} emails in batch.");

        foreach($pendingEmails as $emailQueue) {
           try {
                // Dispatch individual email job
                SendSingleEmailJob::dispatch(
                    $emailQueue->id, 
                    $emailQueue->subject, 
                    $emailQueue->email_content, 
                    $emailQueue->attachments ?? []
                );

                $emailQueue->markAsProcessing();
           }
           catch (\Exception $e) {
                Log::error("Failed to process email ID: {$emailQueue->id}: " . $e->getMessage());
                $emailQueue->markAsFailed($e->getMessage());
           }
        }

        Log::info("Batch email processing completed.");
    }
}
