<?php

namespace App\Mail;

use App\Models\Information;
use App\Models\Journal;
use DOMDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Oriworks\NewsletterSystem\Models\Email;
use Oriworks\NewsletterSystem\Models\Newsletter;
use Urodoz\Truncate\TruncateService;

class JournalMessage extends Mailable
{
    use Queueable, SerializesModels;

    public Email $email;
    private Newsletter $newsletter;
    public Journal $journal;

    /**
     * Create a new message instance.
     */
    public function __construct(Newsletter $newsletter, Email $email)
    {
        $this->email = $email;
        $this->newsletter = $newsletter;
        $this->journal = $newsletter->newsletterable;
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
            subject: $this->journal->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.journal',
            with: [
                'token' => $this->email->token,
                'subject' => $this->journal->subject,
                'information' => $this->journal->information->map(function ($information) {
                    return $this->prepareInformation($information);
                }),
                'banners' => $this->journal->banners,
            ]
        );
    }

    private function prepareInformation(Information $information)
    {
        $dom = new DOMDocument();
        @$dom->loadHTML($information->content);
        $cleaner_input = str_replace(["\n", '<p></p>'], '', strip_tags($information->content, ['a', 'b', 'p', 'strong']));
        $truncateService = new TruncateService();

        return [
            'image' => $dom->getElementsByTagName('img')[0]->getAttribute('src'),
            'subject' => $information->subject,
            'content' => $truncateService->truncate($cleaner_input, 150),
            'link' => ''
        ];
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
