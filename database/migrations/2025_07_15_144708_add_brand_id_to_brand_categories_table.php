<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brand_categories', function (Blueprint $table) {
            if (!Schema::hasColumn('brand_categories', 'brand_id')) {
                $table->foreignId('brand_id')
                      ->constrained('brands')
                      ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('brand_categories', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
            $table->dropColumn('brand_id');
        });
    }
};

