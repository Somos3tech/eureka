<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->text('observ_credicard')->nullable();
            $table->text('observ_programmer')->nullable();
            $table->enum('type_posted', ['Presencial', 'Courier']);
            $table->date('date_send')->nullable();
            $table->string('number_control', 255)->nullable();
            $table->text('observ_posted')->nullable();
            $table->boolean('credicard')->nullable();
            $table->enum('status', ['P', 'PF', 'A', 'C', 'D', 'F', 'SF', 'S', 'X']);
            $table->unsignedBigInteger('canceledOrder_id')->nullable();
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('programmer_user_id')->nullable();
            $table->datetime('programmer_at')->nullable();
            $table->datetime('programmer_finish_at')->nullable();
            $table->unsignedBigInteger('receive_store_id')->nullable();
            $table->datetime('receive_store_at')->nullable();
            $table->unsignedBigInteger('billing_user_id')->nullable();
            $table->datetime('billing_at')->nullable();
            $table->unsignedBigInteger('assign_office_id')->nullable();
            $table->datetime('assign_office_at')->nullable();
            $table->unsignedBigInteger('posted_user_id')->nullable();
            $table->datetime('posted_at')->nullable();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('canceledOrder_id')->references('id')->on('users');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->foreign('user_updated_id')->references('id')->on('users');
            $table->foreign('programmer_user_id')->references('id')->on('users');
            $table->foreign('receive_store_id')->references('id')->on('users');
            $table->foreign('billing_user_id')->references('id')->on('users');
            $table->foreign('assign_office_id')->references('id')->on('users');
            $table->foreign('posted_user_id')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
