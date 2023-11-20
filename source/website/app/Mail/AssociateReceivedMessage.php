<?php

namespace App\Mail;

use App\Models\Associate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Oriworks\NewsletterSystem\Models\Email;

class AssociateReceivedMessage extends Mailable
{
    use Queueable, SerializesModels;

    private Email $email;
    private Associate $associate;

    /**
     * Create a new message instance.
     */
    public function __construct(Associate $associate, Email $email)
    {
        $this->email = $email;
        $this->associate = $associate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ficha de sócio recebida através do site',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.associate.received',
            with: [
                'token' => $this->email->token,
                'associate' => $this->associate,
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
