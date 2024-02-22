<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('invoiceitem_id')->nullable();
            $table->string('fechpro', 10);
            $table->string('tipnot', 3);
            $table->unsignedBigInteger('acconcept_id');
            $table->string('refere', 191);
            $table->unsignedBigInteger('currency_id');
            $table->double('dicom', 15, 2);
            $table->double('amount_currency', 15, 2);
            $table->double('amount', 15, 2);
            $table->string('description', 191)->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('invoice_id')->references('id')->on('invoices');
            //$table->foreign('invoiceitem_id')->references('id')->on('invoiceitems');
            $table->foreign('acconcept_id')->references('id')->on('acconcepts');
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
        Schema::dropIfExists('collections');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
