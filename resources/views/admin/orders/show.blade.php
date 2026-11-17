@extends('layouts.admin')

@section('title', 'Kelola Pesanan #' . $order->order_number . ' — Khadijah Donat & Cake Admin')

@section('content')
    <div class="space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-extrabold text-slate-900">Pesanan #{{ $order->order_number }}</h1>
                    <span class="px-3 py-1 rounded-full text-xs font-extrabold uppercase bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 border border-{{ $order->status_color }}-200">
                        {{ $order->status_label }}
                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1">Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB</p>
            </div>

            <a href="{{ route('admin.orders.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">
                ← Kembali ke Daftar Pesanan
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 8 Columns: Detail Item & Pengiriman -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Items Box -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-base font-extrabold text-slate-900 border-b border-slate-100 pb-3">Daftar Kue Yang Dipesan</h2>

                    <div class="space-y-4 divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <div class="pt-3 first:pt-0 flex items-start justify-between">
                                <div class="flex items-start space-x-3">
                                    <img src="{{ $item->product->main_image ?? 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=200' }}" class="w-14 h-14 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                                    <div>
                                        <h4 class="font-bold text-sm text-slate-900">{{ $item->product_name }}</h4>
                                        @if($item->variant_info)
                                            <div class="mt-0.5">
                                                <span class="text-xs text-amber-800 bg-amber-50 px-2 py-0.5 rounded font-semibold inline-block border border-amber-200">
                                                    🍕 {{ $item->variant_info }}
                                                </span>
                                            </div>
                                        @endif
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        
                                        @if($item->cake_text)
                                            <div class="mt-1 text-xs text-amber-800 bg-amber-50 px-2 py-0.5 rounded font-medium inline-block">
                                                🎂 Tulisan di Kue: <strong>"{{ $item->cake_text }}"</strong>
                                            </div>
                                        @endif
                                        @if($item->note)
                                            <p class="text-[11px] text-slate-500 italic mt-0.5">Catatan: {{ $item->note }}</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-bold text-sm text-slate-900 font-serif">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    <div class="pt-4 border-t border-slate-100 space-y-2 text-xs">
                        <div class="flex justify-between text-slate-600">
                            <span>Subtotal Menu</span>
                            <span class="font-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-slate-600">
                            <span>Ongkos Kirim</span>
                            <span class="font-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-base font-extrabold text-slate-900 pt-2 border-t border-slate-100">
                            <span>Total Pesanan</span>
                            <span class="text-bakery-700 font-serif">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Customer & Delivery Info -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <h2 class="text-base font-extrabold text-slate-900 border-b border-slate-100 pb-3">Informasi Pelanggan & Pengiriman</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div class="p-4 bg-slate-50 rounded-2xl space-y-1">
                            <span class="text-slate-400 font-bold uppercase text-[10px]">Data Akun Pemesan:</span>
                            <p class="font-bold text-slate-800 text-sm">{{ $order->user->name }}</p>
                            <p class="text-slate-500">{{ $order->user->email }} • {{ $order->user->phone ?? '-' }}</p>
                        </div>

                        <div class="p-4 bg-slate-50 rounded-2xl space-y-1">
                            <span class="text-slate-400 font-bold uppercase text-[10px]">Jadwal Pelaksanaan:</span>
                            <p class="font-bold text-slate-800 text-sm">{{ $order->delivery_date->format('d M Y') }}</p>
                            <p class="text-slate-500">{{ $order->delivery_time }} ({{ $order->delivery_type === 'pickup' ? 'Ambil di Toko' : 'Kirim Kurir' }})</p>
                        </div>

                        @if($order->shippingAddress)
                            <div class="sm:col-span-2 p-4 bg-slate-50 rounded-2xl space-y-1">
                                <span class="text-slate-400 font-bold uppercase text-[10px]">Alamat Pengiriman Tujuan:</span>
                                <p class="font-bold text-slate-800 text-sm">{{ $order->shippingAddress->recipient_name }} — {{ $order->shippingAddress->phone }}</p>
                                <p class="text-slate-600 mt-1">{{ $order->shippingAddress->address }}, {{ $order->shippingAddress->district }}, {{ $order->shippingAddress->city }}</p>
                            </div>
                        @endif

                        @if($order->note)
                            <div class="sm:col-span-2 p-4 bg-amber-50 rounded-2xl space-y-1">
                                <span class="text-bakery-800 font-bold uppercase text-[10px]">Catatan Khusus Pelanggan:</span>
                                <p class="text-slate-700 italic">{{ $order->note }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right 4 Columns: Actions & Status Management -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Status Updater -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-sm font-extrabold text-slate-900 border-b border-slate-100 pb-3">Update Status Pesanan</h3>

                    <form action="{{ route('admin.orders.status', $order->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label class="block text-xs font-bold text-slate-600 mb-1">Ubah Status Ke:</label>
                            <select name="status" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-xs font-bold focus:ring-2 focus:ring-bakery-400">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Menunggu Verifikasi Bukti</option>
                                <option value="verified" {{ $order->status === 'verified' ? 'selected' : '' }}>Pembayaran Terverifikasi</option>
                                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Sedang Diproses/Dipanggang</option>
                                <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Siap Diambil / Dikirim</option>
                                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Sedang Dikirim Kurir</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>

                        <button type="submit" class="w-full py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs rounded-xl transition-all">
                            Simpan Perubahan Status
                        </button>
                    </form>
                </div>

                <!-- Payment Verification Box -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                    <h3 class="text-sm font-extrabold text-slate-900 border-b border-slate-100 pb-3">Verifikasi Pembayaran</h3>

                    @if($order->payment && $order->payment->proof_image)
                        <div class="space-y-3">
                            <span class="text-xs text-slate-500 block">Foto Struk Transfer Customer:</span>
                            <div class="rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 max-h-56">
                                <a href="{{ asset('storage/' . $order->payment->proof_image) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $order->payment->proof_image) }}" alt="Bukti Transfer" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                </a>
                            </div>

                            <form action="{{ route('admin.orders.verify_payment', $order->id) }}" method="POST" class="space-y-3 pt-2">
                                @csrf
                                <input type="text" name="admin_note" placeholder="Catatan admin (misal: dana masuk di BCA)..." class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs">
                                
                                <div class="grid grid-cols-2 gap-2">
                                    <button type="submit" name="status" value="verified" class="py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition-all">
                                        ✓ Verifikasi Valid
                                    </button>
                                    <button type="submit" name="status" value="rejected" class="py-2.5 bg-rose-50 text-rose-700 hover:bg-rose-100 font-bold text-xs rounded-xl transition-all">
                                        ✗ Tolak Bukti
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="p-4 bg-slate-50 rounded-2xl text-center text-xs text-slate-400">
                            Customer belum mengunggah foto bukti pembayaran.
                        </div>
                    @endif
                </div>

                <!-- Hubungi Customer WA -->
                <div class="bg-emerald-50 border border-emerald-200 rounded-3xl p-5 space-y-3 text-center">
                    <i class="fa-brands fa-whatsapp text-3xl text-emerald-600"></i>
                    <h4 class="text-xs font-bold text-emerald-900">Hubungi Pelanggan</h4>
                    <p class="text-[11px] text-emerald-700">Kirim notifikasi atau konfirmasi tulisan di kue melalui WhatsApp.</p>
                    
                    @php
                        $phone = $order->shippingAddress->phone ?? ($order->user->phone ?? '6281234567890');
                        $phone = preg_replace('/^0/', '62', $phone);
                    @endphp
                    <a href="https://wa.me/{{ $phone }}?text=Halo%20kak%20{{ urlencode($order->user->name) }},%20terima%20kasih%20telah%20memesan%20kue%20di%20Khadijah%20Donat%20%26%20Cake%20dengan%20no%20pesanan%20*{{ $order->order_number }}*." target="_blank" class="inline-block w-full py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow transition-all">
                        Chat WhatsApp Pelanggan
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
