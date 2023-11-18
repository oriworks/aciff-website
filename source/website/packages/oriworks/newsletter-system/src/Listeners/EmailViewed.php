<?php

namespace Oriworks\NewsletterSystem\Listeners;

use Carbon\Carbon;
use jdavidbakr\MailTracker\Events\ViewEmailEvent;
use Oriworks\NewsletterSystem\Models\Pivots\MailQueue;

class EmailViewed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \jdavidbakr\MailTracker\Events\ViewEmailEvent  $event
     * @return void
     */
    public function handle(ViewEmailEvent $event)
    {
        if ($event->sent_email->getHeader('X-Emailable-Type') && $event->sent_email->getHeader('X-Emailable-Id')) {
            if ($event->sent_email->getHeader('X-Mailable-Type') && $event->sent_email->getHeader('X-Mailable-Id')) {
                $mail = MailQueue::where('emailable_type', '=', $event->sent_email->getHeader('X-Emailable-Type'))
                    ->where('emailable_id', '=', $event->sent_email->getHeader('X-Emailable-Id'))
                    ->where('mailable_type', '=', $event->sent_email->getHeader('X-Mailable-Type'))
                    ->where('mailable_id', '=', $event->sent_email->getHeader('X-Mailable-Id'));
                $mail->increment('viewed');
                $mail->update(['viewed_at' => Carbon::now()]);
            }
        }

    }
}
