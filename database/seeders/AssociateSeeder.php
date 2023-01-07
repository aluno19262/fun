<?php

namespace Database\Seeders;

use App\Models\Associate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssociateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('associates')->insert([
            [
                'id' => 1,
                'user_id' => 4,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'João Ceregeiro',
                'email' => 'joao@ceregeiro.com',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 2,
                'user_id' => 5,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'Paula Simões',
                'email' => 'pmss@uevora.pt',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 3,
                'user_id' => 6,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'Carlos Correia Dias',
                'email' => 'ccd@lodo.pt',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 4,
                'user_id' => 7,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'Paula Farrajota',
                'email' => 'pfarrajota@ualg.pt',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 5,
                'user_id' => 8,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'David Flores',
                'email' => 'davidflores@biodesign.pt',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 6,
                'user_id' => 9,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'Jorge Cancela',
                'email' => 'cancela.jorge@gmail.com',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 7,
                'user_id' => 10,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'Carlos Ribas',
                'email' => 'carlos.ribas.lx@gmail.com',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 8,
                'user_id' => 11,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'Catarina Dias',
                'email' => 'cd7568@yahoo.com',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
            [
                'id' => 9,
                'user_id' => 12,
                'category' => Associate::CATEGORY_ASSOCIADO_EFETIVO,
                'name' => 'Teresa Portela Marques',
                'email' => 'teresamarques@fc.up.pt',
                'gdpr_compliant' => true,
                'gdpr_newsletter' => true,
                'status' => Associate::STATUS_ACTIVE,
                'find_ap_enable' => false,
                'newsletter' => false,
                'is_simple_process' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ],
        ]);
    }
}
