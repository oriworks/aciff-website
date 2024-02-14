<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Oriworks\NewsletterSystem\Models\Email;

class CreateWelcomeEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:welcome-email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Welcome Email for all emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating Welcome Email');

        Email::all()->each(function ($email) {
            $modelSystemMail = config('newsletter-system.models.system_mail');
                (new $modelSystemMail)->firstOrCreate(['notification_type' => config('newsletter-system.notification-types.WelcomeNewWebsite')])
                    ->emails()
                    ->attach($email, ['priority' => 10, 'retry' => 0, 'mailable_type' => config('newsletter-system.models.system_mail')]);
        });
    }
}
