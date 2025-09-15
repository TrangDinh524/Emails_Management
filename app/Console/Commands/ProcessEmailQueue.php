<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\ProcessBatchEmailsJob;
use App\Models\EmailQueue;

class ProcessEmailQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:process-queue {--batch-size=10 : Number of emails to process in each batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process emails from the queue (runs every 10 seconds)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $batchSize = $this->option('batch-size');

        $this->info("Processing emails queue with batch size: {$batchSize}");

        ProcessBatchEmailsJob::dispatch();

        $this->info("Email queue processing job dispatched successfully.");

        $pendingCount = EmailQueue::pending()->count();
        $failedCount = EmailQueue::failed()->count();

        $this->info("Queue Status - Pending: {$pendingCount}, Failed: {$failedCount}");
    }
}
