<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdomiciliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adomiciliations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->longText('file_bank')->nullable();
            $table->longText('file_response_bank')->nullable();
            $table->boolean('send_email')->nullable();
            $table->longText('data_email')->nullable();
            $table->longText('data')->nullable();
            $table->text('observation')->nullable();
            $table->enum('status', ['Generado', 'Enviado', 'Procesado', 'Anulado'])->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('user_send_id')->nullable();
            $table->date('send_at')->nullable();
            $table->unsignedBigInteger('user_process_id')->nullable();
            $table->date('process_at')->nullable();
            $table->unsignedBigInteger('user_upload_id')->nullable();
            $table->date('upload_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('user_updated_id')->references('id')->on('users');
            $table->foreign('user_deleted_id')->references('id')->on('users');
            $table->foreign('user_send_id')->references('id')->on('users');
            $table->foreign('user_upload_id')->references('id')->on('users');
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
        Schema::dropIfExists('adomiciliations');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
