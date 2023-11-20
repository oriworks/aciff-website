<?php

namespace App\Nova;

use Oriworks\NewsletterSystem\Nova\SystemMail as NewsletterSystemMail;

class SystemMail extends NewsletterSystemMail
{
    public static $model = \App\Models\SystemMail::class;
}
