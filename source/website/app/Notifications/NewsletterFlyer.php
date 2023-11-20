<?php

namespace App\Notifications;

use App\Mail\FlyerMessage;

class NewsletterFlyer extends Newsletter
{
    public function mailMessage(object $notifiable)
    {
        return (new FlyerMessage($this->newsletter, $this->mailQueue->emailable))
            ->subject($this->newsletter->newsletterable->subject)
            ->to($this->mailQueue->emailable->email);
    }
}
