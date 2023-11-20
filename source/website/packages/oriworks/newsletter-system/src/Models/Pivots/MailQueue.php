<?php

namespace Oriworks\NewsletterSystem\Models\Pivots;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class MailQueue extends MorphPivot
{
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mail_queues';

    public function emailable(): MorphTo
    {
        return $this->morphTo('emailable');
    }

    public function mailable(): MorphTo
    {
        return $this->morphTo('mailable');
    }
}
