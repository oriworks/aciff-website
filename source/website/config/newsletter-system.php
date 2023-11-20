<?php

return [
    "redirect_route" => "home",
    "num_emails_to_send" => 1,
    "models" => [
        "email" => \Oriworks\NewsletterSystem\Models\Email::class,
        "mailing_list" => \Oriworks\NewsletterSystem\Models\MailingList::class,
        "sender" => \Oriworks\NewsletterSystem\Models\Sender::class,
        "newsletter" => \Oriworks\NewsletterSystem\Models\Newsletter::class,
        "system_mail" => \App\Models\SystemMail::class,
        "mail_queue" => \Oriworks\NewsletterSystem\Models\Pivots\MailQueue::class,
    ],
    "resources" => [
        "email" => \Oriworks\NewsletterSystem\Nova\Email::class,
        "mailing_list" => \Oriworks\NewsletterSystem\Nova\MailingList::class,
        "sender" => \Oriworks\NewsletterSystem\Nova\Sender::class,
        "newsletter" => \Oriworks\NewsletterSystem\Nova\Newsletter::class,
        "system_mail" => \App\Nova\SystemMail::class,
        "mail_queue" => \Oriworks\NewsletterSystem\Nova\MailQueue::class,
    ],
    "notification-types" => [
        'NewsletterSignUp' => \App\Notifications\NewsletterSignUp::class,
        'NewsletterCancellation' => \App\Notifications\NewsletterCancellation::class,
        'WelcomeNewWebsite' => \App\Notifications\WelcomeNewWebsite::class,
        'Suggestion' => \App\Notifications\Suggestion::class,
        'Associate' => \App\Notifications\Associate::class,
    ],
    "system-mailable-types" => [],
    "mailable-types" => [
        "system_mail" => \Oriworks\NewsletterSystem\Nova\SystemMail::class,
        "newsletter" => \Oriworks\NewsletterSystem\Nova\Newsletter::class,
    ],
    "emailable-types" => [
        "email" => \Oriworks\NewsletterSystem\Nova\Email::class,
        "suggestion" => \App\Nova\Suggestion::class,
        "associate" => \App\Nova\Associate::class,
    ],
    "newsletterable-types" => [
        \App\Notifications\NewsletterNotice::class => \App\Nova\Notice::class,
        \App\Notifications\NewsletterFlyer::class => \App\Nova\Flyer::class,
        \App\Notifications\NewsletterInformation::class => \App\Nova\Information::class,
        \App\Notifications\NewsletterJournal::class => \App\Nova\Journal::class,
    ]
];
