<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceProformasTable extends Migration
{

    public function up()
    {
        Schema::create('invoice_proformas', function (Blueprint $table) {
            $table->id();
            $table->date('date_remate');
            $table->date('date_delivery');
            $table->integer('quantity');
            $table->float('price_unit');
            $table->float('partial_total');
            $table->integer('commission_percentage');
            $table->float('commission_value');
            $table->float('partial_payment');
            $table->float('total');
            $table->boolean('is_invoiced')->default(false);                 //cliente
            $table->boolean('is_invoiced_remitente')->default(false);

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('sale_order_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices_proforma');
    }
}
