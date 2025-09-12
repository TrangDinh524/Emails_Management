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
    public $attachments;

    /**
     * Create a new message instance.
     */
    public function __construct($emailSubject, $body, $attachments=[])
    {
        $this->emailSubject = $emailSubject;
        $this->body = $body;
        $this->attachments = $attachments;
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
        return new Content(
            view: 'emails.send-email',
            with: [
                'content' => $this->body,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachmentObjects = [];
        foreach ($this->attachments as $attachment) {
            if (is_array($attachment) && isset($attachment['path'])) {
                $attachmentObjects[] = Attachment::fromPath($attachment['path'])
                ->as($attachment['name'] ?? basename($attachment['path']))
                ->withMime($attachment['mime'] ?? null);
            } elseif(is_string($attachment)) {
                $attachmentObjects[] = Attachment::fromPath($attachment);
            }
        }

        return $attachmentObjects;
    }
}
