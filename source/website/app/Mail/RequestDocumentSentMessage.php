<?php

namespace App\Mail;

use App\Models\RequestDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RequestDocumentSentMessage extends Mailable
{
    use Queueable, SerializesModels;

    private RequestDocument $requestDocument;

    /**
     * Create a new message instance.
     */
    public function __construct(RequestDocument $requestDocument)
    {
        $this->requestDocument = $requestDocument;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pedido de documento enviado através do formulário do site',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.requestDocument.sent',
            with: [
                'requestDocument' => $this->requestDocument,
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
