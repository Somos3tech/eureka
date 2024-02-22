<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoiceitems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('invoiceitem_id')->nullable();
            $table->date('fechpro')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->integer('item')->nullable();
            $table->string('concept')->nullable();
            $table->double('amount', 15, 2)->nullable();
            $table->double('amount_currency', 15, 2)->nullable();
            $table->date('date_expire')->nullable();
            $table->enum('status', ['G', 'C', 'R', 'P', 'X'])->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('currency_id')->references('id')->on('currencies');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('invoiceitems');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
