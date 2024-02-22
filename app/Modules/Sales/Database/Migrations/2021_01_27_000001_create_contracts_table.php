<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->enum('type_dcustomer', ['commerce', 'multicommerce', 'nodom']);
            $table->unsignedBigInteger('dcustomer_id');
            $table->string('dcustomer_multiple')->nullable();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('modelterminal_id');
            $table->unsignedBigInteger('terminal_id')->nullable();
            $table->boolean('valid_simcard')->nullable();
            $table->unsignedBigInteger('operator_id')->nullable();
            $table->unsignedBigInteger('simcard_id')->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->integer('nropos')->nullable();
            $table->string('observation', 191)->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->longText('file_document')->nullable(); //consecutivo de recibo
            $table->enum('status', ['Activo', 'Pendiente', 'Soporte', 'Suspendido', 'Cancelado', 'Anulado']);
            $table->datetime('reactive_date')->nullable(); //fecha
            $table->unsignedBigInteger('consultant_id')->nullable();
            $table->boolean('is_delivery')->nullable();
            $table->datetime('delivery_date')->nullable();
            $table->boolean('is_affiliate')->nullable();
            $table->datetime('affiliate_date')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_posted_id')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('dcustomer_id')->references('id')->on('dcustomers');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('modelterminal_id')->references('id')->on('modelterminal');
            $table->foreign('terminal_id')->references('id')->on('terminals');
            $table->foreign('operator_id')->references('id')->on('operators');
            $table->foreign('simcard_id')->references('id')->on('simcards');
            $table->foreign('term_id')->references('id')->on('terms');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('consultant_id')->references('id')->on('consultants');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('user_updated_id')->references('id')->on('users');
            $table->foreign('user_posted_id')->references('id')->on('users');
            $table->foreign('user_deleted_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('contracts');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
