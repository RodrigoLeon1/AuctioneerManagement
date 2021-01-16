<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{

    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->enum('type_invoice', ['cliente', 'remitente']);
            $table->integer('commission')->default(0);
            $table->integer('commission_percentage');
            $table->float('partial_payment')->default(0);
            $table->float('subtotal')->default(0);
            $table->float('total')->default(0);        
            $table->boolean('is_price_modified')->default(false);
            $table->float('price_modified')->default(0);
            $table->text('modified_description')->default('');

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
