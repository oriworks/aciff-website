<?php

namespace App\Mail;

use App\Models\Associate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AssociateSentMessage extends Mailable
{
    use Queueable, SerializesModels;

    private Associate $associate;

    /**
     * Create a new message instance.
     */
    public function __construct(Associate $associate)
    {
        $this->associate = $associate;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ficha de sócio enviada através do site',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.associate.sent',
            with: [
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
