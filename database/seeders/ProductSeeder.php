<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'name' => 'Quota 1 Semestre Efectivo',
                'price' => '55',
                'excerpt' => 'Quota para um semestre efectivo',
                'visible' => true,
                'tax' => 0,
                'moloni_category_id' => '3008381',
                'moloni_product_id' => '64079748',
                'moloni_tax_id' => '2052293',
            ],
            [
                'id' => 2,
                'name' => 'Quota 1 Ano Efectivo',
                'price' => '110',
                'excerpt' => 'Quota para um ano efectivo',
                'visible' => true,
                'tax' => 0,
                'moloni_category_id' => '3008381',
                'moloni_product_id' => '64079748',
                'moloni_tax_id' => '2052293',
            ],
            [
                'id' => 3,
                'name' => 'Jóia de Inscrição',
                'price' => '40',
                'excerpt' => 'Jóia de Inscrição',
                'visible' => true,
                'tax' => 0,
                'moloni_category_id' => '3008381',
                'moloni_product_id' => '64079813',
                'moloni_tax_id' => '2052293',
            ],
            [
                'id' => 4,
                'name' => 'Jóia de Inscrição Estudante',
                'price' => '5',
                'excerpt' => 'Jóia de Inscrição Estudante',
                'visible' => true,
                'tax' => 0,
                'moloni_category_id' => '3008381',
                'moloni_product_id' => '64079813',
                'moloni_tax_id' => '2052293',
            ],
            [
                'id' => 5,
                'name' => 'Remanescente da Jóia de Inscrição Estudante',
                'price' => '35',
                'excerpt' => 'Remanescente da Jóia de Inscrição Estudante',
                'visible' => true,
                'tax' => 0,
                'moloni_category_id' => '3008381',
                'moloni_product_id' => '64079813',
                'moloni_tax_id' => '2052293',
            ],
            [
                'id' => 6,
                'name' => 'Declaração',
                'price' => '12.5',
                'excerpt' => 'Declaração',
                'visible' => true,
                'tax' => 0,
                'moloni_category_id' => '3008381',
                'moloni_product_id' => '107932252',
                'moloni_tax_id' => '2052293',
            ],
            [
                'id' => 7,
                'name' => 'Quota 1 Semestre Aderente',
                'price' => '27.5',
                'excerpt' => 'Quota para um semestre aderente',
                'visible' => true,
                'tax' => 0,
                'moloni_category_id' => '3008381',
                'moloni_product_id' => '64079748',
                'moloni_tax_id' => '2052293',
            ],
            [
                'id' => 8,
                'name' => 'Quota 1 Ano Aderente',
                'price' => '55',
                'excerpt' => 'Quota para um ano aderente',
                'visible' => true,
                'tax' => 0,
                'moloni_category_id' => '3008381',
                'moloni_product_id' => '64079748',
                'moloni_tax_id' => '2052293',
            ],
        ]);
    }
}
