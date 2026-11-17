<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number', 'user_id', 'status', 'delivery_type', 'delivery_date',
        'delivery_time', 'subtotal', 'shipping_cost', 'discount_amount', 'total',
        'discount_code', 'note',
    ];

    protected $casts = [
        'delivery_date'   => 'datetime',
        'subtotal'        => 'decimal:2',
        'shipping_cost'   => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total'           => 'decimal:2',
    ];

    // Generate nomor order otomatis: SCB-20241015-001
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            $count = static::whereDate('created_at', today())->count() + 1;
            $order->order_number = 'SCB-' . now()->format('Ymd') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }

    public function user()            { return $this->belongsTo(User::class); }
    public function items()           { return $this->hasMany(OrderItem::class); }
    public function payment()         { return $this->hasOne(Payment::class); }
    public function shippingAddress() { return $this->hasOne(ShippingAddress::class); }
    public function reviews()         { return $this->hasMany(Review::class); }

    // Label status untuk tampilan
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending'    => 'Menunggu Pembayaran',
            'paid'       => 'Menunggu Verifikasi',
            'verified'   => 'Pembayaran Terverifikasi',
            'processing' => 'Sedang Diproses',
            'ready'      => 'Siap Diambil/Dikirim',
            'delivered'  => 'Sedang Dikirim',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
            default      => $this->status,
        };
    }

    // Badge warna status
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending'    => 'yellow',
            'paid'       => 'blue',
            'verified'   => 'indigo',
            'processing' => 'orange',
            'ready'      => 'purple',
            'delivered'  => 'cyan',
            'completed'  => 'green',
            'cancelled'  => 'red',
            default      => 'gray',
        };
    }

    public function scopeForUser($q, $userId) { return $q->where('user_id', $userId); }
    public function scopeByStatus($q, $status) { return $q->where('status', $status); }
}

