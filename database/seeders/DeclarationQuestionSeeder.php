<?php

namespace Database\Seeders;

use App\Models\DeclarationTemplateQuestion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeclarationQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('declaration_template_questions')->insert([
            //declaração alvará
            [
                'declaration_template_id' => 1,
                'question' => 'Nome da empresa',
                'code' => 'DeclarationCompanyName',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 1,
                'question' => 'NIPC da empresa',
                'code' => 'DeclarationCompanyFiscalNumber',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            //declaração projeto
            [
                'declaration_template_id' => 2,
                'question' => 'Designação do projeto',
                'code' => 'ProjectName',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 2,
                'question' => 'Localização do projeto',
                'code' => 'ProjectLocation',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 2,
                'question' => 'Requerente do projeto',
                'code' => 'ProjectApplicant',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            //declaração de concurso
            [
                'declaration_template_id' => 9,
                'question' => 'Designação do Concurso',
                'code' => 'ProjectName',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 9,
                'question' => 'Requerente',
                'code' => 'ProjectApplicant',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            //declaração projeto alemão
            [
                'declaration_template_id' => 3,
                'question' => 'Designação do projeto',
                'code' => 'ProjectName',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 3,
                'question' => 'Localização do projeto',
                'code' => 'ProjectLocation',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 3,
                'question' => 'Requerente do projeto',
                'code' => 'ProjectApplicant',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            //declaração projeto espanhol
            [
                'declaration_template_id' => 4,
                'question' => 'Designação do projeto',
                'code' => 'ProjectName',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 4,
                'question' => 'Localização do projeto',
                'code' => 'ProjectLocation',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 4,
                'question' => 'Requerente do projeto',
                'code' => 'ProjectApplicant',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            //declaração projeto francês
            [
                'declaration_template_id' => 5,
                'question' => 'Designação do projeto',
                'code' => 'ProjectName',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 5,
                'question' => 'Localização do projeto',
                'code' => 'ProjectLocation',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 5,
                'question' => 'Requerente do projeto',
                'code' => 'ProjectApplicant',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            //declaração projeto inglês
            [
                'declaration_template_id' => 6,
                'question' => 'Designação do projeto',
                'code' => 'ProjectName',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 6,
                'question' => 'Localização do projeto',
                'code' => 'ProjectLocation',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 6,
                'question' => 'Requerente do projeto',
                'code' => 'ProjectApplicant',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

            //declaração projeto italiano
            [
                'declaration_template_id' => 7,
                'question' => 'Designação do projeto',
                'code' => 'ProjectName',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 7,
                'question' => 'Localização do projeto',
                'code' => 'ProjectLocation',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'declaration_template_id' => 7,
                'question' => 'Requerente do projeto',
                'code' => 'ProjectApplicant',
                'status' => 1,
                'data' => '',
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],

        ]);
    }
}
