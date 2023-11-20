<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Entity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Associação Comercial e Industrial da Figueira da Foz',
            'friendly_name' => 'ACIFF',
            'address' => 'Largo Professor Victor Guerra, nº3',
            'zip_code' => '3080-072',
            'locality' => 'Figueira da Foz',
            'phone' => '233 401 320',
            'fax' => '233 420 555',
            'website' => 'aciff.pt',
            'emails' => ['aciff@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Direção ACIFF',
            'emails' => ['direccao@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Gabinete Empresa',
            'emails' => ['geaciff@aciff.pt', 'atendimento@aciff.pt', 'info.empresas@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Gabinete Higiene Alimentar',
            'emails' => ['hst.alimentar@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Centro Qualifica ACIFF',
            'emails' => ['qualifica@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Departamento Financeiro',
            'emails' => ['financeiro@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Dinamização Empresarial',
            'emails' => ['aciff.eventos@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Formação Modular',
            'emails' => ['formacao.fm@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Gabinete Formação',
            'emails' => ['formacao@aciff.pt'],
        ]);
        Department::create([
            'entity_id' => Entity::firstOrFail()->id,
            'name' => 'Gabinete Segurança e Saúde no Trabalho',
            'emails' => ['hst@aciff.pt', 'hst.a@aciff.pt', 'atendimento@aciff.pt'],
        ]);
    }
}
