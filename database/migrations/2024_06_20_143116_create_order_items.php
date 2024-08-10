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
        Schema::create('order_items', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('order_id');
            $table->string('furniture_id');
            $table->string('preorder');
            $table->float('price');
            $table->string('qty');
            $table->float('total_price');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('furniture_id')->references('uuid')->on('furniture')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
