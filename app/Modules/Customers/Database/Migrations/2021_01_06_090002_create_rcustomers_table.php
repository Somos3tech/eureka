<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcustomers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer_id');
            $table->string('document');
            $table->string('first_name');
            $table->string('jobtitle');
            $table->string('email');
            $table->text('telephone');
            $table->text('file_document');
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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::dropIfExists('rcustomers');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
