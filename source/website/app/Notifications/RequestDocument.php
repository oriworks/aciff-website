<?php

namespace App\Notifications;

use App\Mail\RequestDocumentReceivedMessage;
use App\Mail\RequestDocumentSentMessage;
use App\Models\RequestDocument as ModelsRequestDocument;
use Oriworks\NewsletterSystem\Models\Pivots\MailQueue;
use Oriworks\NewsletterSystem\Notifications\Notification;

class RequestDocument extends Notification
{
    public MailQueue $mailQueue;
    public ModelsRequestDocument $requestDocument;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(MailQueue $mailQueue)
    {
        $this->mailQueue = $mailQueue;
        $this->requestDocument = $mailQueue->mailable->systemMailable;
    }

    public function mailMessage(object $notifiable)
    {
        if ($this->mailQueue->emailable_type === config('newsletter-system.models.email')) {
            return (new RequestDocumentReceivedMessage($this->requestDocument, $this->mailQueue->emailable))
                ->subject("Pedido de documento recebida: {$this->requestDocument->document->subject}")
                ->to($this->mailQueue->emailable->email, 'História');
        } else {
            return (new RequestDocumentSentMessage($this->requestDocument))
                ->subject("Pedido de documento enviada: {$this->requestDocument->document->subject}")
                ->to($this->requestDocument->email, $this->requestDocument->name);
        }
    }
}
