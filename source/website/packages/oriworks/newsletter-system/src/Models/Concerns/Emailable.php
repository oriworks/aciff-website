<?php

namespace Oriworks\NewsletterSystem\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Notifications\Notifiable;

trait Emailable
{
    use Notifiable;

    public function mailQueues(): MorphMany
    {
        return $this->morphMany(config('newsletter-system.models.mail_queue'), 'emailable');
    }

    public function newsletters(): MorphToMany
    {
        return $this->mailable(config('newsletter-system.models.newsletter'));
    }

    protected function mailable(string $className): MorphToMany
    {
        return $this->morphedByMany(
            $className,
            'mailable',
            'mail_queues',
            'emailable_id',
            'mailable_id'
        )
            ->using(config('newsletter-system.models.mail_queue'))
            ->withPivot(
                'retry',
                'priority',
                'sent_at',
                'sent',
                'delivered_at',
                'delivered',
                'viewed_at',
                'viewed',
                'created_at',
                'updated_at',
            );
    }


}
