@extends('layouts.frontend')

@section('title', 'Riwayat Pesanan Saya — Khadijah Donat & Cake')

@section('content')
    <div class="bg-gradient-to-b from-amber-100/60 to-[#FAF8F5] py-8 border-b border-stone-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-chocolate">Riwayat Pesanan Saya</h1>
            <p class="text-sm text-stone-600 mt-1">Pantau status pesanan kue tart, pastry, dan transaksi Anda di sini.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-stone-200/80 shadow-sm max-w-md mx-auto my-10">
                <div class="w-16 h-16 rounded-full bg-amber-50 text-bakery-600 flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <h3 class="font-serif font-bold text-xl text-chocolate">Belum Ada Pesanan</h3>
                <p class="text-xs text-stone-500 mt-2">Anda belum pernah melakukan pemesanan kue. Silakan jelajahi katalog kue kami yang lezat.</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-5 px-6 py-2.5 bg-bakery-600 text-white font-bold rounded-2xl text-xs shadow hover:bg-bakery-700 transition-all">
                    Lihat Katalog Kue
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="bg-white rounded-3xl p-6 border border-stone-200/80 shadow-sm hover:border-bakery-300 transition-all">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-stone-100 pb-4">
                            <div class="flex items-center space-x-3">
                                <span class="font-mono text-sm font-bold text-stone-800">#{{ $order->order_number }}</span>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-{{ $order->status_color }}-100 text-{{ $order->status_color }}-800 border border-{{ $order->status_color }}-300">
                                    {{ $order->status_label }}
                                </span>
                            </div>
                            <span class="text-xs text-stone-400">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>

                        <div class="py-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <p class="text-xs font-bold text-stone-700">
                                    {{ $order->items->pluck('product_name')->implode(', ') }}
                                </p>
                                <p class="text-[11px] text-stone-500">
                                    Jadwal: {{ $order->delivery_date->format('d M Y') }} ({{ $order->delivery_time }}) • {{ $order->delivery_type === 'pickup' ? 'Ambil Sendiri' : 'Pengantaran Kurir' }}
                                </p>
                            </div>

                            <div class="text-left sm:text-right">
                                <span class="text-xs text-stone-400 block">Total Tagihan:</span>
                                <span class="font-serif font-extrabold text-lg text-chocolate">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <div class="pt-3 border-t border-stone-100 flex items-center justify-end space-x-3">
                            <a href="{{ route('orders.show', $order->order_number) }}" class="px-5 py-2 bg-bakery-50 hover:bg-bakery-100 text-bakery-800 font-bold text-xs rounded-xl border border-bakery-200 transition-all flex items-center space-x-1.5">
                                <span>Lihat Detail & Status</span>
                                <i class="fa-solid fa-arrow-right text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $orders->links() }}
            </div>
        @endif
    </div>
@endsection
