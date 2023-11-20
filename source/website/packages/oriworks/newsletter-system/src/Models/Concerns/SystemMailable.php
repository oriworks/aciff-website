<?php

namespace Oriworks\NewsletterSystem\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait SystemMailable
{
    public function systemMail(): MorphOne
    {
        return $this->morphOne(config('newsletter-system.models.system_mail'), 'system_mailable');
    }

    /**
     * Get all of the mailQueues for the emailable.
     */
    public function mailQueues()
    {
        return $this->hasManyThrough(config('newsletter-system.models.mail_queue'), config('newsletter-system.models.system_mail'), 'system_mailable_id', 'mailable_id');
    }
}
