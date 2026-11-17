@extends('layouts.frontend')

@section('title', 'Keranjang Belanja — Khadijah Donat & Cake')

@section('content')
    <div class="bg-gradient-to-b from-amber-100/60 to-[#FAF8F5] py-8 border-b border-stone-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-chocolate">Keranjang Belanja Anda</h1>
            <p class="text-sm text-stone-600 mt-1">Periksa kembali pesanan kue dan ucapan sebelum melanjutkan ke pembayaran.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if(!$cart || $cart->items->isEmpty())
            <!-- Empty Cart State -->
            <div class="bg-white rounded-3xl p-12 text-center border border-stone-200/80 shadow-sm max-w-md mx-auto my-10">
                <div class="w-20 h-20 rounded-full bg-amber-50 text-bakery-600 flex items-center justify-center text-4xl mx-auto mb-4">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <h3 class="font-serif font-bold text-2xl text-chocolate">Keranjang Belanja Masih Kosong</h3>
                <p class="text-sm text-stone-500 mt-2">Belum ada kue atau pastry lezat yang ditambahkan. Yuk, cari camilan dan kue favoritmu!</p>
                <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 mt-6 px-8 py-3.5 bg-gradient-to-r from-bakery-600 to-amber-500 text-white font-bold rounded-2xl shadow-lg hover:shadow-xl hover:scale-105 transition-all text-sm">
                    <span>Mulai Belanja Kue</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Items List -->
                <div class="lg:col-span-8 space-y-4">
                    @foreach($cart->items as $item)
                        <div class="bg-white rounded-3xl p-5 border border-stone-200/80 shadow-sm flex flex-col sm:flex-row gap-5 items-start sm:items-center justify-between">
                            
                            <!-- Product Image & Meta -->
                            <div class="flex items-center space-x-4">
                                <div class="w-20 h-20 rounded-2xl overflow-hidden bg-stone-100 flex-shrink-0 border border-stone-200">
                                    <img src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-bakery-600">{{ $item->product->category->name }}</span>
                                    <h3 class="font-serif font-bold text-stone-900 text-base leading-snug">
                                        <a href="{{ route('products.show', $item->product->slug) }}" class="hover:text-bakery-600">{{ $item->product->name }}</a>
                                    </h3>

                                    @if($item->variant)
                                        <div class="mt-1">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-amber-100 text-bakery-800 border border-amber-200">
                                                <i class="fa-solid fa-pizza-slice mr-1 text-[10px]"></i> {{ $item->variant->value }}
                                            </span>
                                        </div>
                                    @endif
                                    
                                    @if($item->cake_text)
                                        <div class="text-xs text-amber-800 bg-amber-50 px-2.5 py-1 rounded-lg mt-1 font-medium inline-block">
                                            🎂 <strong>Tulisan:</strong> "{{ $item->cake_text }}"
                                        </div>
                                    @endif

                                    @if($item->note)
                                        <p class="text-[11px] text-stone-500 italic mt-0.5">Catatan: {{ $item->note }}</p>
                                    @endif

                                    <div class="text-xs text-stone-600 font-semibold mt-1">
                                        Rp {{ number_format($item->price, 0, ',', '.') }} / item
                                    </div>
                                </div>
                            </div>

                            <!-- Quantity Controller & Subtotal -->
                            <div class="flex items-center justify-between sm:justify-end space-x-6 w-full sm:w-auto pt-3 sm:pt-0 border-t sm:border-t-0 border-stone-100">
                                <!-- Update Qty Form -->
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center border border-stone-200 rounded-xl bg-stone-50 p-1">
                                    @csrf
                                    <button type="submit" name="quantity" value="{{ max(1, $item->quantity - 1) }}" class="w-7 h-7 rounded-lg flex items-center justify-center text-stone-600 hover:bg-stone-200 font-bold text-xs">-</button>
                                    <span class="w-9 text-center text-xs font-bold text-stone-800">{{ $item->quantity }}</span>
                                    <button type="submit" name="quantity" value="{{ $item->quantity + 1 }}" class="w-7 h-7 rounded-lg flex items-center justify-center text-stone-600 hover:bg-stone-200 font-bold text-xs">+</button>
                                </form>

                                <!-- Subtotal per item -->
                                <div class="text-right min-w-[100px]">
                                    <span class="text-xs text-stone-400 block sm:hidden">Total Item:</span>
                                    <span class="font-serif font-bold text-stone-900 text-base">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Hapus kue ini dari keranjang?')" class="w-9 h-9 rounded-xl text-stone-400 hover:text-red-600 hover:bg-red-50 flex items-center justify-center transition-colors" title="Hapus Item">
                                        <i class="fa-solid fa-trash-can text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <!-- Continue Shopping Link -->
                    <div class="pt-2 flex justify-between items-center">
                        <a href="{{ route('products.index') }}" class="text-xs font-bold text-bakery-600 hover:text-bakery-700 flex items-center space-x-1.5">
                            <i class="fa-solid fa-arrow-left"></i>
                            <span>Tambah Menu Lainnya</span>
                        </a>
                    </div>
                </div>

                <!-- Right: Order Summary Card -->
                <div class="lg:col-span-4 bg-white rounded-3xl p-6 border border-stone-200/80 shadow-md space-y-5 sticky top-28">
                    <h2 class="font-serif font-bold text-xl text-chocolate border-b border-stone-100 pb-3">Ringkasan Belanja</h2>

                    <!-- Free shipping threshold progress -->
                    @php
                        $subtotal = $cart->total;
                        $freeShippingTarget = 200000;
                        $progress = min(100, round(($subtotal / $freeShippingTarget) * 100));
                        $gap = max(0, $freeShippingTarget - $subtotal);
                    @endphp
                    <div class="bg-amber-50 p-4 rounded-2xl border border-amber-200/60 text-xs">
                        @if($gap > 0)
                            <p class="font-bold text-bakery-800">
                                🚚 Tambah <strong>Rp {{ number_format($gap, 0, ',', '.') }}</strong> lagi untuk <strong>Gratis Ongkir!</strong>
                            </p>
                            <div class="w-full bg-amber-200 rounded-full h-2 mt-2 overflow-hidden">
                                <div class="bg-bakery-600 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
                            </div>
                        @else
                            <p class="font-bold text-emerald-800 flex items-center space-x-1.5">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i>
                                <span>Selamat! Pesanan Anda memenuhi syarat <strong>Gratis Ongkir</strong> 🎉</span>
                            </p>
                        @endif
                    </div>

                    <!-- Breakdown -->
                    <div class="space-y-3 text-sm text-stone-600">
                        <div class="flex justify-between">
                            <span>Total Item ({{ $cart->total_items }})</span>
                            <span class="font-bold text-stone-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Estimasi Ongkos Kirim</span>
                            <span class="text-stone-500 text-xs">Dihitung saat checkout</span>
                        </div>
                        <div class="border-t border-stone-200/80 pt-3 flex justify-between items-baseline">
                            <span class="font-bold text-chocolate text-base">Total Sementara</span>
                            <span class="font-serif font-extrabold text-2xl text-chocolate">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Checkout Button -->
                    @auth
                        <a href="{{ route('checkout.index') }}" class="w-full py-4 bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold rounded-2xl shadow-lg shadow-amber-600/30 hover:shadow-xl hover:scale-[1.01] transition-all flex items-center justify-center space-x-2 text-sm">
                            <span>Lanjut ke Pengiriman & Bayar</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    @else
                        <div class="space-y-2">
                            <a href="{{ route('login') }}" class="w-full py-4 bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold rounded-2xl shadow-lg shadow-amber-600/30 hover:scale-[1.01] transition-all flex items-center justify-center space-x-2 text-sm">
                                <span>Masuk Untuk Checkout</span>
                                <i class="fa-solid fa-lock"></i>
                            </a>
                            <p class="text-[11px] text-center text-stone-500">Belum punya akun? <a href="{{ route('register') }}" class="text-bakery-600 font-bold underline">Daftar di sini</a></p>
                        </div>
                    @endauth

                    <div class="pt-2 text-center">
                        <span class="text-[11px] text-stone-500 flex items-center justify-center space-x-1.5">
                            <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                            <span>Transaksi Terenkripsi & Dijamin 100% Aman</span>
                        </span>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
