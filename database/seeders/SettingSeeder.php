<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('settings')->where('name','Email da plataforma')->exists()) {
            DB::table('settings')->insert([
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'main',
                    'name' => 'Email da plataforma',
                    'slug' => "email",
                    'options' => null,
                    'value' => 'apoio.tecnico@apap.pt',
                    'order' => 0,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'main',
                    'name' => 'Email de suporte',
                    'slug' => "email_suporte",
                    'options' => null,
                    'value' => 'geral@noop.pt',
                    'order' => 0,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'main',
                    'name' => 'Privacy Policy Link',
                    'slug' => "privacy_policy_link",
                    'options' => null,
                    'value' => 'https://apap.pt/politica-de-privacidade/',
                    'order' => 0,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'main',
                    'name' => 'Enviar Emails para Administrativas',
                    'slug' => "send_staff_mails",
                    'options' => null,
                    'value' => false,
                    'order' => 0,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
            ]);
        }
        if(!DB::table('settings')->where('slug','moloni_client_id')->exists()) {
            DB::table('settings')->insert([
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Client ID no Moloni',
                    'slug' => "moloni_client_id",
                    'options' => "",
                    'value' => 'noopdeveloper',
                    'order' => 25,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Email no Moloni',
                    'slug' => "moloni_email",
                    'options' => "",
                    'value' => 'hello@noop.pt',
                    'order' => 30,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Client Secret no Moloni',
                    'slug' => "moloni_client_secret",
                    'options' => "",
                    'value' => '610bbd121468fa2a3ef81ce5dae86302b0302773',
                    'order' => 35,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Password no Moloni',
                    'slug' => "moloni_password",
                    'options' => "",
                    'value' => 'PmqTX8Uf',
                    'order' => 40,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Company ID no Moloni',
                    'slug' => "moloni_company_id",
                    'options' => "",
                    'value' => '152862',
                    'order' => 45,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Document Set ID no Moloni',
                    'slug' => "moloni_document_set_id",
                    'options' => "",
                    'value' => '324539',
                    'order' => 50,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'IVA 23% no Moloni',
                    'slug' => "moloni_23_tax_id",
                    'options' => "",
                    'value' => '2052293',
                    'order' => 55,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'IVA 13% no Moloni',
                    'slug' => "moloni_13_tax_id",
                    'options' => "",
                    'value' => '2052307',
                    'order' => 60,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'IVA 6% no Moloni',
                    'slug' => "moloni_6_tax_id",
                    'options' => "",
                    'value' => '2052300',
                    'order' => 65,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Multibanco Payment ID no Moloni',
                    'slug' => "moloni_mb_payment_id",
                    'options' => "",
                    'value' => '1036474',
                    'order' => 85,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'MBWay Payment ID no Moloni',
                    'slug' => "moloni_mbway_payment_id",
                    'options' => "",
                    'value' => '1037126',
                    'order' => 90,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Débito Directo Payment ID no Moloni',
                    'slug' => "moloni_dd_payment_id",
                    'options' => "",
                    'value' => '1037130',
                    'order' => 95,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Transferência bancária Payment ID no Moloni',
                    'slug' => "moloni_wire_transfer_payment_id",
                    'options' => "",
                    'value' => '1036467',
                    'order' => 100,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Dinheiro Payment ID no Moloni',
                    'slug' => "moloni_money_payment_id",
                    'options' => "",
                    'value' => '',
                    'order' => 105,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Paypal Payment ID no Moloni',
                    'slug' => "moloni_paypal_payment_id",
                    'options' => "",
                    'value' => '',
                    'order' => 110,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Cartão de crédito Payment ID no Moloni',
                    'slug' => "moloni_cc_payment_id",
                    'options' => "",
                    'value' => '',
                    'order' => 115,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                /*[
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Category ID',
                    'slug' => "moloni_category_id",
                    'options' => "",
                    'value' => '3008381',
                    'order' => 120,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],
                [
                    'type' => Setting::TYPE_TEXTFIELD,
                    'group' => 'moloni',
                    'name' => 'Moloni Product ID',
                    'slug' => "moloni_product_id",
                    'options' => "",
                    'value' => '94529135',
                    'order' => 120,
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ],*/
            ]);
        }
    }
}
