<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLocationFindApTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('find_aps', function (Blueprint $table) {
            $table->string('zip', 16)->nullable();
            $table->string('location', 128)->nullable();
        });

        Schema::table('declarations', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('find_aps', function (Blueprint $table) {
            $table->dropColumn('zip');
            $table->dropColumn('location');
        });
        Schema::table('declarations', function (Blueprint $table) {
            $table->dropColumn('order_id');
        });
    }
}
