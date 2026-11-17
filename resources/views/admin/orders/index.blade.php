@extends('layouts.admin')

@section('title', 'Manajemen Pesanan — Khadijah Donat & Cake Admin')

@section('content')
    <div class="space-y-6">
        
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Kelola Pesanan Masuk</h1>
                <p class="text-xs text-slate-500 mt-1">Verifikasi pembayaran, proses pembuatan kue, dan atur jadwal pengiriman.</p>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="flex items-center space-x-2 overflow-x-auto pb-2 scrollbar-none">
            @php
                $currentStatus = request('status');
                $statuses = [
                    '' => 'Semua Pesanan',
                    'pending' => 'Menunggu Pembayaran',
                    'paid' => 'Perlu Verifikasi Bukti',
                    'verified' => 'Terverifikasi',
                    'processing' => 'Sedang Diproses',
                    'ready' => 'Siap Dikirim / Diambil',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ];
            @endphp

            @foreach($statuses as $st => $label)
                <a href="{{ route('admin.orders.index', $st ? ['status' => $st] : []) }}" class="px-4 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition-all {{ $currentStatus === $st || (!$currentStatus && $st === '') ? 'bg-bakery-600 text-white shadow-md' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-100' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <!-- Search Order -->
        <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-sm">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-3">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nomor pesanan #SCB-... atau nama pelanggan..." class="w-full sm:w-80 px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-bakery-400">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <button type="submit" class="px-5 py-2 bg-slate-900 text-white font-bold text-xs rounded-xl hover:bg-slate-800">Cari</button>
            </form>
        </div>

        <!-- Orders Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-400 uppercase font-bold text-[10px] tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3.5 px-6">No. Pesanan</th>
                            <th class="py-3.5 px-6">Pelanggan</th>
                            <th class="py-3.5 px-6">Pengiriman & Jadwal</th>
                            <th class="py-3.5 px-6">Total Tagihan</th>
                            <th class="py-3.5 px-6">Status Pesanan</th>
                            <th class="py-3.5 px-6">Bukti Transfer</th>
                            <th class="py-3.5 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($orders as $ord)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-6 font-mono font-bold text-slate-900">
                                    #{{ $ord->order_number }}
                                    <span class="text-[10px] text-slate-400 block font-sans font-normal">{{ $ord->created_at->format('d/m/Y H:i') }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <p class="font-bold text-slate-800">{{ $ord->user->name }}</p>
                                    <p class="text-slate-400 text-[11px]">{{ $ord->user->email }}</p>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-block px-2 py-0.5 rounded text-[10px] font-extrabold uppercase {{ $ord->delivery_type === 'pickup' ? 'bg-amber-100 text-bakery-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $ord->delivery_type === 'pickup' ? 'Ambil di Outlet' : 'Delivery Kurir' }}
                                    </span>
                                    <p class="text-[11px] font-semibold text-slate-700 mt-1">{{ $ord->delivery_date->format('d M Y') }} ({{ $ord->delivery_time }})</p>
                                </td>
                                <td class="py-4 px-6 font-bold text-slate-900 font-serif text-sm">
                                    Rp {{ number_format($ord->total, 0, ',', '.') }}
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-extrabold uppercase bg-{{ $ord->status_color }}-100 text-{{ $ord->status_color }}-800 border border-{{ $ord->status_color }}-200">
                                        {{ $ord->status_label }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($ord->payment && $ord->payment->proof_image)
                                        <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                            <i class="fa-solid fa-image mr-1"></i> Ada Bukti
                                        </span>
                                    @else
                                        <span class="text-slate-400 text-[11px] italic">Belum Ada</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('admin.orders.show', $ord->id) }}" class="px-4 py-2 bg-bakery-50 text-bakery-800 hover:bg-bakery-600 hover:text-white rounded-xl font-bold text-xs transition-colors">
                                        Detail & Proses →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-8 text-center text-slate-400">Tidak ada pesanan yang sesuai dengan filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
