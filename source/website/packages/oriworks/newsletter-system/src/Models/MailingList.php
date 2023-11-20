<?php

namespace Oriworks\NewsletterSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Oriworks\NewsletterSystem\Models\Pivots\MailingListNewsletter;

class MailingList extends Model
{
    use HasFactory, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'secure'
    ];

    public function emails(): BelongsToMany
    {
        return $this->belongsToMany(config('newsletter-system.models.email'));
    }

    public function newsletters(): BelongsToMany
    {
        return $this->belongsToMany(config('newsletter-system.models.newsletter'))
            ->using(MailingListNewsletter::class)
            ->withPivot('send_at');
        ;
    }
}
