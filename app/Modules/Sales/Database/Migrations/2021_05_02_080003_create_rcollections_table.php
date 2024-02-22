<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcollections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fechpro');
            $table->unsignedBigInteger('bankdocument_id')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->text('refere');
            $table->text('data');
            $table->enum('status', ['X', 'P'])->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamps();
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('bankdocument_id')->references('id')->on('bankdocuments');
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
        Schema::dropIfExists('rcollections');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
