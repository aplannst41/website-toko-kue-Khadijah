<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MidtransService
{
    protected string $serverKey;
    protected string $clientKey;
    protected bool $isProduction;
    protected string $snapApiUrl;

    public function __construct()
    {
        $this->serverKey    = config('midtrans.server_key', env('MIDTRANS_SERVER_KEY', ''));
        $this->clientKey    = config('midtrans.client_key', env('MIDTRANS_CLIENT_KEY', ''));
        $this->isProduction = (bool) config('midtrans.is_production', env('MIDTRANS_IS_PRODUCTION', false));

        $this->snapApiUrl = $this->isProduction
            ? 'https://app.midtrans.com/snap/v1/transactions'
            : 'https://app.sandbox.midtrans.com/snap/v1/transactions';
    }

    /**
     * Dapatkan atau buat Snap Token baru untuk pesanan
     */
    public function getSnapToken(Order $order): ?string
    {
        $payment = $order->payment;
        if ($payment && $payment->snap_token) {
            return $payment->snap_token;
        }

        // Susun daftar item kue untuk rincian Midtrans
        $items = [];
        foreach ($order->items as $item) {
            $items[] = [
                'id'       => (string) $item->product_id,
                'price'    => (int) round($item->price),
                'quantity' => (int) $item->quantity,
                'name'     => mb_substr($item->product_name, 0, 50),
            ];
        }

        // Tambahkan ongkos kirim jika ada
        if ($order->shipping_cost > 0) {
            $items[] = [
                'id'       => 'SHIPPING-COST',
                'price'    => (int) round($order->shipping_cost),
                'quantity' => 1,
                'name'     => 'Ongkos Kirim (' . ($order->shippingAddress->district ?? 'Lhokseumawe') . ')',
            ];
        }

        // Kurangi diskon jika ada
        if ($order->discount_amount > 0) {
            $items[] = [
                'id'       => 'DISCOUNT',
                'price'    => -(int) round($order->discount_amount),
                'quantity' => 1,
                'name'     => 'Diskon Potongan Harga',
            ];
        }

        // Pastikan total gross_amount sama persis dengan total items
        $grossAmount = (int) round($order->total);

        // Data customer
        $user = $order->user;
        $customerDetails = [
            'first_name' => $order->shippingAddress->recipient_name ?? $user->name,
            'email'      => $user->email,
            'phone'      => $order->shippingAddress->phone ?? ($user->phone ?? '08123456789'),
        ];

        if ($order->delivery_type === 'delivery' && $order->shippingAddress) {
            $customerDetails['shipping_address'] = [
                'first_name' => $order->shippingAddress->recipient_name,
                'phone'      => $order->shippingAddress->phone,
                'address'    => $order->shippingAddress->address,
                'city'       => $order->shippingAddress->city ?? 'Lhokseumawe',
                'postal_code'=> '24352',
                'country_code' => 'IDN',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => $grossAmount,
            ],
            'item_details'     => $items,
            'customer_details' => $customerDetails,
            'callbacks' => [
                'finish' => route('orders.show', $order->order_number),
            ],
        ];

        try {
            $response = Http::withBasicAuth($this->serverKey, '')
                ->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])
                ->post($this->snapApiUrl, $params);

            if ($response->successful()) {
                $token = $response->json('token');

                if ($payment) {
                    $payment->update([
                        'snap_token' => $token,
                        'method'     => 'midtrans',
                    ]);
                }

                return $token;
            } else {
                Log::error('Midtrans Snap Error: ' . $response->body());
                return null;
            }
        } catch (\Exception $e) {
            Log::error('Midtrans Exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Verifikasi & tangani webhook notifikasi resmi dari Midtrans
     */
    public function handleNotification(array $payload): bool
    {
        $orderNumber       = $payload['order_id'] ?? null;
        $statusCode        = $payload['status_code'] ?? '';
        $grossAmount       = $payload['gross_amount'] ?? '';
        $signatureKey      = $payload['signature_key'] ?? '';
        $transactionStatus = $payload['transaction_status'] ?? '';
        $fraudStatus       = $payload['fraud_status'] ?? '';
        $paymentType       = $payload['payment_type'] ?? '';
        $transactionId     = $payload['transaction_id'] ?? '';

        if (!$orderNumber) {
            return false;
        }

        // Validasi Signature Key SHA-512 Midtrans
        $expectedSignature = hash('sha512', $orderNumber . $statusCode . $grossAmount . $this->serverKey);
        if ($signatureKey !== $expectedSignature) {
            Log::warning("Midtrans Webhook: Signature Key tidak valid untuk order #{$orderNumber}");
            return false;
        }

        $order = Order::where('order_number', $orderNumber)->with(['payment', 'items.product'])->first();
        if (!$order) {
            Log::error("Midtrans Webhook: Order #{$orderNumber} tidak ditemukan");
            return false;
        }

        $payment = $order->payment;

        // Tangani status transaksi Midtrans
        if ($transactionStatus === 'capture') {
            if ($fraudStatus === 'accept') {
                $this->markAsSuccess($order, $payment, $transactionId, $paymentType, $payload);
            }
        } elseif ($transactionStatus === 'settlement') {
            // Berhasil bayar via QRIS, GoPay, Transfer VA, dll.
            $this->markAsSuccess($order, $payment, $transactionId, $paymentType, $payload);
        } elseif ($transactionStatus === 'pending') {
            // Menunggu pembayaran di sisi customer
            if ($payment) {
                $payment->update([
                    'status'           => 'pending',
                    'transaction_id'   => $transactionId,
                    'payment_type'     => $paymentType,
                    'payment_response' => $payload,
                ]);
            }
            $order->update(['status' => 'pending']);
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            // Dibatalkan / Kedaluwarsa
            if ($payment) {
                $payment->update([
                    'status'           => 'rejected',
                    'admin_note'       => "Midtrans: Pembayaran {$transactionStatus}",
                    'transaction_id'   => $transactionId,
                    'payment_type'     => $paymentType,
                    'payment_response' => $payload,
                ]);
            }
            $order->update(['status' => 'cancelled']);

            // Kembalikan stok kue jika dibatalkan/kadaluarsa
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                    $item->product->decrement('sold_count', $item->quantity);
                }
            }
        }

        return true;
    }

    private function markAsSuccess(Order $order, ?Payment $payment, string $transactionId, string $paymentType, array $payload): void
    {
        if ($payment) {
            $payment->update([
                'status'           => 'verified',
                'transaction_id'   => $transactionId,
                'payment_type'     => $paymentType,
                'payment_response' => $payload,
                'verified_at'      => now(),
            ]);
        }

        // Ubah order menjadi processing (kue siap diproses dapur)
        $order->update(['status' => 'processing']);
    }

    public function getClientKey(): string
    {
        return $this->clientKey;
    }

    public function isProduction(): bool
    {
        return $this->isProduction;
    }
}
