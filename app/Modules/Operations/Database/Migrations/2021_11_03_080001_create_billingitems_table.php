<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billingitems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('billing_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->integer('iva')->nullable();
            $table->double('free', 2)->nullable();
            $table->double('amount_sim', 15, 2)->nullable();
            $table->double('amount', 15, 2)->nullable(); //Monto
            $table->double('amount_currency', 15, 2)->nullable(); //Monto Divisa
            $table->unsignedBigInteger('terminal_id')->nullable();
            $table->unsignedBigInteger('simcard_id')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('billing_id')->references('id')->on('billings');
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('terminal_id')->references('id')->on('terminals');
            $table->foreign('simcard_id')->references('id')->on('simcards');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('user_updated_id')->references('id')->on('users');
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
        Schema::dropIfExists('billingitems');
    }
}
