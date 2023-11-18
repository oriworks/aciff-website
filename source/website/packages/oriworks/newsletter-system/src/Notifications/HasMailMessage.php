<?php

namespace Oriworks\NewsletterSystem\Notifications;

use Illuminate\Notifications\Messages\MailMessage;

interface HasMailMessage
{
    public function mailMessage(object $notifiable): MailMessage;
}
