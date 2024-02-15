<?php

namespace App\Models;

use Oriworks\NewsletterSystem\Models\SystemMail as NewsletterSystemMail;

class SystemMail extends NewsletterSystemMail
{
    public function suggestions()
    {
        return $this->emailable(Suggestion::class);
    }

    public function associates()
    {
        return $this->emailable(Associate::class);
    }

    public function requestDocuments()
    {
        return $this->emailable(RequestDocument::class);
    }
}
