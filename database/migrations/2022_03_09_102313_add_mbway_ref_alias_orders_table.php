<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMbwayRefAliasOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function ($table) {
            $table->string('mbway_ref_half',25)->nullable()->after('mbway_alias');
            $table->string('mbway_alias_half',32)->nullable()->after('mbway_ref_half');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn('mbway_ref_half');
            $table->dropColumn('mbway_alias_half');
        });
    }
}
