<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            \Database\Seeders\RoleSeeder::class,
            \Database\Seeders\PermissionSeeder::class,
            \Database\Seeders\UserSeeder::class,
            \Database\Seeders\CategorySeeder::class,
            \Database\Seeders\DocumentSeeder::class,
            \Database\Seeders\EntitySeeder::class,
            \Database\Seeders\MailingListSeeder::class,
            \Database\Seeders\SystemMailSeeder::class,
            \Database\Seeders\DepartmentSeeder::class,
            \Database\Seeders\NewsletterSeeder::class,
        ]);
    }
}
