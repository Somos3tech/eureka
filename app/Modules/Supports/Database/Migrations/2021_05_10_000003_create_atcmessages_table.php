<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtcmessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atcmessages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('atc_id')->nullable();
            $table->longText('message')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamp('created_at');
            $table->foreign('atc_id')->references('id')->on('atcs');
            $table->foreign('user_created_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('atcmessages');
    }
}
