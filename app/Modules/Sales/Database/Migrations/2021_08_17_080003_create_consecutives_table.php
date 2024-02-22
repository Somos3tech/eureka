<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsecutivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consecutives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fechpro')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->unsignedBigInteger('consecutive')->nullable();
            $table->boolean('is_management')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamps();
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('bank_id')->references('id')->on('banks');
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
        Schema::dropIfExists('consecutives');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
