<?php

namespace App\Notifications;

use App\Mail\InformationMessage;

class NewsletterInformation extends Newsletter
{
    public function mailMessage(object $notifiable)
    {
        return (new InformationMessage($this->newsletter, $this->mailQueue->emailable))
            ->subject($this->newsletter->newsletterable->subject)
            ->to($this->mailQueue->emailable->email);
    }

}
