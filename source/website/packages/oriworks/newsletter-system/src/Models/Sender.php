<?php

namespace Oriworks\NewsletterSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sender extends Model
{
    use HasFactory, HasUuids;

    public function newsletters(): HasMany
    {
        return $this->hasMany(config('newsletter-system.models.newsletter'));
    }
}
