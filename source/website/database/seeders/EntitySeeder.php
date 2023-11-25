<?php

namespace Database\Seeders;

use App\Models\Entity;
use Illuminate\Database\Seeder;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $entity = Entity::create([
            'name' => 'Associação Comercial e Industrial da Figueira da Foz',
            'friendly_name' => 'ACIFF',
            'facebook' => 'ACIFF',
            'twitter' => 'ACIFF_FigFoz',
        ]);
        $entity->addMedia('public/img/logo.png')
            ->preservingOriginal()
            ->toMediaCollection('logo');
    }
}
