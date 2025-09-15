<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailStatistic extends Model
{
    protected $fillable = [
        'date',
        'total_emails_sent',
        'successful_emails',
        'failed_emails',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    /**
     * Get or create statistics for a specific date
     */
    public static function getOrCreateForDate($date)
    {
        return static::firstOrCreate(
            ['date' => $date],
            [
                'total_emails_sent' => 0,
                'successful_emails' => 0,
                'failed_emails' => 0,
            ]
        );
    }

    /**
     * Increment email statistics
     */
    public function incrementStats($totalSent, $successful, $failed)
    {
        $this->increment('total_emails_sent', $totalSent);
        $this->increment('successful_emails', $successful);
        $this->increment('failed_emails', $failed);
    }
}