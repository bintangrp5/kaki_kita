<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brand_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('brand_categories', 'category_id')) {
                $table->foreignId('category_id')
                      ->constrained('product_categories')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('brand_categories', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};

