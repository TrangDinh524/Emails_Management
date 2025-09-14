<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class BulkEmail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $emailSubject;
    public $body;
    public $attachmentPath;

    public function __construct($emailSubject, $body, $attachmentPath = null)
    {
        $this->emailSubject = $emailSubject;
        $this->body = $body;
        $this->attachmentPath = $attachmentPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.send-email',
            with: [
                'content' => $this->body,
            ],
        );
    }

    public function attachments(): array
    {
        $attachments = [];
        
        if ($this->attachmentPath && file_exists($this->attachmentPath)) {
            $attachments[] = Attachment::fromPath($this->attachmentPath);
        }
        
        return $attachments;
    }
}