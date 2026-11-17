<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected function getOrCreateCart()
    {
        if (Auth::check()) {
            return Cart::firstOrCreate(['user_id' => Auth::id()]);
        }

        $sessionId = Session::getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function index()
    {
        $cart = $this->getOrCreateCart();
        $cart->load(['items.product.category', 'items.variant']);

        return view('frontend.cart.index', compact('cart'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id'         => 'required|exists:products,id',
            'product_variant_id' => 'nullable|exists:product_variants,id',
            'quantity'           => 'required|integer|min:1',
            'cake_text'          => 'nullable|string|max:100',
            'note'               => 'nullable|string|max:255',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = $this->getOrCreateCart();

        $variant = null;
        if ($request->filled('product_variant_id')) {
            $variant = ProductVariant::where('product_id', $product->id)
                ->where('id', $request->product_variant_id)
                ->where('is_active', true)
                ->first();
        }

        // If product has variants but customer didn't select, choose first active variant
        if (!$variant && $product->variants()->count() > 0) {
            $variant = $product->variants()->first();
        }

        $basePrice = $product->discount_price ?? $product->price;
        $finalPrice = $basePrice + ($variant ? (float) $variant->price_addition : 0);

        // Check if item already exists in cart with same variant, note & cake_text
        $existing = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variant?->id)
            ->where('cake_text', $request->cake_text)
            ->first();

        if ($existing) {
            $existing->increment('quantity', $request->quantity);
        } else {
            CartItem::create([
                'cart_id'            => $cart->id,
                'product_id'         => $product->id,
                'product_variant_id' => $variant?->id,
                'quantity'           => $request->quantity,
                'price'              => $finalPrice,
                'cake_text'          => $request->cake_text,
                'note'               => $request->note,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Menu lezat berhasil ditambahkan ke keranjang!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = $this->getOrCreateCart();
        $item = CartItem::where('cart_id', $cart->id)->where('id', $id)->firstOrFail();

        $item->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')->with('success', 'Jumlah pesanan berhasil diperbarui.');
    }

    public function remove($id)
    {
        $cart = $this->getOrCreateCart();
        $item = CartItem::where('cart_id', $cart->id)->where('id', $id)->firstOrFail();
        $item->delete();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
    }
}
