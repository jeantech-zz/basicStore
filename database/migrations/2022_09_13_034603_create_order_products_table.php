<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    public function up():void
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedInteger('quantity');
            $table->unsignedBigInteger('amount');
            $table->foreignId('order_id')->constrained('orders');
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('order_products');
    }
}
