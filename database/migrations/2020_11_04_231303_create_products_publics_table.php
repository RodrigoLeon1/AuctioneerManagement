<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsPublicsTable extends Migration
{

    public function up()
    {
        Schema::create('products_publics', function (Blueprint $table) {
            $table->id();
            $table->date('date_max')->nullable();
            $table->float('price_max');

            $table->foreignId('product_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('products_publics', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
