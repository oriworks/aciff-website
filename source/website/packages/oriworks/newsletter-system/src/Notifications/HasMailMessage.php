<?php

namespace Oriworks\NewsletterSystem\Notifications;

interface HasMailMessage
{
    public function mailMessage(object $notifiable);
}
