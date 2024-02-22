<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDcustomersTable extends Migration
{
    /**
     * Run the migrations

     *
     * @return void
     */
    public function up()
    {
        Schema::create('dcustomers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->string('rif', 14)->nullable();
            $table->string('business_name')->nullable();
            $table->boolean('multicommerce')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('affiliate_number', 20)->nullable();
            $table->enum('type_account', ['Corriente', 'Ahorro']);
            $table->string('account_number', 24)->nullable();
            $table->boolean('valid_bank')->nullable();
            $table->boolean('personal_signature')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('bank_id')->references('id')->on('banks');
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
        Schema::dropIfExists('dcustomers');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
