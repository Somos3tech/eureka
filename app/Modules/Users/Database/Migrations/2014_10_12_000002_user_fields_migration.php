<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class UserFieldsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('banklist')->nullable();
        });
    }

    public function down()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('users', function ($table) {
            $table->dropColumn('company_id');
            $table->dropColumn('banklist');
        });
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
