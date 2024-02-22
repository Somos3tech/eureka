<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_role', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('role_id')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('role_id')->references('id')->on('roles');
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
        Schema::dropIfExists('zone_role');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
