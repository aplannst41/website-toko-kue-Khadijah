<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ShippingAddress;
use App\Models\Setting;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda masih kosong.');
        }

        $subtotal = $cart->total;
        $freeShippingMin = (float) Setting::get('free_shipping_min', 200000);
        
        // Setting ongkir berbasis jarak
        $storeLat = (float) Setting::get('store_lat', 5.161100);
        $storeLng = (float) Setting::get('store_lng', 97.135200);
        $baseKm = (float) Setting::get('shipping_base_km', 3);
        $baseCost = (float) Setting::get('shipping_base_cost', 8000);
        $perKm = (float) Setting::get('shipping_per_km', 2000);

        return view('frontend.checkout.index', compact(
            'cart', 'subtotal', 'freeShippingMin',
            'storeLat', 'storeLng', 'baseKm', 'baseCost', 'perKm'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'delivery_type'   => 'required|in:pickup,delivery',
            'delivery_date'   => 'required|date|after_or_equal:today',
            'delivery_time'   => 'required|string',
            'payment_method'  => 'required|in:midtrans,transfer_bsi,transfer_bca,transfer_mandiri,transfer_bri,qris,cod',
            'note'            => 'nullable|string|max:500',
            // delivery fields if delivery
            'recipient_name'  => 'required_if:delivery_type,delivery|nullable|string|max:100',
            'phone'           => 'required_if:delivery_type,delivery|nullable|string|max:20',
            'address'         => 'required_if:delivery_type,delivery|nullable|string',
            'district'        => 'required_if:delivery_type,delivery|nullable|in:Muara Dua,Banda Sakti,Muara Satu,Blang Mangat',
            'city'            => 'nullable|string|max:100',
            'province'        => 'nullable|string|max:100',
            'latitude'        => 'nullable|numeric',
            'longitude'       => 'nullable|numeric',
            'distance_km'     => 'nullable|numeric',
        ], [
            'district.in'     => 'Pengantaran kurir saat ini hanya tersedia untuk wilayah Kota Lhokseumawe (Muara Dua, Banda Sakti, Muara Satu, Blang Mangat).',
        ]);

        $cart = Cart::where('user_id', Auth::id())->firstOrFail();

        if ($cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja kosong.');
        }

        $subtotal = $cart->total;
        $shippingCost = 0;
        $distanceKm = (float) ($request->distance_km ?? 0);

        if ($request->delivery_type === 'delivery') {
            $freeMin = (float) Setting::get('free_shipping_min', 200000);

            if ($subtotal >= $freeMin) {
                $shippingCost = 0;
            } else {
                $baseKm = (float) Setting::get('shipping_base_km', 3);
                $baseCost = (float) Setting::get('shipping_base_cost', 8000);
                $perKm = (float) Setting::get('shipping_per_km', 2000);

                if ($distanceKm <= $baseKm) {
                    $shippingCost = $baseCost;
                } else {
                    $extraKm = ceil($distanceKm - $baseKm);
                    $shippingCost = $baseCost + ($extraKm * $perKm);
                }
            }
        }

        $total = $subtotal + $shippingCost;

        $order = DB::transaction(function () use ($request, $cart, $subtotal, $shippingCost, $total, $distanceKm) {
            $order = Order::create([
                'user_id'         => Auth::id(),
                'status'          => 'pending',
                'delivery_type'   => $request->delivery_type,
                'delivery_date'   => $request->delivery_date,
                'delivery_time'   => $request->delivery_time,
                'subtotal'        => $subtotal,
                'shipping_cost'   => $shippingCost,
                'discount_amount' => 0,
                'total'           => $total,
                'note'            => $request->note,
            ]);

            // Save order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'variant_info' => $item->variant ? ($item->variant->type . ': ' . $item->variant->value) : null,
                    'quantity'     => $item->quantity,
                    'price'        => $item->price,
                    'subtotal'     => $item->subtotal,
                    'cake_text'    => $item->cake_text,
                    'note'         => $item->note,
                ]);

                // Reduce stock & increment sold_count
                $item->product->decrement('stock', $item->quantity);
                $item->product->increment('sold_count', $item->quantity);
            }

            // Save shipping address if delivery
            if ($request->delivery_type === 'delivery') {
                ShippingAddress::create([
                    'order_id'       => $order->id,
                    'recipient_name' => $request->recipient_name,
                    'phone'          => $request->phone,
                    'address'        => $request->address,
                    'latitude'       => $request->latitude,
                    'longitude'      => $request->longitude,
                    'distance_km'    => $distanceKm,
                    'district'       => $request->district ?? 'Muara Dua',
                    'city'           => 'Kota Lhokseumawe',
                    'province'       => 'Aceh',
                    'shipping_cost'  => $shippingCost,
                ]);
            }

            // Create initial payment record
            Payment::create([
                'order_id' => $order->id,
                'method'   => $request->payment_method,
                'amount'   => $total,
                'status'   => 'pending',
            ]);

            // Clear cart
            $cart->items()->delete();

            return $order;
        });

        // Jika metode pembayaran Midtrans, prapersiapkan Snap Token
        if ($request->payment_method === 'midtrans') {
            app(MidtransService::class)->getSnapToken($order);
        }

        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with(['items.product', 'shippingAddress', 'payment'])
            ->firstOrFail();

        $snapToken = null;
        $clientKey = config('midtrans.client_key');

        if ($order->payment && $order->payment->method === 'midtrans' && $order->status === 'pending') {
            $midtransService = app(MidtransService::class);
            $snapToken = $midtransService->getSnapToken($order);
            $clientKey = $midtransService->getClientKey();
        }

        return view('frontend.orders.show', compact('order', 'snapToken', 'clientKey'));
    }

    public function uploadPayment(Request $request, $orderNumber)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $path = $request->file('proof_image')->store('payments', 'public');

        $payment = $order->payment;
        if ($payment) {
            $payment->update([
                'proof_image' => $path,
                'status'      => 'pending',
            ]);
        }

        $order->update(['status' => 'paid']);

        return redirect()->route('orders.show', $order->order_number)
            ->with('success', 'Bukti pembayaran berhasil diunggah! Tim kami akan segera memverifikasinya.');
    }

    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['items', 'payment'])
            ->latest()
            ->paginate(10);

        return view('frontend.orders.index', compact('orders'));
    }
}
