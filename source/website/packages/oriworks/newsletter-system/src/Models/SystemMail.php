<?php

namespace Oriworks\NewsletterSystem\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Oriworks\NewsletterSystem\Models\Concerns\Mailable;

class SystemMail extends Model
{
    use HasFactory, HasUuids, Mailable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'notification_type',
    ];

    public function systemMailable(): MorphTo
    {
        return $this->morphTo();
    }
}
