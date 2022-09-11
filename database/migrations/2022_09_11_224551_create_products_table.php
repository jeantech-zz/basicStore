<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up():void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code',10)->unique();
            $table->string('name',88);
            $table->text('description');
            $table->unsignedBigInteger('price');
            $table->unsignedInteger('quantity');
            $table->timestamp('disable_at')->nullable();
            $table->string('image');
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('products');
    }
}
