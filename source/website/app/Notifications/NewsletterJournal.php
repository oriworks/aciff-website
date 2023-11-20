<?php

namespace App\Notifications;

use App\Mail\JournalMessage;

class NewsletterJournal extends Newsletter
{
    public function mailMessage(object $notifiable)
    {
        return (new JournalMessage($this->newsletter, $this->mailQueue->emailable))
            ->subject($this->newsletter->newsletterable->subject)
            ->to($this->mailQueue->emailable->email);
    }

}
