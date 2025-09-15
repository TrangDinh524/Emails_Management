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
    public $attachmentPaths;

    public function __construct($emailSubject, $body, $attachmentPaths = [])
    {
        $this->emailSubject = $emailSubject;
        $this->body = $body;
        $this->attachmentPaths = $attachmentPaths;
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
        
        foreach ($this->attachmentPaths as $attachmentPath) {
            if (file_exists($attachmentPath)) {
                $attachments[] = Attachment::fromPath($attachmentPath);
            }
        }
        
        return $attachments;
    }
}
