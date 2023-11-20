<?php

namespace App\Notifications;

use App\Mail\AssociateReceivedMessage;
use App\Mail\AssociateSentMessage;
use App\Models\Associate as ModelsAssociate;
use Oriworks\NewsletterSystem\Models\Pivots\MailQueue;
use Oriworks\NewsletterSystem\Notifications\Notification;

class Associate extends Notification
{
    public MailQueue $mailQueue;
    public ModelsAssociate $associate;

    /**
     * Create a new notification instance.
     */
    public function __construct(MailQueue $mailQueue)
    {
        $this->mailQueue = $mailQueue;
        $this->associate = $mailQueue->mailable->systemMailable;
    }

    public function mailMessage(object $notifiable)
    {
        if ($this->mailQueue->emailable_type === config('newsletter-system.models.email')) {
            return (new AssociateReceivedMessage($this->associate, $this->mailQueue->emailable))
                ->subject("Ficha de Adesão Recebida: {$this->associate->social_designation}")
                ->to($this->mailQueue->emailable->email);
        } else {
            return (new AssociateSentMessage($this->associate))
                ->subject("Ficha de Adesão Enviada: {$this->associate->social_designation}")
                ->to($this->associate->contact_email, $this->associate->contact_name)
                ->cc($this->associate->email, $this->associate->social_designation);
        }
    }
}
