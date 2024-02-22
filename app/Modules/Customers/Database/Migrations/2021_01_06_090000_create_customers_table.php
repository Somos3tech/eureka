<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('rif', 14);
            $table->string('type_cont', 2)->nullable();
            $table->integer('tax')->nullable();
            $table->string('business_name');
            $table->unsignedBigInteger('cactivity_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->string('municipality')->nullable();
            $table->string('address')->nullable();
            $table->string('postal_code', 4)->nullable();
            $table->boolean('fiscal')->nullable();
            $table->unsignedBigInteger('state_fiscal_id')->nullable();
            $table->unsignedBigInteger('city_fiscal_id')->nullable();
            $table->string('municipality_fiscal')->nullable();
            $table->string('address_fiscal')->nullable();
            $table->string('postal_code_fiscal', 4)->nullable();
            $table->string('email')->nullable();
            $table->string('telephone', 12)->nullable();
            $table->string('mobile', 12)->nullable();
            $table->string('city_register')->nullable();
            $table->string('comercial_register')->nullable();
            $table->datetime('date_register')->nullable();
            $table->string('number_register')->nullable();
            $table->string('took_register')->nullable();
            $table->string('clause_register')->nullable();
            $table->text('file_document')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('cactivity_id')->references('id')->on('cactivities');
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('state_fiscal_id')->references('id')->on('states');
            $table->foreign('city_fiscal_id')->references('id')->on('cities');
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
        Schema::dropIfExists('customers');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
