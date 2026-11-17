<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'type', 'value', 'min_purchase',
        'max_discount', 'usage_limit', 'used_count', 'is_active', 'starts_at', 'expires_at',
    ];

    protected $casts = [
        'value'        => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'is_active'    => 'boolean',
        'starts_at'    => 'datetime',
        'expires_at'   => 'datetime',
    ];

    public function isValid()
    {
        if (!$this->is_active) return false;
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) return false;
        if ($this->starts_at && now()->lt($this->starts_at)) return false;
        if ($this->expires_at && now()->gt($this->expires_at)) return false;
        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if ($subtotal < $this->min_purchase) return 0;
        $discount = $this->type === 'percentage'
            ? $subtotal * ($this->value / 100)
            : $this->value;
        return $this->max_discount ? min($discount, $this->max_discount) : $discount;
    }
}

