<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAconsecutivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aconsecutives', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fechpro')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->unsignedBigInteger('refere')->nullable();
            $table->boolean('is_management')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamps();
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('contract_id')->references('id')->on('contracts');
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
        Schema::dropIfExists('aconsecutives');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
