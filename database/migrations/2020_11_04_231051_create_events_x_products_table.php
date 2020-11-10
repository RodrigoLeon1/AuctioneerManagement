<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Cambiar nombre a event_product
class CreateEventsXProductsTable extends Migration
{

    public function up()
    {
        Schema::create('events_x_products', function (Blueprint $table) {
            $table->foreignId('event_id')
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
        Schema::dropIfExists('events_x_products');
    }
}
