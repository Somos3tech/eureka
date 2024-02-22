<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('abrev')->unique();
            $table->text('description');
            $table->text('observations')->nullable();
            $table->enum('type_conditions', ['Tarifa', 'Porcentaje', 'Mixto']);
            $table->enum('type_conditions1', ['Fijo', 'Rango']);
            $table->unsignedBigInteger('currency_id');
            $table->double('comission_flatrate', 2, 1)->nullable();
            $table->double('comission_percentage', 2, 1)->nullable();
            $table->integer('comission_min')->nullable();
            $table->unsignedBigInteger('comission_id')->nullable();
            $table->integer('amount_min')->nullable();
            $table->integer('amount_max')->nullable();
            $table->integer('prepaid')->nullable();
            $table->enum('type_invoice', ['D', 'Q', 'M', 'S']);
            $table->enum('status', ['Activo', 'Inactivo']);
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('comission_id')->references('id')->on('comissions');
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
        Schema::dropIfExists('terms');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
