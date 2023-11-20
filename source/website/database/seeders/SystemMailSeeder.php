<?php

namespace Database\Seeders;

use App\Models\SystemMail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemMailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemMail::create([
            'notification_type' => config('newsletter-system.notification-types.NewsletterSignUp')
        ]);
        SystemMail::create([
            'notification_type' => config('newsletter-system.notification-types.NewsletterCancellation')
        ]);
        SystemMail::create([
            'notification_type' => config('newsletter-system.notification-types.WelcomeNewWebsite')
        ]);
    }
}
