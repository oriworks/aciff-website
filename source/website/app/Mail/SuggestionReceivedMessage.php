<?php

namespace App\Mail;

use App\Models\Suggestion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Oriworks\NewsletterSystem\Models\Email;

class SuggestionReceivedMessage extends Mailable
{
    use Queueable, SerializesModels;

    private Email $email;
    private Suggestion $suggestion;

    /**
     * Create a new message instance.
     */
    public function __construct(Suggestion $suggestion, Email $email)
    {
        $this->email = $email;
        $this->suggestion = $suggestion;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Contacto recebido através do formulário do site',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.suggestion.received',
            with: [
                'token' => $this->email->token,
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
