<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MoloniDevelopmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->where(['slug' => 'moloni_client_id'])->update(['value' => 'noopdeveloper']);
        DB::table('settings')->where(['slug' => 'moloni_email'])->update(['value' => 'hello@noop.pt']);
        DB::table('settings')->where(['slug' => 'moloni_client_secret'])->update(['value' => '610bbd121468fa2a3ef81ce5dae86302b0302773']);
        DB::table('settings')->where(['slug' => 'moloni_password'])->update(['value' => 'PmqTX8Uf']);
        DB::table('settings')->where(['slug' => 'moloni_company_id'])->update(['value' => '152862']);
        DB::table('settings')->where(['slug' => 'moloni_document_set_id'])->update(['value' => '324539']);
        DB::table('settings')->where(['slug' => 'moloni_23_tax_id'])->update(['value' => '2052293']);
        DB::table('settings')->where(['slug' => 'moloni_13_tax_id'])->update(['value' => '2052307']);
        DB::table('settings')->where(['slug' => 'moloni_6_tax_id'])->update(['value' => '2052300']);
        DB::table('settings')->where(['slug' => 'moloni_mb_payment_id'])->update(['value' => '1036474']);
        DB::table('settings')->where(['slug' => 'moloni_mbway_payment_id'])->update(['value' => '1037126']);
        DB::table('settings')->where(['slug' => 'moloni_dd_payment_id'])->update(['value' => '1037130']);
        DB::table('settings')->where(['slug' => 'moloni_wire_transfer_payment_id'])->update(['value' => '1036467']);
        DB::table('settings')->where(['slug' => 'moloni_money_payment_id'])->update(['value' => '1036467']);
        DB::table('settings')->where(['slug' => 'moloni_paypal_payment_id'])->update(['value' => '']);
        DB::table('settings')->where(['slug' => 'moloni_cc_payment_id'])->update(['value' => '']);

        DB::table('products')->where(['id' => '1'])->update([
            'tax' => 0,
            'moloni_category_id' => '3008381',
            'moloni_product_id' => '64079748',
            'moloni_tax_id' => '2052293',
        ]);

        DB::table('products')->where(['id' => '2'])->update([
            'tax' => 0,
            'moloni_category_id' => '3008381',
            'moloni_product_id' => '64079748',
            'moloni_tax_id' => '2052293',
        ]);

        DB::table('products')->where(['id' => '3'])->update([
            'tax' => 0,
            'moloni_category_id' => '3008381',
            'moloni_product_id' => '64079813',
            'moloni_tax_id' => '2052293',
        ]);

        DB::table('products')->where(['id' => '4'])->update([
            'tax' => 0,
            'moloni_category_id' => '3008381',
            'moloni_product_id' => '64079813',
            'moloni_tax_id' => '2052293',
        ]);

        DB::table('products')->where(['id' => '6'])->update([
            'tax' => 0,
            'moloni_category_id' => '3008381',
            'moloni_product_id' => '64079813',
            'moloni_tax_id' => '2052293',
        ]);

        DB::table('products')->where(['id' => '7'])->update([
            'tax' => 0,
            'moloni_category_id' => '3008381',
            'moloni_product_id' => '107932252',
            'moloni_tax_id' => '2052293',
        ]);

        DB::table('products')->where(['id' => '8'])->update([
            'tax' => 0,
            'moloni_category_id' => '3008381',
            'moloni_product_id' => '64079748',
            'moloni_tax_id' => '2052293',
        ]);

        DB::table('products')->where(['id' => '9'])->update([
            'tax' => 0,
            'moloni_category_id' => '3008381',
            'moloni_product_id' => '64079748',
            'moloni_tax_id' => '2052293',
        ]);

        Cache::forget('setting-params');
        Cache::forget('setting-options');
    }
}

