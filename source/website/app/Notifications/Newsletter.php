<?php

namespace App\Notifications;

use Oriworks\NewsletterSystem\Models\Newsletter as ModelsNewsletter;
use Oriworks\NewsletterSystem\Models\Pivots\MailQueue;
use Oriworks\NewsletterSystem\Notifications\Notification;

abstract class Newsletter extends Notification
{
    public MailQueue $mailQueue;
    public ModelsNewsletter $newsletter;

    /**
     * Create a new notification instance.
     */
    public function __construct(MailQueue $mailQueue)
    {
        $this->mailQueue = $mailQueue;
        $this->newsletter = $mailQueue->mailable;
    }
}
