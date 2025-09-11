<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BulkEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $emailSubject;
    public $body;
    public $recipientEmail;

    /**
     * Create a new message instance.
     */
    public function __construct($emailSubject, $body, $recipientEmail)
    {
        $this->emailSubject = $emailSubject;
        $this->body = $body;
        $this->recipientEmail = $recipientEmail;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        
        \Log::info('Email data:', [
            'emailSubject' => $this->emailSubject,
            'body' => $this->body,
            'recipientEmail' => $this->recipientEmail,
        ]);

        return new Content(
            view: 'emails.send-email',
            with: [
                'subject' => $this->emailSubject,
                'body' => $this->body,
                'recipientEmail' => $this->recipientEmail,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
