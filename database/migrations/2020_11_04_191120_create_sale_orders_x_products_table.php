<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrdersXProductsTable extends Migration {
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('sale_orders_x_products', function (Blueprint $table) {                                
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sale_order_id');
            $table->smallInteger('quantity');
            $table->smallInteger('quantity_tags');
            $table->boolean('is_invoiced');
            $table->timestamps();

            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('sale_order_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('sale_orders_x_products');
    }
}
