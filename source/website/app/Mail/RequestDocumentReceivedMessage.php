<?php

namespace App\Mail;

use App\Models\RequestDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Oriworks\NewsletterSystem\Models\Email;

class RequestDocumentReceivedMessage extends Mailable
{
    use Queueable, SerializesModels;

    private Email $email;
    private RequestDocument $requestDocument;

    /**
     * Create a new message instance.
     */
    public function __construct(RequestDocument $requestDocument, Email $email)
    {
        $this->email = $email;
        $this->requestDocument = $requestDocument;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Pedido de documento recebido através do formulário do site',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.requestDocument.received',
            with: [
                'token' => $this->email->token,
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
