<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaffiliatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('raffiliates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fechpro')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('dcustomer_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->text('data')->nullable();
            $table->text('observation_response')->nullable();
            $table->enum('status', ['Generado', 'Actualizado', 'Afiliado', 'Desactivado'])->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamps();
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('dcustomer_id')->references('id')->on('dcustomers');
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
        Schema::dropIfExists('raffiliates');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
