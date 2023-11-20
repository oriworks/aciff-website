<?php

namespace App\Notifications;

use App\Mail\SuggestionReceivedMessage;
use App\Mail\SuggestionSentMessage;
use App\Models\Suggestion as ModelsSuggestion;
use Oriworks\NewsletterSystem\Models\Pivots\MailQueue;
use Oriworks\NewsletterSystem\Notifications\Notification;

class Suggestion extends Notification
{
    public MailQueue $mailQueue;
    public ModelsSuggestion $suggestion;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MailQueue $mailQueue)
    {
        $this->mailQueue = $mailQueue;
        $this->suggestion = $mailQueue->mailable->systemMailable;
    }

    public function mailMessage(object $notifiable)
    {
        if ($this->mailQueue->emailable_type === config('newsletter-system.models.email')) {
            return (new SuggestionReceivedMessage($this->suggestion, $this->mailQueue->emailable))
                ->subject("Sugestão Recebida: {$this->suggestion->subject}")
                ->to($this->mailQueue->emailable->email, $this->suggestion->department->name);
        } else {
            return (new SuggestionSentMessage($this->suggestion))
                ->subject("Sugestão Enviada: {$this->suggestion->subject}")
                ->to($this->suggestion->email, $this->suggestion->name);
        }
    }
}
