<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MoloniProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->where(['slug' => 'moloni_client_id'])->update(['value' => 'associaoportuguesadosarquitectospaisagistas']);
        DB::table('settings')->where(['slug' => 'moloni_email'])->update(['value' => 'apoio.administrativo@apap.pt']);
        DB::table('settings')->where(['slug' => 'moloni_client_secret'])->update(['value' => 'd7aec2172cdf2e48d2abb301eb48e204260ede89']);
        DB::table('settings')->where(['slug' => 'moloni_password'])->update(['value' => 'Paisagem1']);
        DB::table('settings')->where(['slug' => 'moloni_company_id'])->update(['value' => '190396']);
        DB::table('settings')->where(['slug' => 'moloni_document_set_id'])->update(['value' => '420369']);
        DB::table('settings')->where(['slug' => 'moloni_23_tax_id'])->update(['value' => '2246382']);
        DB::table('settings')->where(['slug' => 'moloni_13_tax_id'])->update(['value' => '2246396']);
        DB::table('settings')->where(['slug' => 'moloni_6_tax_id'])->update(['value' => '2246389']);
        DB::table('settings')->where(['slug' => 'moloni_mb_payment_id'])->update(['value' => '1337852']);
        DB::table('settings')->where(['slug' => 'moloni_mbway_payment_id'])->update(['value' => '1574289']);
        DB::table('settings')->where(['slug' => 'moloni_dd_payment_id'])->update(['value' => '']);
        DB::table('settings')->where(['slug' => 'moloni_wire_transfer_payment_id'])->update(['value' => '1337845']);
        DB::table('settings')->where(['slug' => 'moloni_money_payment_id'])->update(['value' => '1337831']);
        DB::table('settings')->where(['slug' => 'moloni_paypal_payment_id'])->update(['value' => '']);
        DB::table('settings')->where(['slug' => 'moloni_cc_payment_id'])->update(['value' => '']);

        DB::table('products')->where(['id' => '1'])->update([
            'tax' => 0,
            'moloni_category_id' => '5017850',
            'moloni_product_id' => '113252729',
            'moloni_tax_id' => '2330030'
        ]);

        DB::table('products')->where(['id' => '2'])->update([
            'tax' => 0,
            'moloni_category_id' => '5017850',
            'moloni_product_id' => '113253131',
            'moloni_tax_id' => '2330030'
        ]);

        DB::table('products')->where(['id' => '3'])->update([
            'tax' => 0,
            'moloni_category_id' => '5017850',
            'moloni_product_id' => '113253240',
            'moloni_tax_id' => '2330030'
        ]);

        DB::table('products')->where(['id' => '4'])->update([
            'tax' => 0,
            'moloni_category_id' => '5017850',
            'moloni_product_id' => '113253294',
            'moloni_tax_id' => '2330030'
        ]);

        DB::table('products')->where(['id' => '6'])->update([
            'tax' => 0,
            'moloni_category_id' => '',
            'moloni_product_id' => '',
            'moloni_tax_id' => ''
        ]);

        DB::table('products')->where(['id' => '7'])->update([
            'tax' => 0,
            'moloni_category_id' => '5017850',
            'moloni_product_id' => '113253475',
            'moloni_tax_id' => '2330030'
        ]);

        DB::table('products')->where(['id' => '8'])->update([
            'tax' => 0,
            'moloni_category_id' => '5017850',
            'moloni_product_id' => '113253585',
            'moloni_tax_id' => '2330030'
        ]);

        DB::table('products')->where(['id' => '9'])->update([
            'tax' => 0,
            'moloni_category_id' => '5017850',
            'moloni_product_id' => '113253634',
            'moloni_tax_id' => '2330030'
        ]);

        Cache::forget('setting-params');
        Cache::forget('setting-options');
    }
}
