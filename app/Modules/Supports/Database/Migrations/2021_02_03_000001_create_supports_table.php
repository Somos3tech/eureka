<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->enum('type_support', ['Garantia', 'Mantenimiento'])->nullable();
            $table->date('date_ini')->nullable(); //fecha
            $table->date('date_end')->nullable(); //fecha
            $table->text('observation')->nullable();
            $table->text('observation_technical')->nullable();
            $table->unsignedBigInteger('tipification_id')->nullable();
            $table->text('observation_manager')->nullable();
            $table->text('observation_response')->nullable();
            $table->unsignedBigInteger('terminal_id')->nullable();
            $table->unsignedBigInteger('terminal_new_id')->nullable();
            $table->text('observation_delivery')->nullable();
            $table->text('data_invoice')->nullable();
            $table->enum('delivery', ['Presencial', 'Courier'])->nullable();
            $table->enum('status', ['G', 'T', 'M', 'F', 'C', 'X']);
            $table->enum('type_invoice', ['S', 'ST', 'T', 'G'])->nullable();
            $table->enum('procedure_support', ['Autorizado', 'Cancelado'])->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_technical_id')->nullable();
            $table->timestamp('technical_at')->nullable();
            $table->unsignedBigInteger('user_manager_id')->nullable();
            $table->date('manager_at')->nullable();
            $table->unsignedBigInteger('user_finalized_id')->nullable();
            $table->date('finalized_at')->nullable();
            $table->unsignedBigInteger('user_delivery_id')->nullable();
            $table->date('delivery_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('tipification_id')->references('id')->on('tipifications');
            $table->foreign('terminal_id')->references('id')->on('terminals');
            $table->foreign('terminal_new_id')->references('id')->on('terminals');
            $table->foreign('user_technical_id')->references('id')->on('users');
            $table->foreign('user_manager_id')->references('id')->on('users');
            $table->foreign('user_finalized_id')->references('id')->on('users');
            $table->foreign('user_delivery_id')->references('id')->on('users');
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
        Schema::dropIfExists('supports');
    }
}
