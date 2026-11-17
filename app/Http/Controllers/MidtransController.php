<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    protected MidtransService $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Webhook Callback resmi dari server Midtrans
     * Dipanggil secara otomatis oleh Midtrans saat status transaksi berubah
     */
    public function callback(Request $request)
    {
        Log::info('Midtrans Webhook Callback Diterima:', $request->all());

        try {
            $success = $this->midtransService->handleNotification($request->all());

            if ($success) {
                return response()->json([
                    'status'  => 'success',
                    'message' => 'Status pembayaran berhasil diperbarui.',
                ], 200);
            }

            return response()->json([
                'status'  => 'error',
                'message' => 'Signature key atau data pesanan tidak cocok.',
            ], 400);
        } catch (\Exception $e) {
            Log::error('Error pada Midtrans Callback: ' . $e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Endpoint untuk mendapatkan Snap Token pesanan (dipanggil oleh JavaScript frontend)
     */
    public function getSnapToken($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['items.product', 'shippingAddress', 'payment'])
            ->firstOrFail();

        $token = $this->midtransService->getSnapToken($order);

        if (!$token) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal membuat sesi pembayaran Midtrans. Pastikan Server Key sudah terisi dengan benar di .env.',
            ], 500);
        }

        return response()->json([
            'status'     => 'success',
            'snap_token' => $token,
            'client_key' => $this->midtransService->getClientKey(),
        ]);
    }
}
