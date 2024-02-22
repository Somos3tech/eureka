<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->text('observations')->nullable();
            $table->enum('type_conditions', ['Tarifa', 'Porcentaje']);
            $table->integer('range_ini1');
            $table->integer('range_fin1');
            $table->integer('value1');
            $table->integer('range_ini2')->nullable();
            $table->integer('range_fin2')->nullable();
            $table->integer('value2')->nullable();
            $table->integer('range_ini3')->nullable();
            $table->integer('range_fin3')->nullable();
            $table->integer('value3')->nullable();
            $table->integer('range_ini4')->nullable();
            $table->integer('range_fin4')->nullable();
            $table->integer('value4')->nullable();
            $table->integer('range_ini5')->nullable();
            $table->integer('range_fin5')->nullable();
            $table->integer('value5')->nullable();
            $table->integer('amount_max')->nullable();
            $table->integer('value_max')->nullable();
            $table->enum('status', ['Activo', 'Inactivo']);
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('comissions');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
