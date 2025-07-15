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
        Schema::create('brand_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('brands_id');
            $table->unsignedBigInteger('categories_id');

            $table->foreign('brands_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('categories_id')->references('id')->on('product_categories')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brand_categories');
    }
};
