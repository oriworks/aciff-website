<?php

namespace Database\Seeders;

use App\Models\Document;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $document = Document::create([
            'subject' => 'MATERIAIS PARA A HISTÓRIA DA FIGUEIRA NOS SÉCULOS XVII E XVIII de ANTÓNIO DOS SANTOS ROCHA',
            'content' => 'HISTÓRIA, TOPOGRAFIA E ETNOGRAFIA
            -2ªEDIÇÃO -
            com Prefácio do Prof. Doutor JOAQUIM DE CARVALHO (Sócio da Academia das Ciências de Lisboa)
            por ANTÓNIO DOS SANTOS ROCHA (Sócio de honra da Associação dos Arqueólogos e Sócio correspondente da Academia das Ciências de Lisboa)

            Figueira da Foz
            1954',
            'created_by' => '9a829953-bd3f-4314-aee3-c5cfd92d419c',
            'updated_by' => '9a829953-bd3f-4314-aee3-c5cfd92d419c',
        ]);

        // $document->addMedia('public/pdfs/RegulamentoInternodaAssFig1865.pdf')
        //     ->preservingOriginal()
        //     ->toMediaCollection('documents');
    }
}
