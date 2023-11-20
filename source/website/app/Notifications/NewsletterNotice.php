<?php

namespace App\Notifications;

use App\Mail\NoticeMessage;

class NewsletterNotice extends Newsletter
{
    public function mailMessage(object $notifiable)
    {
        return (new NoticeMessage($this->newsletter, $this->mailQueue->emailable))
            ->subject($this->newsletter->newsletterable->subject)
            ->to($this->mailQueue->emailable->email);
    }
}
