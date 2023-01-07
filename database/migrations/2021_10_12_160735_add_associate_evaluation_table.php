<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAssociateEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associate_evaluations',function (Blueprint $table) {
            $table->id();
            $table->foreignId('associate_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->smallInteger('phase')->nullable()->default(1)->comment('1 - Phase 1 | 2 - Phase 2');
            $table->text('note')->nullable();
            $table->smallInteger('status')->nullable()->default(1)->comment('0 - Rejected | 1 - Accepted');
            $table->timestamps();
        });

        Schema::table('associates', function (Blueprint $table) {
            $table->smallInteger('quota_interval')->nullable()->default(1)->comment('1 - Annual | 2 - Biannual');
            $table->text('evaluation_note')->nullable();
            $table->timestamp('evaluation_phase_1_at')->nullable();
            $table->timestamp('evaluation_phase_2_at')->nullable();
            $table->timestamp('evaluation_phase_3_at')->nullable();
            //$table->foreignId('evaluation_phase_1_user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreignId('evaluation_phase_2_user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreignId('evaluation_phase_3_user_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreignId('evaluation_order_id')->nullable()->references('id')->on('orders')->onDelete('set null');
            $table->decimal('inscription_fee_payed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('associates', function (Blueprint $table) {
            $table->dropColumn('quota_interval');
            $table->dropColumn('evaluation_note');
            $table->dropColumn('evaluation_phase_1_at');
            $table->dropColumn('evaluation_phase_2_at');
            $table->dropColumn('evaluation_phase_3_at');
            //$table->dropColumn('evaluation_phase_1_user_id');
            $table->dropColumn('evaluation_phase_2_user_id');
            $table->dropColumn('evaluation_order_id');
            $table->dropColumn('inscription_fee_payed');
        });
        Schema::dropIfExists('associate_evaluations');
    }
}
