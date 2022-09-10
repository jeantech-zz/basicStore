<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsUsers extends Migration
{
    public function up():void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone_number')->nullable();
            $table->foreignId('rol_id')->nullable()->constrained('roles')->default(2);
        });
    }

    public function down():void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone_number');
            $table->dropColumn('address');
            $table->dropForeign(['rol_id']);
        });
    }
}
