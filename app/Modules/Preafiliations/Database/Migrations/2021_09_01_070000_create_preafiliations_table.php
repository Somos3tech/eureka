<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreafiliationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preafiliations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('rif', 14)->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->boolean('is_customer')->nullable();
            $table->text('data_customer')->nullable();
            $table->string('document_rif')->nullable();
            $table->boolean('is_rif')->nullable();
            $table->text('data_rcustomer')->nullable();
            $table->text('data_mercantil')->nullable();
            $table->string('document_mercantil')->nullable();
            $table->boolean('is_mercantil')->nullable();
            $table->text('data_bank')->nullable();
            $table->string('document_bank')->nullable();
            $table->boolean('is_bank')->nullable();
            $table->string('autorization_bank')->nullable();
            $table->boolean('is_auth_bank')->nullable();
            $table->text('data_contract')->nullable();
            $table->text('data_payment')->nullable();
            $table->boolean('is_payment')->nullable();
            $table->string('document_payment')->nullable();
            $table->longText('observation_initial')->nullable();
            $table->text('observations')->nullable();
            $table->text('observations_sale')->nullable();
            $table->enum('status', ['Procesado', 'Cargado', 'Anulado', 'Vencido']);
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->unsignedBigInteger('consultant_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('user_updated_id')->references('id')->on('users');
            $table->foreign('user_deleted_id')->references('id')->on('users');
            $table->foreign('consultant_id')->references('id')->on('consultants');
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
        Schema::dropIfExists('preafiliations');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
