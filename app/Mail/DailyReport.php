<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\EmailStatistic;

class DailyReport extends Mailable
{
    use Queueable, SerializesModels;
    
    public $statistics;
    public $date;

    public function __construct($date, $statistics)
    {
        $this->date = $date;
        $this->statistics = $statistics;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Daily Email Report - ' . $this->date->format('Y-m-d'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.daily-report',
            with: [
                'date' => $this->date,
                'statistics' => $this->statistics,
            ],
        );
    }
}