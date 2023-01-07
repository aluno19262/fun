<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts',function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('associate_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email');
            $table->string('phone',32)->nullable();
            $table->string('subject',512)->nullable();
            $table->tinyInteger('type')->comment(' 1 - other | 2 - quotas | 3 - declarations | 4 - suspension');
            $table->text('message');
            $table->dateTime('read_at')->nullable();
            $table->smallInteger('status')->nullable()->default(0)->comment('0 - unresolved | 1 - resolved');
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
        Schema::dropIfExists('contacts');
    }
}
