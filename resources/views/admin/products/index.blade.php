@extends('layouts.admin')

@section('title', 'Katalog Produk — Khadijah Donat & Cake Admin')

@section('content')
    <div class="space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Manajemen Produk Kue</h1>
                <p class="text-xs text-slate-500 mt-1">Kelola daftar kue tart, pastry, cookies, harga, dan ketersediaan stok.</p>
            </div>
            
            <a href="{{ route('admin.products.create') }}" class="px-5 py-2.5 bg-bakery-600 hover:bg-bakery-700 text-white font-bold text-xs rounded-2xl shadow-md shadow-amber-500/20 transition-all flex items-center space-x-2">
                <i class="fa-solid fa-plus"></i>
                <span>Tambah Kue Baru</span>
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kue..." class="px-4 py-2 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-bakery-400">
                <select name="category" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-200 text-xs text-slate-700 font-semibold focus:ring-2 focus:ring-bakery-400">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" {{ request('category') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white font-bold text-xs rounded-xl">Cari</button>
            </form>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 text-slate-400 uppercase font-bold text-[10px] tracking-wider border-b border-slate-100">
                        <tr>
                            <th class="py-3 px-6">Kue</th>
                            <th class="py-3 px-6">Kategori</th>
                            <th class="py-3 px-6">Harga & Diskon</th>
                            <th class="py-3 px-6">Stok</th>
                            <th class="py-3 px-6">Status / Label</th>
                            <th class="py-3 px-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="py-4 px-6 flex items-center space-x-3">
                                    <img src="{{ $product->main_image }}" class="w-12 h-12 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                                    <div>
                                        <h4 class="font-bold text-slate-900 text-sm">{{ $product->name }}</h4>
                                        <p class="text-[11px] text-slate-400">{{ $product->sold_count }} Terjual • {{ $product->rating_avg }} ⭐</p>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-bakery-800 border border-amber-200">
                                        {{ $product->category->name }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($product->discount_price)
                                        <p class="font-bold text-slate-900">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</p>
                                        <p class="text-[10px] text-slate-400 line-through">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    @else
                                        <p class="font-bold text-slate-900">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-bold {{ $product->stock <= 5 ? 'text-rose-600' : 'text-slate-800' }}">
                                        {{ $product->stock }} pcs
                                    </span>
                                </td>
                                <td class="py-4 px-6 space-y-1">
                                    @if($product->is_best_seller)
                                        <span class="inline-block px-2 py-0.5 rounded text-[9px] font-extrabold bg-amber-500 text-white">BEST SELLER</span>
                                    @endif
                                    @if($product->is_featured)
                                        <span class="inline-block px-2 py-0.5 rounded text-[9px] font-extrabold bg-purple-500 text-white">FEATURED</span>
                                    @endif
                                    @if(!$product->is_active)
                                        <span class="inline-block px-2 py-0.5 rounded text-[9px] font-extrabold bg-slate-300 text-slate-700">NONAKTIF</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="px-3 py-1.5 bg-amber-50 text-bakery-700 hover:bg-amber-100 rounded-xl font-bold text-xs">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kue ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-xl font-bold text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-8 text-center text-slate-400">Belum ada produk kue yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="p-4 border-t border-slate-100">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
