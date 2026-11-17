<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'subtitle', 'image', 'link', 'sort_order', 'is_active', 'starts_at', 'expires_at'];
    protected $casts = ['is_active' => 'boolean', 'starts_at' => 'datetime', 'expires_at' => 'datetime'];

    public function scopeActive($q) { return $q->where('is_active', true)->orderBy('sort_order'); }
}

