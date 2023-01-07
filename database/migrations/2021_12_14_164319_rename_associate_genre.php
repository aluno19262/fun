<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameAssociateGenre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associates', function ($table) {
            $table->renameColumn('genre','gender');
            $table->string('cc_number',32);
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
            $table->renameColumn('gender','genre');
            $table->dropColumn('cc_number');
        });
    }
}
