<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEvaluationNotePhase1AssociateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associates', function (Blueprint $table) {
            $table->text('evaluation_note_phase_3')->nullable();
            $table->smallInteger('evaluation_phase_3_status')->nullable()->comment('0 - Rejected | 1 - Accepted');
            $table->smallInteger('evaluation_phase_2_status')->nullable()->comment('0 - Rejected | 1 - Accepted');
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
            $table->dropColumn('evaluation_note_phase_3');
            $table->dropColumn('evaluation_phase_3_status');
            $table->dropColumn('evaluation_phase_2_status');
        });
    }
}
