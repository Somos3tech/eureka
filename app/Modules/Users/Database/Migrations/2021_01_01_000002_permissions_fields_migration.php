<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class PermissionsFieldsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function ($table) {
            $table->string('description')->nullable();
        });
    }

    public function down()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Schema::table('permissions', function ($table) {
            $table->dropColumn('description');
        });
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
