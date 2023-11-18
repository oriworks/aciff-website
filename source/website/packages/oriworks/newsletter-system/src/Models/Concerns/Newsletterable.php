<?php

namespace Oriworks\NewsletterSystem\Models\Concerns;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Newsletterable
{
    public function newsletter(): MorphOne
    {
        return $this->morphOne(config('newsletter-system.models.newsletter'), 'newsletterable');
    }
}
