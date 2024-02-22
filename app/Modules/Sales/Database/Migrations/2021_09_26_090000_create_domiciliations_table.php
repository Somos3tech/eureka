<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomiciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('domiciliations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->double('amount_currency_old', 15, 2)->nullable();
            $table->double('amount_currency', 15, 2)->nullable();
            $table->enum('type_management', ['Diario', 'Masivo', 'Morosidad'])->nullable();
            $table->date('date_ini')->nullable();
            $table->date('date_end')->nullable();
            $table->date('date_operation')->nullable();
            $table->longText('file_bank')->nullable();
            $table->longText('file_response_bank')->nullable();
            $table->boolean('send_email')->nullable();
            $table->longText('data_email')->nullable();
            $table->longText('data')->nullable();
            $table->text('observation')->nullable();
            $table->enum('status', ['Generado', 'Enviado', 'Procesando', 'Procesado', 'Cargado', 'Anulado'])->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('user_send_id')->nullable();
            $table->datetime('send_at')->nullable();
            $table->unsignedBigInteger('user_upload_id')->nullable();
            $table->datetime('upload_at')->nullable();
            $table->unsignedBigInteger('user_process_id')->nullable();
            $table->datetime('process_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->integer('total_processed')->nullable();
            $table->integer('total_pending')->nullable();
            $table->double('total_amount_pending', 15, 2)->nullable();
            $table->double('total_amount_processed', 15, 2)->nullable();
            $table->double('total_amount_register', 15, 2)->nullable();
            $table->integer('total_register')->nullable();
            $table->integer('total_processed_real')->nullable();
            $table->double('total_amount_processed_real', 15, 2)->nullable();
            $table->softDeletes();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('user_updated_id')->references('id')->on('users');
            $table->foreign('user_deleted_id')->references('id')->on('users');
            $table->foreign('user_send_id')->references('id')->on('users');
            $table->foreign('user_process_id')->references('id')->on('users');
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
        Schema::dropIfExists('domiciliations');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
