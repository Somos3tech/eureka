<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperterminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operterminals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->enum('type_operation', ['activacion', 'suspension', 'cambio'])->nullable();
            $table->enum('type_service', ['temporal', 'definitivo'])->nullable();
            $table->unsignedBigInteger('term_id')->nullable();
            $table->date('fechpro')->nullable(); //fecha
            $table->date('date_inactive')->nullable(); //fecha
            $table->date('date_reactive')->nullable(); //fecha
            $table->longText('observations')->nullable();
            $table->string('term_name', 45)->nullable();
            $table->string('serial_terminal', 45)->nullable();
            $table->enum('status', ['Pendiente', 'Finalizado', 'Anulado'])->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('term_id')->references('id')->on('terms');
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
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('operterminals');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
