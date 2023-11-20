<?php

namespace Oriworks\NewsletterSystem\Models\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

abstract class MailingListable extends Model {
    protected $mailing_lists = [];

    abstract public function emails(): MorphToMany;
}
