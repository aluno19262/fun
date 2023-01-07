<?php

namespace Database\Seeders;

use App\Models\DeclarationTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeclarationTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('declaration_templates')->insert([
            [
                'id' => 1,
                'name' => 'Declaração Alvará',
                'order' => 1,
                'value' => 12.5,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 2,
                'name' => 'Declaração Projecto',
                'order' => 2,
                'value' => 12.5,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 3,
                'name' => 'Declaração Concurso/Projecto (Alemão)',
                'order' => 5,
                'value' => 12.5,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 4,
                'name' => 'Declaração Concurso/Projecto (Espanhol)',
                'order' => 6,
                'value' => 12.5,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 5,
                'name' => 'Declaração Concurso/Projecto (Francês)',
                'order' => 7,
                'value' => 12.5,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 6,
                'name' => 'Declaração Concurso/Projecto (Inglês)',
                'order' => 8,
                'value' => 12.5,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 7,
                'name' => 'Declaração Concurso/Projecto (Italiano)',
                'order' => 9,
                'value' => 12.5,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 8,
                'name' => 'Declaração Seguro',
                'order' => 3,
                'value' => 0,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 9,
                'name' => 'Declaração Concurso',
                'order' => 4,
                'value' => 12.5,
                'status' => 1,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

        ]);
        if(DeclarationTemplate::where('id',1)->exists()){
            DeclarationTemplate::where('id',1)->first()->addMedia('public/demo1/media/declarations/DeclaracaoAlvara2022.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }
        if(DeclarationTemplate::where('id',2)->exists()){
            DeclarationTemplate::where('id',2)->first()->addMedia('public/demo1/media/declarations/DeclaracaoProjecto2022.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }
        if(DeclarationTemplate::where('id',3)->exists()){
            DeclarationTemplate::where('id',3)->first()->addMedia('public/demo1/media/declarations/DeclaracaoProjectoAlemao2021.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }
        if(DeclarationTemplate::where('id',4)->exists()){
            DeclarationTemplate::where('id',4)->first()->addMedia('public/demo1/media/declarations/DeclaracaoProjectoEspanhol2021.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }
        if(DeclarationTemplate::where('id',5)->exists()){
            DeclarationTemplate::where('id',5)->first()->addMedia('public/demo1/media/declarations/DeclaracaoProjectoFrances2021.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }
        if(DeclarationTemplate::where('id',6)->exists()){
            DeclarationTemplate::where('id',6)->first()->addMedia('public/demo1/media/declarations/DeclaracaoProjectoIngles2021.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }
        if(DeclarationTemplate::where('id',7)->exists()){
            DeclarationTemplate::where('id',7)->first()->addMedia('public/demo1/media/declarations/DeclaracaoProjectoItaliano2021.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }
        if(DeclarationTemplate::where('id',8)->exists()){
            DeclarationTemplate::where('id',8)->first()->addMedia('public/demo1/media/declarations/DeclaracaoSeguro2022.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }
        if(DeclarationTemplate::where('id',9)->exists()){
            DeclarationTemplate::where('id',9)->first()->addMedia('public/demo1/media/declarations/DeclaracaoConcurso2022.docx')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }

        /*foreach(DeclarationTemplate::all() as $declarationTemplate){
            $declarationTemplate->addMedia('public/demo1/media/declarations/sample.pdf')->preservingOriginal()->toMediaCollection('declaration_template_document');
        }*/
    }
}
