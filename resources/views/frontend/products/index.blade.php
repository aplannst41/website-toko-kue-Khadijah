@extends('layouts.frontend')

@section('title', 'Katalog Kue & Pastry — Khadijah Donat & Cake')

@section('content')
    <!-- Header Banner -->
    <div class="bg-gradient-to-b from-amber-100/60 to-[#FAF8F5] py-10 border-b border-stone-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center sm:text-left">
            <span class="text-xs font-bold text-bakery-600 uppercase tracking-widest">Semua Menu</span>
            <h1 class="font-serif text-3xl sm:text-4xl font-bold text-chocolate mt-1">Katalog Kue & Pastry</h1>
            <p class="text-sm text-stone-600 mt-2">Pilih dari aneka kue tart ulang tahun, croissant wangi, cookies toples, dan dessert box lumer.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Filter & Search Bar -->
        <div class="bg-white p-5 rounded-3xl border border-stone-200/80 shadow-sm mb-8">
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-center justify-between">
                <!-- Search Input -->
                <div class="relative w-full md:w-80">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-stone-400"></i>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kue, bahan..." class="w-full pl-11 pr-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                </div>

                <!-- Category Pills (Horizontal scroll on mobile) -->
                <div class="flex items-center space-x-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-none">
                    <a href="{{ route('products.index', array_merge(request()->except(['category', 'page']))) }}" class="px-4 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition-all {{ !request('category') ? 'bg-bakery-600 text-white shadow-md' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('products.index', array_merge(request()->except(['page']), ['category' => $cat->slug])) }}" class="px-4 py-2 rounded-2xl text-xs font-bold whitespace-nowrap transition-all {{ request('category') === $cat->slug ? 'bg-bakery-600 text-white shadow-md' : 'bg-stone-100 text-stone-600 hover:bg-stone-200' }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Sorting Dropdown -->
                <div class="w-full md:w-auto flex items-center justify-end">
                    <select name="sort" onchange="this.form.submit()" class="w-full md:w-auto py-2.5 pl-3 pr-8 rounded-2xl border border-stone-200 text-xs font-bold text-stone-700 focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="best-seller" {{ request('sort') == 'best-seller' ? 'selected' : '' }}>Paling Laris 🔥</option>
                        <option value="price-asc" {{ request('sort') == 'price-asc' ? 'selected' : '' }}>Harga: Termurah</option>
                        <option value="price-desc" {{ request('sort') == 'price-desc' ? 'selected' : '' }}>Harga: Tertinggi</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Rating Tertinggi ⭐</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Product Grid -->
        @if($products->isEmpty())
            <div class="bg-white rounded-3xl p-12 text-center border border-stone-200/80 shadow-sm max-w-lg mx-auto my-8">
                <div class="w-16 h-16 rounded-full bg-amber-100 text-bakery-600 flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class="fa-solid fa-cookie"></i>
                </div>
                <h3 class="font-serif font-bold text-xl text-chocolate">Kue Tidak Ditemukan</h3>
                <p class="text-sm text-stone-500 mt-2">Maaf, tidak ada produk yang cocok dengan pencarian Anda. Coba kata kunci lain atau reset filter kategori.</p>
                <a href="{{ route('products.index') }}" class="inline-block mt-5 px-6 py-2.5 bg-bakery-600 text-white font-bold rounded-2xl text-xs shadow hover:bg-bakery-700 transition-all">
                    Reset Semua Filter
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                @foreach($products as $product)
                    <div class="bg-white rounded-3xl overflow-hidden border border-stone-200/80 hover:shadow-2xl hover:border-bakery-300 transition-all duration-300 flex flex-col group">
                        <!-- Image & Badges -->
                        <div class="relative h-60 overflow-hidden bg-stone-100">
                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                @if($product->is_best_seller)
                                    <span class="bg-amber-600 text-white text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full shadow-md">
                                        Best Seller
                                    </span>
                                @endif
                                @if($product->discount_price)
                                    <span class="bg-rose-600 text-white text-[10px] font-extrabold uppercase px-2.5 py-1 rounded-full shadow-md">
                                        Hemat {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    </span>
                                @endif
                            </div>

                            @if($product->stock <= 0)
                                <div class="absolute inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center">
                                    <span class="bg-stone-900 text-white text-xs font-bold px-3 py-1.5 rounded-full">Stok Habis</span>
                                </div>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="p-5 flex flex-col flex-grow justify-between">
                            <div>
                                <span class="text-[11px] font-bold text-bakery-600 uppercase tracking-wider">{{ $product->category->name }}</span>
                                <h3 class="font-serif font-bold text-stone-900 text-lg mt-1 line-clamp-1 group-hover:text-bakery-600 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <p class="text-xs text-stone-500 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $product->description }}
                                </p>

                                <div class="flex items-center space-x-2 mt-3 text-xs text-stone-500">
                                    <span class="flex items-center text-amber-500 font-bold">
                                        <i class="fa-solid fa-star mr-1"></i> {{ number_format($product->rating_avg, 1) }}
                                    </span>
                                    <span>•</span>
                                    <span>{{ $product->sold_count }} Terjual</span>
                                    <span>•</span>
                                    <span class="{{ $product->stock > 5 ? 'text-emerald-600' : 'text-amber-600 font-bold' }}">
                                        {{ $product->stock > 0 ? "Stok: {$product->stock}" : 'Habis' }}
                                    </span>
                                </div>
                            </div>

                            <div class="pt-4 mt-4 border-t border-stone-100 flex items-center justify-between">
                                <div>
                                    @if($product->variants->isNotEmpty())
                                        <span class="text-[10px] text-bakery-600 font-bold uppercase tracking-wider block">Mulai dari</span>
                                    @endif
                                    @if($product->discount_price)
                                        <span class="text-xs text-stone-400 line-through block">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-lg font-extrabold text-chocolate font-serif">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-lg font-extrabold text-chocolate font-serif">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                <a href="{{ route('products.show', $product->slug) }}" class="px-4 py-2 rounded-2xl bg-bakery-600 hover:bg-bakery-700 text-white font-bold text-xs shadow-md shadow-amber-500/20 hover:scale-105 transition-all flex items-center space-x-1.5">
                                    <span>Detail</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
