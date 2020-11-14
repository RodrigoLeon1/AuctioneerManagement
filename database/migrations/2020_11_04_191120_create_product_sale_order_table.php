<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSaleOrderTable extends Migration
{

    public function up()
    {
        Schema::create('product_sale_order', function (Blueprint $table) {
            $table->smallInteger('quantity')->nullable();
            $table->smallInteger('quantity_tags')->nullable();
            $table->boolean('is_invoiced')->default(false);

            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('sale_order_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_orders_x_products');
    }
}
