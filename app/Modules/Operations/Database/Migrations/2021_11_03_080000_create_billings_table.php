<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->datetime('fechpro')->nullable(); //fecha
            $table->datetime('fechven')->nullable(); //fecha
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('rif', 14);
            $table->string('business_name')->nullable();
            $table->string('address')->nullable();
            $table->string('telephone')->nullable();
            $table->text('observation')->nullable();
            $table->double('dicom', 15, 2)->nullable();
            $table->string('template')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('billings');
    }
}
