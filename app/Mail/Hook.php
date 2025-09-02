<?php

namespace App\Mail;

use App\Models\LogEntry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class Hook extends Mailable {
    use Queueable, SerializesModels;

    private \App\Models\Hook $hook;
    private LogEntry $logEntry;

    /**
     * Create a new message instance.
     */
    public function __construct(\App\Models\Hook $hook, LogEntry $logEntry) {
        $this->hook = $hook;
        $this->logEntry = $logEntry;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope {
        return new Envelope(
            subject: "[{$this->hook->token->name}] " . Str::limit($this->logEntry->title, 30),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content {
        return new Content(
            view: 'mails.hook',
            with: [
                'logEntry' => $this->logEntry,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array {
        return [];
    }
}
