<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestsTable extends Migration
{
    public function up():void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders');
            $table->string('reference')->nullable();
            $table->string('description', 100);
            $table->string('returnUrl', 100);
            $table->json('response', 250);
            $table->string('requestId', 250)->nullable();
            $table->string('processUrl', 250)->nullable();
            $table->timestamps();
        });
    }

    public function down():void
    {
        Schema::dropIfExists('requests');
    }
}
