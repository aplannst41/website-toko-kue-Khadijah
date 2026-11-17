<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'payment']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sq) use ($q) {
                $sq->where('order_number', 'like', "%{$q}%")
                   ->orWhereHas('user', function ($uq) use ($q) {
                       $uq->where('name', 'like', "%{$q}%")->orWhere('email', 'like', "%{$q}%");
                   });
            });
        }

        $orders = $query->latest()->paginate(15)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'shippingAddress', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,verified,processing,ready,delivered,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update(['status' => $request->status]);

        // Jika pesanan dibatalkan, kembalikan stok produk & kurangi jumlah terjual (sold_count)
        if ($oldStatus !== 'cancelled' && $request->status === 'cancelled') {
            foreach ($order->items as $item) {
                if ($item->product) {
                    $item->product->increment('stock', $item->quantity);
                    $item->product->decrement('sold_count', $item->quantity);
                }
            }
        }

        return back()->with('success', "Status pesanan #{$order->order_number} berhasil diubah menjadi {$order->status_label}.");
    }

    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'status'     => 'required|in:verified,rejected',
            'admin_note' => 'nullable|string|max:255',
        ]);

        $payment = $order->payment;
        if ($payment) {
            $payment->update([
                'status'      => $request->status,
                'admin_note'  => $request->admin_note,
                'verified_at' => now(),
                'verified_by' => Auth::id(),
            ]);
        }

        if ($request->status === 'verified') {
            $order->update(['status' => 'verified']);
        }

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
