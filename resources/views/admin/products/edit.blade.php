@extends('layouts.admin')

@section('title', 'Edit ' . $product->name . ' — Khadijah Donat & Cake Admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Edit Produk: {{ $product->name }}</h1>
                <p class="text-xs text-slate-500 mt-1">Perbarui harga, stok, atau rincian deskripsi kue.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">
                ← Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kue <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori <span class="text-rose-500">*</span></label>
                    <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">URL Foto Utama Kue <span class="text-rose-500">*</span></label>
                    <input type="text" name="main_image" value="{{ old('main_image', $product->main_image) }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Normal (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price', (int)$product->price) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Diskon Promo (Rp)</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price', $product->discount_price ? (int)$product->discount_price : '') }}" min="0" placeholder="Kosongkan jika tidak ada diskon" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Stok Tersedia <span class="text-rose-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Min. Pre-Order (H- berapa hari?)</label>
                    <input type="number" name="min_order_days" value="{{ old('min_order_days', $product->min_order_days) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">{{ old('description', $product->description) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Bahan-Bahan (Ingredients)</label>
                    <textarea name="ingredients" rows="2" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">{{ old('ingredients', $product->ingredients) }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Informasi Alergen</label>
                    <input type="text" name="allergens" value="{{ old('allergens', $product->allergens) }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>
            </div>

            <!-- Checkbox Badges -->
            <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-6 text-sm">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_best_seller" value="1" {{ $product->is_best_seller ? 'checked' : '' }} class="rounded text-bakery-600 focus:ring-bakery-400">
                    <span class="text-xs font-bold text-slate-700">Tandai Sebagai "Best Seller" 🔥</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded text-bakery-600 focus:ring-bakery-400">
                    <span class="text-xs font-bold text-slate-700">Tampilkan di Beranda (Featured)</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded text-bakery-600 focus:ring-bakery-400">
                    <span class="text-xs font-bold text-slate-700">Aktif & Siap Dijual</span>
                </label>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-bakery-600 hover:bg-bakery-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
