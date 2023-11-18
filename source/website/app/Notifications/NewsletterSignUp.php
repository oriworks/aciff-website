<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Oriworks\NewsletterSystem\Notifications\NewsletterSignUp as NewsletterSystemSignUp;

class NewsletterSignUp extends NewsletterSystemSignUp
{
    /**
     * Get the mail representation of the notification.
     */
    public function mailMessage(object $notifiable): MailMessage
    {
        return parent::mailMessage($notifiable)
            ->salutation("Com cumprimentos,\nDa equipa ACIFF");
    }
}
