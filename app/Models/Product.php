<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'ingredients', 'allergens',
        'price', 'discount_price', 'main_image', 'stock', 'min_order_days',
        'is_featured', 'is_best_seller', 'is_custom_order', 'is_active',
        'sold_count', 'rating_avg', 'rating_count',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_featured'    => 'boolean',
        'is_best_seller' => 'boolean',
        'is_custom_order'=> 'boolean',
        'is_active'      => 'boolean',
        'rating_avg'     => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    // Relasi
    public function category()      { return $this->belongsTo(Category::class); }
    public function images()        { return $this->hasMany(ProductImage::class)->orderBy('sort_order'); }
    public function variants()      { return $this->hasMany(ProductVariant::class)->where('is_active', true); }
    public function reviews()       { return $this->hasMany(Review::class)->where('is_approved', true); }
    public function cartItems()     { return $this->hasMany(CartItem::class); }
    public function orderItems()    { return $this->hasMany(OrderItem::class); }
    public function wishlists()     { return $this->hasMany(Wishlist::class); }

    // Accessor: harga aktif (diskon jika ada)
    public function getActivePriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    // Accessor: format harga rupiah
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->active_price, 0, ',', '.');
    }

    // Accessor: URL gambar utama (mendukung URL eksternal dan path lokal)
    public function getMainImageAttribute($value)
    {
        if (empty($value)) {
            return 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=800';
        }
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return $value;
        }
        return asset(ltrim($value, '/'));
    }

    // Scope
    public function scopeActive($q)      { return $q->where('is_active', true); }
    public function scopeFeatured($q)    { return $q->where('is_featured', true); }
    public function scopeBestSeller($q)  { return $q->where('is_best_seller', true); }
    public function scopeAvailable($q)   { return $q->where('stock', '>', 0); }
}

