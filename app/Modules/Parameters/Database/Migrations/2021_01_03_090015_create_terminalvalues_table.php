<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTerminalvaluesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('terminalvalues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date_value');
            $table->unsignedBigInteger('modelterminal_id');
            $table->unsignedBigInteger('currency_id');
            $table->decimal('amount_currency', 15, 2);
            $table->decimal('amount_local', 15, 2);
            $table->string('description')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('modelterminal_id')->references('id')->on('modelterminal');
            $table->foreign('currency_id')->references('id')->on('currencies');
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
        Schema::dropIfExists('terminalvalues');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
