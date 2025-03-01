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
        Schema::create('orders_info', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('order_id');
            $table->string('name');
            $table->string('company');
            $table->string('email');
            $table->string('phone_number');
            $table->string('address');
            $table->string('country');
            $table->string('region');
            $table->string('zip');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders_info');
    }
};
