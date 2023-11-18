<?php

namespace Oriworks\NewsletterSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use Oriworks\NewsletterSystem\Models\Concerns\Emailable;

class Email extends Model
{
    use HasFactory, HasUuids, Emailable;

    protected static function booted()
    {
        static::creating(function (Email $email) {
            $email->token = Str::random(40);
        });

        static::created(function (Email $email) {

            $modelMailingList = config('newsletter-system.models.mailing_list');
            (new $modelMailingList)->firstOrCreate(['name' => 'Todos'])
                ->emails()
                ->syncWithoutDetaching([$email->id]);

            $modelSystemMail = config('newsletter-system.models.system_mail');
            (new $modelSystemMail)->firstOrCreate(['notification_type' => config('newsletter-system.notification-types.NewsletterSignUp')])
                ->emails()
                ->attach($email, ['priority' => 10, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.system_mail')]);

        });

        static::updating(function (Email $email) {
            $email->token = Str::random(40);
        });
    }

    public function mailingLists(): BelongsToMany
    {
        return $this->belongsToMany(config('newsletter-system.models.mailing_list'));
    }
}
