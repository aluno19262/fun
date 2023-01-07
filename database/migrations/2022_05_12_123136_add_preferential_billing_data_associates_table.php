<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPreferentialBillingDataAssociatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associates', function ($table) {
            $table->smallInteger('preferential_billing_quotas')->nullable()->default(1)->after('preferential_contact');
            $table->smallInteger('preferential_billing_declarations')->nullable()->default(1)->after('preferential_billing_quotas');
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
            $table->dropColumn('preferential_billing_quotas');
            $table->dropColumn('preferential_billing_declarations');
        });
    }
}
