<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
