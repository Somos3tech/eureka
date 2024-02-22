<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('contract_id')->nullable();
            $table->integer('receipt_journey')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->text('refere')->nullable(); //consecutivo de recibo
            $table->datetime('fechpro')->nullable(); //fecha
            $table->enum('tipcta', ['C', 'A'])->nullable(); //Ahorro o Corriente
            $table->unsignedBigInteger('concept_id')->nullable(); //IDConcepto de factura o cobro x Servicio o (TERMINALPOS, SIMCARD, OTROS CONCEPTOS)
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('rif', 14)->nullable();
            $table->string('business_name')->nullable(); //Nombre Negocio
            $table->string('nrocta', 20)->nullable();
            $table->integer('nropos')->nullable(); //Numero POS
            $table->enum('tipnot', ['Efectivo', 'Deposito', 'Transferencia', 'DTE', 'Custodia', 'Postpago'])->nullable(); //TIPO NOTA
            $table->datetime('payment_date')->nullable(); //fecha
            $table->enum('type_sale', ['basic'])->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->double('amount', 15, 2)->nullable(); //Monto
            $table->double('free', 15, 2)->nullable(); //Monto
            $table->double('amount_currency', 15, 2)->nullable(); //Monto
            $table->enum('frec_invoice', ['D', 'Q', 'M', 'S'])->nullable(); //FRECUENCIA DE COBRO MENSUAL O DIARIO
            $table->integer('quota')->nullable();
            $table->integer('lote')->nullable();
            $table->text('conceptc')->nullable(); //Nota Adicional en el caso de los pagos parciales
            $table->text('conciliation_doc')->nullable();
            $table->enum('status', ['G', 'P', 'R', 'C', 'E', 'X'])->nullable(); //FRECUENCIA DE COBRO MENSUAL O DIARIO
            $table->unsignedBigInteger('user_created_id')->nullable();
            $table->unsignedBigInteger('user_updated_id')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('user_deleted_id')->nullable();
            $table->softDeletes();
            $table->foreign('bank_id')->references('id')->on('banks');
            $table->foreign('concept_id')->references('id')->on('concepts');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('contract_id')->references('id')->on('contracts');
            $table->foreign('currency_id')->references('id')->on('currencies');
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
        Schema::dropIfExists('invoices');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
