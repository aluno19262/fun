<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSpecialtyAreaFindAp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('find_ap_specialty_areas',function (Blueprint $table) {
            $table->id();
            $table->foreignId('find_ap_id')->constrained()->onDelete('Cascade');
            $table->smallInteger('specialty_area')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('find_ap_specialty_areas');
    }
}
