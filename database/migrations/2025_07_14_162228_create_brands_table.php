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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Nama brand
            $table->string('slug')->unique();          // Slug untuk URL
            $table->text('description')->nullable();   // Deskripsi (opsional)
            $table->string('image')->nullable();       // Gambar logo brand
            $table->boolean('is_active')->default(true); // Aktif/tidak
            $table->integer('order')->default(0);      // Urutan tampil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
