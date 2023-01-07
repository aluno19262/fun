<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGdprNewsletterFieldAssociateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associates', function ($table) {
            $table->boolean('gdpr_newsletter')->default(false)->after('gdpr_compliant');
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
            $table->dropColumn('gdpr_newsletter');
        });
    }
}
