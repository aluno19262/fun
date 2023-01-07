<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAssociateNumberFieldType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associates', function ($table) {
            $table->string('associate_number')->change();
            $table->string('associate_delegation')->change();
            $table->string('notes')->nullable();
        });
        Schema::table('declarations', function ($table) {
            $table->date('valid_until')->nullable();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->string('moloni_category_id',32)->nullable();
            $table->string('moloni_product_id',32)->nullable();
            $table->string('moloni_tax_id',32)->nullable();
            $table->decimal('vat', 12, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('associates', function ($table) {
            $table->integer('associate_number')->change();
            $table->integer('associate_delegation')->change();
            $table->dropColumn('notes');
        });
        Schema::table('declarations', function ($table) {
            $table->dropColumn('valid_until');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('moloni_category_id');
            $table->dropColumn('moloni_product_id');
            $table->dropColumn('moloni_tax_id');;
            $table->dropColumn('vat');
        });
    }
}
