<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_assign_id')->nullable();
            $table->unsignedBigInteger('terminal_id')->nullable();
            $table->unsignedBigInteger('simcard_id')->nullable();
            $table->text('observations')->nullable();
            $table->enum('status', ['P', 'A', 'D', 'C', 'X']);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('user_assign_id')->references('id')->on('users');
            $table->foreign('terminal_id')->references('id')->on('terminals');
            $table->foreign('simcard_id')->references('id')->on('simcards');
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
        Schema::dropIfExists('assignments');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
