@extends('layouts.admin')

@section('title', 'Kategori Kue — Khadijah Donat & Cake Admin')

@section('content')
    <div class="space-y-6">
        
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Kategori Kue & Pastry</h1>
            <p class="text-xs text-slate-500 mt-1">Atur pengelompokan menu agar pelanggan mudah menemukan kue yang dicari.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left 5 Columns: Tambah Kategori Form -->
            <div class="lg:col-span-5 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-sm space-y-4">
                <h2 class="text-base font-extrabold text-slate-900 border-b border-slate-100 pb-3">Tambah Kategori Baru</h2>

                <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" name="name" required placeholder="Contoh: Choux & Eclair" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Singkat</label>
                        <textarea name="description" rows="2" placeholder="Deskripsi jenis kue..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400"></textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Urutan Tampil (Sort Order)</label>
                        <input type="number" name="sort_order" value="1" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-bakery-400">
                    </div>

                    <button type="submit" class="w-full py-3 bg-bakery-600 hover:bg-bakery-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                        Simpan Kategori
                    </button>
                </form>
            </div>

            <!-- Right 7 Columns: Daftar Kategori Table -->
            <div class="lg:col-span-7 bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="p-5 border-b border-slate-100">
                    <h3 class="text-sm font-extrabold text-slate-900">Daftar Kategori Aktif</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-400 uppercase font-bold text-[10px] tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="py-3 px-5">Nama Kategori</th>
                                <th class="py-3 px-5">Slug</th>
                                <th class="py-3 px-5">Jumlah Produk</th>
                                <th class="py-3 px-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($categories as $cat)
                                <tr class="hover:bg-slate-50/60 transition-colors">
                                    <td class="py-3.5 px-5 font-bold text-slate-800">
                                        {{ $cat->name }}
                                        <p class="text-[11px] text-slate-400 font-normal">{{ $cat->description }}</p>
                                    </td>
                                    <td class="py-3.5 px-5 font-mono text-slate-500 text-[11px]">
                                        {{ $cat->slug }}
                                    </td>
                                    <td class="py-3.5 px-5">
                                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px]">
                                            {{ $cat->products_count }} Produk
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-5 text-right">
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold p-1">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
