<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('modelterminal_id');
            $table->datetime('fechpro')->nullable(); //fecha
            $table->string('serial');
            $table->string('imei');
            $table->macAddress('device')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_assignated_id')->nullable();
            $table->timestamp('assignated_at')->nullable();
            $table->enum('status', ['Disponible', 'Asignado', 'Credicard', 'Entregado', 'Desactivado', 'SinLlave']);
            $table->unsignedBigInteger('user_posted_id')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('modelterminal_id')->references('id')->on('modelterminal');
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
        Schema::dropIfExists('terminals');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
