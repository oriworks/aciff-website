<?php

return [
    "redirect_route" => "home",
    "num_emails_to_send" => 1,
    "models" => [
        "email" => \Oriworks\NewsletterSystem\Models\Email::class,
        "mailing_list" => \Oriworks\NewsletterSystem\Models\MailingList::class,
        "sender" => \Oriworks\NewsletterSystem\Models\Sender::class,
        "newsletter" => \Oriworks\NewsletterSystem\Models\Newsletter::class,
        "system_mail" => \Oriworks\NewsletterSystem\Models\SystemMail::class,
        "mail_queue" => \Oriworks\NewsletterSystem\Models\Pivots\MailQueue::class,
    ],
    "resources" => [
        "email" => \Oriworks\NewsletterSystem\Nova\Email::class,
        "mailing_list" => \Oriworks\NewsletterSystem\Nova\MailingList::class,
        "sender" => \Oriworks\NewsletterSystem\Nova\Sender::class,
        "newsletter" => \Oriworks\NewsletterSystem\Nova\Newsletter::class,
        "system_mail" => \Oriworks\NewsletterSystem\Nova\SystemMail::class,
        "mail_queue" => \Oriworks\NewsletterSystem\Nova\MailQueue::class,
    ],
    "notification-types" => [
        'NewsletterSignUp' => \Oriworks\NewsletterSystem\Notifications\NewsletterSignUp::class,
        'NewsletterCancellation' => \Oriworks\NewsletterSystem\Notifications\NewsletterCancellation::class,
    ],
    "system-mailable-types" => [],
    "mailable-types" => [],
    "emailable-types" => [
        Oriworks\NewsletterSystem\Nova\Email::class => "email",
    ],
];
