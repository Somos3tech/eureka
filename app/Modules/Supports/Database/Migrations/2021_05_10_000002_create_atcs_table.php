<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtcsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atcs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('channel_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('rif', 14)->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('telephone', 12)->nullable();
            $table->string('mobile', 12)->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('managementtype_id')->nullable();
            $table->unsignedBigInteger('mtypeitem_id')->nullable();
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->longText('observation')->nullable();
            $table->longText('observation_manager')->nullable();
            $table->longText('observation_final')->nullable();
            $table->enum('status', ['G', 'P', 'F', 'X']);
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('channel_id')->references('id')->on('channels');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('managementtype_id')->references('id')->on('managementtypes');
            $table->foreign('mtypeitem_id')->references('id')->on('mtypeitems');
            $table->foreign('contract_id')->references('id')->on('contracts');
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
        Schema::dropIfExists('atcs');
    }
}
