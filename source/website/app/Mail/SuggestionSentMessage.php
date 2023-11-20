<?php

namespace App\Mail;

use App\Models\Suggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuggestionSentMessage extends Mailable
{
    use Queueable, SerializesModels;

    private Suggestion $suggestion;

    /**
     * Create a new message instance.
     */
    public function __construct(Suggestion $suggestion)
    {
        $this->suggestion = $suggestion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contacto enviado através do formulário do site',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.suggestion.sent',
            with: [
                'suggestion' => $this->suggestion,
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
        return [];
    }
}
