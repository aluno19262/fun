<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTrainingInstituteFieldsAssociateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('associates', function ($table) {
            $table->renameColumn('training_institute','training_institute_degree');
            $table->string('training_institute_master',255)->nullable()->after('training_institute');
            $table->string('training_institute_degree_other',255)->nullable()->after('training_institute_master');
            $table->string('training_institute_master_other',255)->nullable()->after('training_institute_degree_other');
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
            $table->renameColumn('training_institute_degree','training_institute');
            $table->dropColumn('training_institute_master');
            $table->dropColumn('training_institute_degree_other');
            $table->dropColumn('training_institute_master_other');
        });
    }
}
