<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'recipient_name', 'phone', 'address', 'latitude', 'longitude', 'distance_km',
        'district', 'city', 'province', 'postal_code', 'shipping_cost', 'delivery_note',
    ];

    public function order() { return $this->belongsTo(Order::class); }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->district}, {$this->city}, {$this->province} {$this->postal_code}";
    }
}

