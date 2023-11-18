<?php

namespace Oriworks\NewsletterSystem\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \jdavidbakr\MailTracker\Events\EmailDeliveredEvent::class => [
            \Oriworks\NewsletterSystem\Listeners\EmailDelivered::class,
        ],
        \jdavidbakr\MailTracker\Events\EmailSentEvent::class => [
            \Oriworks\NewsletterSystem\Listeners\EmailSent::class,
        ],
        \jdavidbakr\MailTracker\Events\ViewEmailEvent::class => [
            \Oriworks\NewsletterSystem\Listeners\EmailViewed::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
