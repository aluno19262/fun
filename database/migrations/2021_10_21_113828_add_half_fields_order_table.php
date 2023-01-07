<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHalfFieldsOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('subtotal_half',12,2)->nullable()->after('vat_value');
            $table->decimal('total_half',12,2)->nullable()->after('subtotal_half');
            $table->decimal('vat_value_half',12,2)->nullable()->after('total_half');
            $table->string('mb_ent_half',5)->nullable()->after('mb_limit_date');;
            $table->string('mb_ref_half',9)->nullable()->after('mb_ent_half');;
            $table->date('mb_limit_date_half')->nullable()->default(NULL)->after('mb_ref_half');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('subtotal_half');
            $table->dropColumn('total_half');
            $table->dropColumn('vat_value_half');
            $table->dropColumn('mb_ent_half');
            $table->dropColumn('mb_ref_half');
            $table->dropColumn('mb_limit_date_half');
        });
    }
}
