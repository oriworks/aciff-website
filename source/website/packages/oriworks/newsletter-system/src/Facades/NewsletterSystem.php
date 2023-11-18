<?php

namespace Oriworks\NewsletterSystem\Facades;

use Illuminate\Support\Facades\Facade;

class NewsletterSystem extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'newsletter-system';
    }
}
