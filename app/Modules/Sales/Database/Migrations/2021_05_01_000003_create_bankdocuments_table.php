<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankdocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bankdocuments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('fechpro')->nullable();
            $table->double('amount_currency', 15, 2)->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->longText('data')->nullable();
            $table->longText('name_file')->nullable();
            $table->text('observation')->nullable();
            $table->enum('status', ['G', 'P', 'R'])->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('user_updated_id')->references('id')->on('users');
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
        Schema::dropIfExists('bankdocuments');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
