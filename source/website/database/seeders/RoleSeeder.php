<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Role::create(['name' => 'super-admin']);
        \App\Models\Role::create(['name' => 'aciff']);
        \App\Models\Role::create(['name' => 'admin-aciff']);
        \App\Models\Role::create(['name' => 'history']);
        \App\Models\Role::create(['name' => 'admin-history']);
    }
}
