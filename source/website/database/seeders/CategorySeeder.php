<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $historyFig = \App\Models\Category::create([
            'name' => 'Histórias da Figueira da Foz',
            'sort_order' => 1
        ]);

        $history = \App\Models\Category::create([
            'name' => 'Histórias',
            'sort_order' => 2
        ]);
        $history->parent()->associate($historyFig);
        $history->save();

        $docs = \App\Models\Category::create([
            'name' => 'Documentos',
            'sort_order' => 3
        ]);
        $docs->parent()->associate($historyFig);
        $docs->save();

        $categoryR = \App\Models\Category::create([
            'name' => 'Rio, Porto e Barra',
            'sort_order' => 4
        ]);

        $categoryRiver = \App\Models\Category::create([
            'name' => 'Rio',
            'sort_order' => 5
        ]);

        $categoryRiver->parent()->associate($categoryR);
        $categoryRiver->save();

        $categoryPort = \App\Models\Category::create([
            'name' => 'Porto e Barra',
            'sort_order' => 6
        ]);

        $categoryPort->parent()->associate($categoryR);
        $categoryPort->save();

        \App\Models\Category::create([
            'name' => 'Misericórdia Obra da Figueira',
            'sort_order' => 7
        ]);

        \App\Models\Category::create([
            'name' => 'Assembleia Figueirense',
            'sort_order' => 8
        ]);

        $categoryA = \App\Models\Category::create([
            'name' => 'Revistas e Artigos Históricos e Literários',
            'sort_order' => 9
        ]);

        $categoryRev = \App\Models\Category::create([
            'name' => 'Revistas da Figueira',
            'sort_order' => 10
        ]);

        $categoryRev->parent()->associate($categoryA);
        $categoryRev->save();

        $categoryStudium = \App\Models\Category::create([
            'name' => 'Revista Studium',
            'sort_order' => 11
        ]);

        $categoryStudium->parent()->associate($categoryA);
        $categoryStudium->save();

        $categoryAlbum = \App\Models\Category::create([
            'name' => 'Album Figueirense',
            'sort_order' => 12
        ]);

        $categoryAlbum->parent()->associate($categoryA);
        $categoryAlbum->save();
    }
}
