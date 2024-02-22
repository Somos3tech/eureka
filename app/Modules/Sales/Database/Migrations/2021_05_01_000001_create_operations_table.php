<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type_service', ['basico', 'masivo'])->nullable();
            $table->enum('type_operation', ['exoneracion', 'debito', 'credito', 'reverso', 'anulacion'])->nullable();
            $table->longText('data')->nullable();
            $table->longText('observations')->nullable();
            $table->longText('file_operation')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('operations');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
