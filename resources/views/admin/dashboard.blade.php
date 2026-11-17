@extends('layouts.admin')

@section('title', 'Dashboard Penjualan — Khadijah Donat & Cake Admin')

@section('content')
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Dashboard Penjualan</h1>
                <p class="text-xs text-slate-500 mt-1">Ringkasan performa pesanan dan operasional toko kue hari ini.</p>
            </div>
            
            <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 bg-bakery-600 hover:bg-bakery-700 text-white font-bold text-xs rounded-2xl shadow-md shadow-amber-500/20 transition-all flex items-center space-x-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Produk Baru</span>
            </a>
        </div>

        <!-- 5 Key Metrics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <!-- Total Revenue -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Penjualan</span>
                    <h3 class="text-xl font-extrabold text-slate-900 mt-1">
                        Rp {{ number_format($totalSales, 0, ',', '.') }}
                    </h3>
                    <p class="text-[11px] text-emerald-600 font-bold mt-1">Dari semua pesanan masuk</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-bakery-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-money-bill-trend-up"></i>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Pesanan</span>
                    <h3 class="text-xl font-extrabold text-slate-900 mt-1">{{ $totalOrders }} Pesanan</h3>
                    <p class="text-[11px] text-slate-500 mt-1">Termasuk pick-up & delivery</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-bag-shopping"></i>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Perlu Diproses</span>
                    <h3 class="text-xl font-extrabold text-amber-600 mt-1">{{ $pendingOrders }} Pesanan</h3>
                    <p class="text-[11px] text-amber-600 font-bold mt-1">Menunggu verifikasi / bayar</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>

            <!-- Products in Catalog -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Menu Kue Aktif</span>
                    <h3 class="text-xl font-extrabold text-slate-900 mt-1">{{ $totalProducts }} Produk</h3>
                    <p class="text-[11px] text-slate-500 mt-1">{{ $totalCustomers }} Pelanggan terdaftar</p>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    <i class="fa-solid fa-cake-candles"></i>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-extrabold text-slate-900">Pesanan Masuk Terbaru</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Pantau dan verifikasi pembayaran pesanan kue secara langsung.</p>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-bakery-600 hover:text-bakery-700">
                    Lihat Semua Pesanan →
                </a>
            </div>

            @if($recentOrders->isEmpty())
                <div class="p-8 text-center text-slate-400 text-xs">
                    Belum ada transaksi pesanan yang masuk.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-400 uppercase font-bold text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-6">No. Pesanan</th>
                                <th class="py-3 px-6">Pelanggan</th>
                                <th class="py-3 px-6">Jadwal & Pengiriman</th>
                                <th class="py-3 px-6">Total</th>
                                <th class="py-3 px-6">Status</th>
                                <th class="py-3 px-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($recentOrders as $ord)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-4 px-6 font-mono font-bold text-slate-800">
                                        #{{ $ord->order_number }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-bold text-slate-800">{{ $ord->user->name }}</p>
                                        <p class="text-slate-400 text-[11px]">{{ $ord->user->email }}</p>
                                    </td>
                                    <td class="py-4 px-6">
                                        <p class="font-semibold text-slate-700">{{ $ord->delivery_date->format('d M Y') }}</p>
                                        <p class="text-slate-400 text-[10px] uppercase">{{ $ord->delivery_type === 'pickup' ? 'Ambil di Toko' : 'Delivery' }}</p>
                                    </td>
                                    <td class="py-4 px-6 font-bold text-slate-900">
                                        Rp {{ number_format($ord->total, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-{{ $ord->status_color }}-100 text-{{ $ord->status_color }}-800 border border-{{ $ord->status_color }}-200">
                                            {{ $ord->status_label }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <a href="{{ route('admin.orders.show', $ord->id) }}" class="px-3 py-1.5 bg-slate-100 hover:bg-bakery-600 hover:text-white rounded-xl text-slate-700 font-bold text-xs transition-colors">
                                            Detail & Kelola
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Low Stock Warning -->
        @if($lowStockProducts->isNotEmpty())
            <div class="bg-amber-50 border border-amber-200 rounded-3xl p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-8 h-8 rounded-xl bg-amber-500 text-white flex items-center justify-center text-sm font-bold">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-amber-900">Peringatan Stok Kue Menipis</h3>
                        <p class="text-xs text-amber-700">Segera restock produk kue di bawah ini agar pelanggan tetap dapat memesan.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                    @foreach($lowStockProducts as $low)
                        <div class="bg-white p-3 rounded-2xl border border-amber-200/80 flex items-center justify-between">
                            <div class="truncate mr-2">
                                <p class="text-xs font-bold text-slate-800 truncate">{{ $low->name }}</p>
                                <p class="text-[10px] text-rose-600 font-bold">Sisa Stok: {{ $low->stock }} pcs</p>
                            </div>
                            <a href="{{ route('admin.products.edit', $low->id) }}" class="text-[11px] font-bold text-bakery-600 hover:underline">Edit</a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
