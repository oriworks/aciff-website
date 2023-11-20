<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Oriworks\NewsletterSystem\Models\Sender;

class NewsletterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sender::create([
            'name' => 'ACIFF',
            'email' => 'noreply@aciff.pt',
            'signature' => '<div>Com cumprimentos,<br>Da equipa ACIFF</div>',
        ]);
    }
}
