<?php

namespace Oriworks\NewsletterSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Oriworks\NewsletterSystem\Models\Concerns\Mailable;
use Oriworks\NewsletterSystem\Models\Pivots\MailingListNewsletter;

class Newsletter extends Model
{
    use HasFactory, HasUuids, Mailable;

    public function sender(): BelongsTo
    {
        return $this->belongsTo(config('newsletter-system.models.sender'));
    }

    public function newsletterable(): MorphTo
    {
        return $this->morphTo();
    }

    public function mailingLists(): BelongsToMany
    {
        return $this->belongsToMany(config('newsletter-system.models.mailing_list'))
            ->using(MailingListNewsletter::class)
            ->withPivot('send_at');
    }
}
