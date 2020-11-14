<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesProformaTable extends Migration
{

    public function up()
    {
        Schema::create('invoices_proforma', function (Blueprint $table) {
            $table->id();
            $table->date('date_remate');
            $table->date('date_delivery');
            $table->float('price_unit');
            $table->float('partial_total');
            $table->integer('commission');
            $table->float('partial_payment');
            $table->float('total');

            // ID comprador ?
            // $table->foreignId('user_id')
            //     ->constrained()
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');

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
