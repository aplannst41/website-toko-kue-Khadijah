<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'type', 'value', 'price_addition', 'stock', 'is_active'];

    protected $casts = [
        'price_addition' => 'decimal:2',
        'is_active'      => 'boolean',
    ];

    public function product()   { return $this->belongsTo(Product::class); }
    public function cartItems() { return $this->hasMany(CartItem::class); }
}

