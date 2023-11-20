<?php

namespace Oriworks\NewsletterSystem\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Mailable
{
    public static function bootMailable()
    {
        static::deleting(function ($model) {
            $model->mailQueues()->delete();
        });
    }

    public function mailQueues(): MorphMany
    {
        return $this->morphMany(config('newsletter-system.models.mail_queue'), 'mailable');
    }

    public function emails(): MorphToMany
    {
        return $this->emailable(config('newsletter-system.models.email'));
    }

    protected function emailable(string $className): MorphToMany
    {
        return $this->morphedByMany(
            $className,
            'emailable',
            'mail_queues',
            'mailable_id',
            'emailable_id'
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
