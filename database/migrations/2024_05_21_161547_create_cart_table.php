<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('user_id');
            $table->string('furniture_id');
            $table->string('qty');
            $table->float('total_price');
            $table->foreign('user_id')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('furniture_id')->references('uuid')->on('furniture')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};
