<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRenovationDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('declarations', function ($table) {
            $table->boolean('is_renovation')->default(false)->after('declaration_number');
            $table->string('previous_declaration_number',32)->nullable()->after('is_renovation');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('declarations', function ($table) {
            $table->dropColumn('is_renovation');
            $table->dropColumn('previous_declaration_number');
        });
    }
}
