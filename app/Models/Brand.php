<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Policies\CategoriesPolicy;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'order',
    ];

    // Relasi: 1 Brand memiliki banyak Product
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Brand.php
    public function categories()
{
    return $this->belongsToMany(Categories::class, 'brand_categories', 'brand_id', 'category_id');
}

}
