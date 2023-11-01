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
        $superAdmin = \App\Models\Role::create(['name' => 'super-admin']);
        $aciff = \App\Models\Role::create(['name' => 'aciff']);
        $adminAciff = \App\Models\Role::create(['name' => 'admin-aciff']);
        $history = \App\Models\Role::create(['name' => 'history']);
        $adminHistory = \App\Models\Role::create(['name' => 'admin-history']);

        \App\Models\Permission::create(['name' => 'users']);
        \App\Models\Permission::create(['name' => 'roles']);
        \App\Models\Permission::create(['name' => 'permissions']);

        $superAdmin->givePermissionTo(\App\Models\Permission::all());

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
