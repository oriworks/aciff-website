<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = \App\Models\Role::where('name', 'super-admin')->first();
        $aciff = \App\Models\Role::where('name', 'aciff')->first();
        $adminAciff = \App\Models\Role::where('name', 'admin-aciff')->first();
        $history = \App\Models\Role::where('name', 'history')->first();
        $adminHistory = \App\Models\Role::where('name', 'admin-history')->first();

        \App\Models\User::factory()->create([
            'id' => '9a82111c-b8e3-4794-9b06-5c6cd5a91a79',
            'name' => 'Joel Oliveira',
            'email' => 'joeloliveira@oriworks.com',
            'password' => bcrypt('qwerty123')
        ])->assignRole($superAdmin);

        \App\Models\User::factory()->create([
            'name' => 'Sandra Rodrigues',
            'email' => 'aciff@aciff.pt',
            'password' => bcrypt('qwerty123')
        ])->assignRole($adminAciff);

        \App\Models\User::factory()->create([
            'id' => '9a894154-2251-45ac-9268-3270e3b269ab',
            'name' => 'Francisca',
            'email' => 'francisca@gmail.com',
            'password' => bcrypt('qwerty123')
        ])->assignRole($history);

        \App\Models\User::factory()->create([
            'id' => '9a829953-bd3f-4314-aee3-c5cfd92d419c',
            'name' => 'Fernando Cardoso',
            'email' => 'fernando.cardoso@gmail.com',
            'password' => bcrypt('qwerty123')
        ])->assignRole($adminHistory);
    }
}
