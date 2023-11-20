<?php

namespace Oriworks\NewsletterSystem\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MailingListNewsletter extends Pivot
{
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'send_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function (MailingListNewsletter $model) {
            $model->mailingList->emails->each(function ($email) use ($model) {
                if (($model->mailingList->secure || $email->verified_at) && !$email->canceled_at && !$email->newsletters->find($model->newsletter_id)) {
                    $model->newsletter
                    ->emails()
                    ->attach($email, ['priority' => 0, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.newsletter')]);
                }
            });
        });
    }

    public function mailingList()
    {
        return $this->belongsTo(config('newsletter-system.models.mailing_list'));
    }

    public function newsletter()
    {
        return $this->belongsTo(config('newsletter-system.models.newsletter'));
    }
}
