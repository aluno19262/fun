<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InitialTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies',function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email',128)->nullable();
            $table->string('address',512)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('zip', 16)->nullable();
            $table->string('location', 128)->nullable();
            $table->string('parish', 128)->nullable();
            $table->string('municipality', 128)->nullable();
            $table->string('district', 128)->nullable();
            $table->string('country', 128)->nullable();
            $table->string('vat',32)->nullable();
            $table->smallInteger('status')->nullable()->default(1)->comment('0 - inactive | 1 - active');
            $table->timestamps();
        });

        Schema::create('find_aps',function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email',128)->nullable();
            $table->string('address',512)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('latitude',64)->nullable();
            $table->string('longitude',64)->nullable();
            $table->smallInteger('status')->nullable()->default(1)->comment('0 - inactive | 1 - active');
            $table->timestamps();
        });


        Schema::create('associates',function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('find_ap_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('associate_number')->nullable();
            $table->smallInteger('category')->comment('0 - Associado Efetivo | 1 - Associado Aderente | 2 - Associado Estudante | 3 - Membro Honorário');
            $table->string('name');
            $table->string('email',128)->nullable();
            $table->string('phone1',32)->nullable();
            $table->string('phone2',32)->nullable();
            $table->string('vat',32)->nullable();
            $table->smallInteger('genre')->comment('0 - Male | 1 - Female | 2 - Other')->nullable();
            $table->string('address',512)->nullable();
            $table->string('zip', 16)->nullable();
            $table->string('location', 128)->nullable();
            $table->string('parish', 128)->nullable();
            $table->string('municipality', 128)->nullable();
            $table->string('district', 128)->nullable();
            $table->string('country', 128)->nullable();
            $table->smallInteger('associate_delegation')->nullable()->comment(' 1 - Distritos do Alto Douro | 2 - Distrito do Porto | 3 - Distritos do Centro | 4 - Distritos do Alentejo | 5 - Distritos de Faro | 6 - Madeira | 7 - Açores | 8 - Sede');
            $table->date('birthday')->nullable();
            //$table->date('transmit_date')->nullable();
            $table->date('registration_date')->nullable();
            $table->boolean('gdpr_compliant')->default(false);
            $table->boolean('find_ap_enable')->default(false);
            $table->string('training_institute')->nullable();
            $table->date('quota_valid_until')->nullable();
            $table->boolean('newsletter')->default(false);
            $table->smallInteger('preferential_contact')->nullable()->default(0)->comment('0 - personal email | 1 - company email');
            $table->smallInteger('status')->nullable()->default(1)->comment('0 - inactive | 1 - incomplete_data | 2 - wainting approval | 3 - active | 4 - dead');
            //$table->smallInteger('status')->nullable()->default(1)->comment('0 - inactive | 1 - active | 2 - dead');
            $table->timestamps();
        });

        Schema::create('declaration_templates',function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('order');
            $table->smallInteger('status')->nullable()->default(1)->comment('0 - inactive | 1 - active');
            $table->timestamps();
        });
        Schema::create('declaration_template_questions',function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_template_id')->nullable()->constrained()->onDelete('set null');
            $table->smallInteger('type')->nullable()->default(1)->comment('1 - textfield | 2 - textarea | 3 - checkbox | 4 - select | 5 - integer | 6 - decimal | 7 - currency | 8 - percentage | 9 - color | 10 - range | 11 - json_array');
            $table->string('question');
            $table->string('code');
            $table->text('data');
            $table->smallInteger('status')->nullable()->default(1)->comment('0 - inactive | 1 - active');
            $table->timestamps();
        });

        Schema::create('declarations',function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_template_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('associate_id')->nullable()->constrained()->onDelete('set null');
            $table->string('value')->nullable();
            $table->string('declaration_number')->nullable();
            $table->smallInteger('status')->nullable()->default(2)->comment('0 - inactive | 1 - active | 2 - Waiting Approval');
            $table->timestamps();
        });

        Schema::create('declaration_questions',function (Blueprint $table) {
            $table->id();
            $table->foreignId('declaration_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('declaration_template_question_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('declaration_number')->nullable();
            $table->string('value')->nullable();
            $table->smallInteger('status')->nullable()->default(1)->comment('0 - inactive | 1 - active');
            $table->timestamp('emited_at')->nullable();
            $table->timestamps();
        });

        Schema::create('quotas',function (Blueprint $table) {
            $table->id();
            $table->foreignId('associate_id')->constrained()->onDelete('cascade');
            $table->year('year');
            $table->smallInteger('semester');
            $table->date('payment_limit_date')->nullable();
            $table->decimal('price');
            $table->smallInteger('status')->nullable()->default(1)->comment('0 - inactive | 1 - active');
            $table->timestamps();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price',12,2);
            $table->decimal('reduced_price',12,2)->nullable();
            $table->string('description')->nullable();
            $table->string('excerpt')->nullable();
            $table->string('notes')->nullable();
            $table->boolean('visible')->default(true);
            $table->decimal('tax')->nullable()->default(23);
            $table->smallInteger('status')->default(1)->comment('0 - disable | 1 - active | 2 - available | 3 - out of stock ')->index();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('associate_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('address',512)->nullable();
            $table->string('zip', 16)->nullable();
            $table->string('location', 128)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('vat',32)->nullable();
            $table->string('coupon',64)->nullable();
            $table->decimal('discount',12,2)->nullable()->default(0);
            $table->decimal('subtotal',12,2);
            $table->decimal('total',12,2);
            $table->decimal('vat_value',12,2);
            $table->dateTime('delivery_date')->nullable();
            $table->string('notes',512)->nullable();
            $table->smallInteger('payment_method')->dafault(0)->comment('0 - unselected | 1 - Ref MB | 2 - MBWAY | 3 - direct debit | 4 - Wire transfer | 5 - money');
            $table->string('mb_ent',5)->nullable();
            $table->string('mb_ref',9)->nullable();
            $table->date('mb_limit_date')->nullable()->default(NULL);
            $table->string('mbway_ref',25)->nullable();
            $table->string('mbway_alias',32)->nullable();
            $table->string('payment_ref',64)->nullable()->comment("Other payment reference");
            $table->string('invoice_id',64)->nullable();
            $table->string('invoice_link')->nullable();
            $table->date('payment_limit_date')->nullable()->default(NULL);
            $table->smallInteger('invoice_status')->nullable(false)->default(0)->comment('0 - waiting emission | 1 - draft | 2 - final | 3 - canceled');
            $table->smallInteger('status')->default(1)->comment('0 - canceled | 1 - waiting payment | 2 - payed');
            $table->timestamps();
        });
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('associate_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('declaration_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('quota_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->string('cookie',128)->nullable();
            $table->string('name');
            $table->integer('quantity')->default(1);
            $table->decimal('price',12,2);
            $table->string('notes')->nullable();
            $table->decimal('vat',12,2);
            $table->text('raw_data')->nullable();
            $table->smallInteger('status')->default(3)->comment('0 - canceled | 1 - waiting payment | 2 - payed');
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
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
        Schema::dropIfExists('quotas');
        Schema::dropIfExists('declarations');
        Schema::dropIfExists('declaration_questions');
        Schema::dropIfExists('declaration_template_questions');
        Schema::dropIfExists('declaration_templates');
        Schema::dropIfExists('associates');
        Schema::dropIfExists('find_aps');
        Schema::dropIfExists('companies');
    }
}
