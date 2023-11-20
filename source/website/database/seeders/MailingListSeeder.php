<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Oriworks\NewsletterSystem\Models\MailingList;

class MailingListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MailingList::create([
            'name' => 'Todos',
            'description' => 'Todos os emails registados no sistema'
        ]);
        MailingList::create([
            'name' => 'Departamentos',
            'description' => 'Emails internos'
        ]);
    }
}
