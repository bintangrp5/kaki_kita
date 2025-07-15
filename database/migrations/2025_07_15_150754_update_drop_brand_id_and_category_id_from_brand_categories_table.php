<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('brand_categories', function (Blueprint $table) {
            // Hapus foreign key constraints
            $table->dropForeign('brand_categories_brand_id_foreign');
            $table->dropForeign('brand_categories_category_id_foreign');

            // Hapus kolom
            $table->dropColumn(['brand_id', 'category_id']);
        });
    }

    public function down(): void
    {
        Schema::table('brand_categories', function (Blueprint $table) {
            // Tambahkan kembali kolom
            $table->unsignedBigInteger('brand_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();

            // Tambahkan kembali foreign key constraints
            $table->foreign('brand_id')->references('id')->on('brands')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
        });
    }
};
