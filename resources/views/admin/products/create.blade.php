@extends('layouts.admin')

@section('title', 'Tambah Kue Baru — Khadijah Donat & Cake Admin')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">
        
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900">Tambah Menu Kue Baru</h1>
                <p class="text-xs text-slate-500 mt-1">Lengkapi informasi foto, harga, dan resep bahan kue.</p>
            </div>
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl">
                ← Kembali
            </a>
        </div>

        <form action="{{ route('admin.products.store') }}" method="POST" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kue <span class="text-rose-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Basque Burnt Cheesecake" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori <span class="text-rose-500">*</span></label>
                    <select name="category_id" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">URL / Path Foto Utama Menu <span class="text-rose-500">*</span></label>
                    <input type="text" name="main_image" value="{{ old('main_image', '/images/products/donat-kentang.png') }}" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Normal (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="price" value="{{ old('price') }}" required min="0" placeholder="150000" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Harga Diskon Promo (Rp)</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" min="0" placeholder="Kosongkan jika tidak ada diskon" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Stok Tersedia <span class="text-rose-500">*</span></label>
                    <input type="number" name="stock" value="{{ old('stock', 10) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Min. Pre-Order (H- berapa hari?)</label>
                    <input type="number" name="min_order_days" value="{{ old('min_order_days', 0) }}" required min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                    <span class="text-[10px] text-slate-400">Isi 0 jika ready stock hari ini.</span>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap</label>
                    <textarea name="description" rows="3" placeholder="Ceritakan rasa, tekstur kelembutan, dan sensasi kue..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">{{ old('description') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Bahan-Bahan (Ingredients)</label>
                    <textarea name="ingredients" rows="2" placeholder="Tepung, French butter, Dark chocolate 70%, telur omega..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">{{ old('ingredients') }}</textarea>
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Informasi Alergen</label>
                    <input type="text" name="allergens" value="{{ old('allergens', 'Mengandung susu, telur, gluten.') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                </div>
            </div>

            <!-- Checkbox Badges -->
            <div class="pt-4 border-t border-slate-100 flex flex-wrap gap-6 text-sm">
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_best_seller" value="1" class="rounded text-bakery-600 focus:ring-bakery-400">
                    <span class="text-xs font-bold text-slate-700">Tandai Sebagai "Best Seller" 🔥</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" class="rounded text-bakery-600 focus:ring-bakery-400">
                    <span class="text-xs font-bold text-slate-700">Tampilkan di Beranda (Featured)</span>
                </label>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" checked class="rounded text-bakery-600 focus:ring-bakery-400">
                    <span class="text-xs font-bold text-slate-700">Aktif & Siap Dijual</span>
                </label>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-bakery-600 hover:bg-bakery-700 text-white font-bold text-sm rounded-2xl shadow-lg shadow-amber-500/20 transition-all">
                    Simpan Produk Kue
                </button>
            </div>
        </form>
    </div>
@endsection
