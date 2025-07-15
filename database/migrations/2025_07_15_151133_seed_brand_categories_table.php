<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

return new class extends Migration
{
    public function up(): void
    {
        $brands = DB::table('brands')->get();
        $categories = DB::table('product_categories')->pluck('id');

        $data = [];

        foreach ($brands as $brand) {
            // Ambil 2 kategori acak per brand
            $selectedCategories = $categories->random(min(2, $categories->count()));

            foreach ($selectedCategories as $categoryId) {
                $data[] = [
                    'brand_id' => $brand->id,
                    'category_id' => $categoryId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ];
            }
        }

        DB::table('brand_categories')->insert($data);
    }

    public function down(): void
    {
        DB::table('brand_categories')->truncate(); // hapus semua isi brand_categories jika rollback
    }
};

