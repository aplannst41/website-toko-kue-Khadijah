<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'method', 'amount', 'proof_image', 'snap_token',
        'transaction_id', 'payment_type', 'payment_response',
        'status', 'admin_note', 'verified_at', 'verified_by',
    ];

    protected $casts = [
        'amount'           => 'decimal:2',
        'verified_at'      => 'datetime',
        'payment_response' => 'array',
    ];

    public function order()      { return $this->belongsTo(Order::class); }
    public function verifiedBy() { return $this->belongsTo(User::class, 'verified_by'); }

    public function getMethodLabelAttribute()
    {
        return match($this->method) {
            'midtrans'         => 'Midtrans (QRIS / E-Wallet / VA Bank Otomatis)',
            'transfer_bsi'     => 'Transfer BSI (Bank Syariah Indonesia)',
            'transfer_bca'     => 'Transfer BCA',
            'transfer_mandiri' => 'Transfer Mandiri',
            'transfer_bri'     => 'Transfer BRI',
            'qris'             => 'QRIS Manual (GoPay/Dana/OVO)',
            'cod'              => 'Bayar di Tempat (COD)',
            default            => strtoupper($this->method),
        };
    }
}

