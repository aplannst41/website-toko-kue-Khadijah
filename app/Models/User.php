<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'address', 'district', 'city', 'province', 'latitude', 'longitude', 'avatar', 'is_active',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active'         => 'boolean',
    ];

    // Relasi
    public function orders()    { return $this->hasMany(Order::class); }
    public function cart()      { return $this->hasOne(Cart::class); }
    public function reviews()   { return $this->hasMany(Review::class); }
    public function wishlists() { return $this->hasMany(Wishlist::class); }

    // Role helpers
    public function isAdmin()    { return $this->role === 'admin'; }
    public function isCustomer() { return $this->role === 'customer'; }

    // Accessor avatar
    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=f97316&color=fff';
    }
}
