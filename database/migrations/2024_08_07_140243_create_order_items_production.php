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
        Schema::create('order_items_production', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('order_items_id');
            $table->string('production_status');
            $table->foreign('order_items_id')->references('id')->on('order_items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items_production');
    }
};
