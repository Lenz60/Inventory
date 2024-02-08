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
        Schema::create('furniture', function (Blueprint $table) {
            $table->string('uuid')->primary();
            $table->string('image');
            $table->string('code');
            $table->string('description');
            $table->enum('category',array('Indoor','Outdoor','Handicraft','Root'));
            $table->enum('wood_type',array('Teak wood','Tiger wood','Mahogany wood','Root'));
            $table->string('width');
            $table->string('depth');
            $table->string('height');
            $table->string('stock');
            $table->float('price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furniture');
    }
};
