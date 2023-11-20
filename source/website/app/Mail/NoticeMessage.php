<?php

namespace App\Mail;

use App\Models\Notice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Oriworks\NewsletterSystem\Models\Email;
use Oriworks\NewsletterSystem\Models\Newsletter;

class NoticeMessage extends Mailable
{
    use Queueable, SerializesModels;

    public Email $email;
    private Newsletter $newsletter;
    private Notice $notice;

    /**
     * Create a new message instance.
     */
    public function __construct(Newsletter $newsletter, Email $email)
    {
        $this->email = $email;
        $this->newsletter = $newsletter;
        $this->notice = $newsletter->newsletterable;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: isset($this->newsletter->sender) ? new \Illuminate\Mail\Mailables\Address(
                $this->newsletter->sender->email,
                $this->newsletter->sender->name
            ) : null,
            subject: $this->notice->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.notice',
            with: [
                'token' => $this->email->token,
                'sender' => $this->newsletter->sender,
                'subject' => $this->notice->subject,
                'content' => $this->notice->content,
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
        return $this->notice->getMedia('attachments')->map(function ($attachment) {
            return \Illuminate\Mail\Mailables\Attachment::fromPath($attachment->getPath())
                ->as(($attachment->getCustomProperty('descriptions') ? $attachment->getCustomProperty('descriptions') : $attachment->name) . '.' . $attachment->getTypeAttribute())
                ->mime($attachment->mime_type);
        })->toArray();
    }
}
