<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    public function calculatedPriceByQuantity()
    {
        return $this->items->sum(function ($item) {
            return $item->itemable->price * $item->quantity;
        });
    }
}
