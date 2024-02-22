<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimcardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('simcards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('apn_id')->nullable();
            $table->string('number_mobile', 191);
            $table->string('serial_sim', 20);
            $table->enum('status', ['Disponible', 'Asignado', 'Entregado', 'Desactivado', 'Inactivo']);
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_assignated_id')->nullable();
            $table->timestamp('assignated_at')->nullable();
            $table->unsignedBigInteger('user_posted_id')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('operator_id')->references('id')->on('operators');
            $table->foreign('apn_id')->references('id')->on('apn');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('user_updated_id')->references('id')->on('users');
            $table->foreign('user_assignated_id')->references('id')->on('users');
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
        Schema::dropIfExists('simcards');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
