@extends('layouts.frontend')

@section('title', $product->name . ' — Khadijah Donat & Cake')

@section('content')
    <!-- Breadcrumb -->
    <div class="bg-[#F6F3EE] py-4 border-b border-stone-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center space-x-2 text-xs font-semibold text-stone-500">
                <a href="{{ route('home') }}" class="hover:text-bakery-600">Beranda</a>
                <span>/</span>
                <a href="{{ route('products.index') }}" class="hover:text-bakery-600">Katalog Kue</a>
                <span>/</span>
                <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-bakery-600">{{ $product->category->name }}</a>
                <span>/</span>
                <span class="text-chocolate font-bold truncate max-w-xs">{{ $product->name }}</span>
            </nav>
        </div>
    </div>

    <!-- Product Detail Container -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
            
            <!-- Left: Product Main Image & Thumbnails -->
            <div class="lg:col-span-6 space-y-4" x-data="{ activeImage: '{{ $product->main_image }}' }">
                <div class="relative bg-white rounded-3xl overflow-hidden border border-stone-200/80 shadow-lg h-[400px] sm:h-[480px]">
                    <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    
                    @if($product->discount_price)
                        <div class="absolute top-4 left-4 bg-rose-600 text-white text-xs font-extrabold uppercase px-3 py-1.5 rounded-full shadow-md">
                            Hemat {{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                        </div>
                    @endif
                </div>

                <!-- Gallery Thumbnails (if any extra images exist) -->
                <div class="flex items-center space-x-3 overflow-x-auto pb-2">
                    <button @click="activeImage = '{{ $product->main_image }}'" class="w-20 h-20 rounded-2xl overflow-hidden border-2 transition-all flex-shrink-0" :class="activeImage === '{{ $product->main_image }}' ? 'border-bakery-600 scale-105 shadow-md' : 'border-stone-200 opacity-70 hover:opacity-100'">
                        <img src="{{ $product->main_image }}" class="w-full h-full object-cover">
                    </button>
                    @foreach($product->images as $img)
                        <button @click="activeImage = '{{ asset('storage/' . $img->image_path) }}'" class="w-20 h-20 rounded-2xl overflow-hidden border-2 transition-all flex-shrink-0" :class="activeImage === '{{ asset('storage/' . $img->image_path) }}' ? 'border-bakery-600 scale-105 shadow-md' : 'border-stone-200 opacity-70 hover:opacity-100'">
                            <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Right: Product Info & Order Form -->
            <div class="lg:col-span-6 space-y-6" x-data="{
                selectedVariantId: '{{ $product->variants->first()?->id ?? '' }}',
                basePrice: {{ (float) ($product->discount_price ?? $product->price) }},
                variants: {{ $product->variants->map(fn($v) => [
                    'id' => $v->id,
                    'type' => $v->type,
                    'value' => $v->value,
                    'price_addition' => (float)$v->price_addition,
                    'final_price' => (float)($product->discount_price ?? $product->price) + (float)$v->price_addition,
                ])->toJson() }},
                get currentPrice() {
                    if (!this.selectedVariantId || this.variants.length === 0) {
                        return this.basePrice;
                    }
                    const v = this.variants.find(item => item.id == this.selectedVariantId);
                    return v ? (this.basePrice + v.price_addition) : this.basePrice;
                },
                get formattedPrice() {
                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(this.currentPrice);
                },
                get selectedVariantObj() {
                    return this.variants.find(item => item.id == this.selectedVariantId);
                }
            }">
                <div>
                    <span class="inline-block px-3 py-1 bg-amber-100 text-bakery-700 text-xs font-extrabold uppercase tracking-wider rounded-full mb-2">
                        {{ $product->category->name }}
                    </span>
                    <h1 class="font-serif text-3xl sm:text-4xl font-bold text-chocolate leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center space-x-3 mt-3 text-sm">
                        <div class="flex items-center text-amber-500">
                            <i class="fa-solid fa-star"></i>
                            <span class="font-bold ml-1 text-stone-800">{{ number_format($product->rating_avg, 1) }}</span>
                        </div>
                        <span class="text-stone-300">|</span>
                        <span class="text-stone-500">{{ $product->sold_count }} Terjual</span>
                        <span class="text-stone-300">|</span>
                        <span class="{{ $product->stock > 0 ? 'text-emerald-600 font-bold' : 'text-rose-600 font-bold' }}">
                            {{ $product->stock > 0 ? "Stok Tersedia ({$product->stock})" : 'Habis' }}
                        </span>
                    </div>
                </div>

                <!-- Price Card -->
                <div class="p-5 bg-white rounded-3xl border border-amber-200/80 shadow-sm flex items-center justify-between">
                    <div>
                        <span class="text-xs text-stone-500 font-medium block">
                            @if($product->variants->isNotEmpty())
                                Harga untuk <span class="font-bold text-bakery-600" x-text="selectedVariantObj ? selectedVariantObj.value : ''"></span>:
                            @else
                                Harga Satuan:
                            @endif
                        </span>
                        <div class="flex items-baseline space-x-3 mt-1">
                            <span class="font-serif text-3xl font-extrabold text-chocolate" x-text="formattedPrice">
                                Rp {{ number_format($product->active_price, 0, ',', '.') }}
                            </span>
                            @if($product->discount_price)
                                <span class="text-sm text-stone-400 line-through">
                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    </div>
                    @if($product->min_order_days > 0)
                        <div class="text-right">
                            <span class="text-xs font-bold text-bakery-700 bg-amber-50 px-3 py-1.5 rounded-xl border border-amber-200">
                                <i class="fa-regular fa-clock mr-1"></i> Pre-Order H-{{ $product->min_order_days }}
                            </span>
                        </div>
                    @else
                        <div class="text-right">
                            <span class="text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-xl border border-emerald-200">
                                <i class="fa-solid fa-bolt mr-1"></i> Ready Stock
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <h3 class="text-xs font-bold text-stone-500 uppercase tracking-wider">Deskripsi Menu</h3>
                    <p class="text-sm text-stone-700 leading-relaxed">
                        {{ $product->description }}
                    </p>
                </div>

                <!-- Ingredients & Allergens Accordion/Card -->
                @if($product->ingredients || $product->allergens)
                    <div class="bg-[#F8F5F0] p-4 rounded-2xl border border-stone-200/80 space-y-2 text-xs">
                        @if($product->ingredients)
                            <div>
                                <span class="font-bold text-stone-800"><i class="fa-solid fa-kitchen-set mr-1 text-bakery-600"></i> Komposisi Bahan:</span>
                                <p class="text-stone-600 mt-0.5">{{ $product->ingredients }}</p>
                            </div>
                        @endif
                        @if($product->allergens)
                            <div class="pt-2 border-t border-stone-200/60">
                                <span class="font-bold text-rose-700"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Informasi Alergen:</span>
                                <p class="text-stone-600 mt-0.5">{{ $product->allergens }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add') }}" method="POST" class="space-y-4 pt-2">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="product_variant_id" :value="selectedVariantId">

                    <!-- Variant / Size Selection (Pizza Size, Donat Portion, etc.) -->
                    @if($product->variants->isNotEmpty())
                        <div class="space-y-3 bg-gradient-to-br from-amber-50/70 to-orange-50/40 p-4 sm:p-5 rounded-3xl border border-amber-200/90 shadow-sm">
                            <div class="flex items-center justify-between">
                                <label class="block text-xs font-bold text-stone-800 uppercase tracking-wider flex items-center space-x-1.5">
                                    <i class="fa-solid fa-pizza-slice text-bakery-600"></i>
                                    <span>Pilih {{ $product->variants->first()->type ?? 'Ukuran' }}:</span>
                                </label>
                                <span class="text-[11px] text-bakery-700 font-semibold bg-white/90 px-2 py-0.5 rounded-lg border border-amber-200">
                                    Wajib Dipilih
                                </span>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                                @foreach($product->variants as $variant)
                                    @php
                                        $variantPrice = ($product->discount_price ?? $product->price) + $variant->price_addition;
                                    @endphp
                                    <button type="button" 
                                        @click="selectedVariantId = {{ $variant->id }}"
                                        class="p-3.5 rounded-2xl border-2 text-left transition-all duration-200 relative flex items-center justify-between group cursor-pointer"
                                        :class="selectedVariantId == {{ $variant->id }} 
                                            ? 'border-bakery-600 bg-white shadow-md ring-2 ring-bakery-400/20' 
                                            : 'border-stone-200 bg-white/80 hover:border-amber-300 hover:bg-white'">
                                        <div class="pr-2">
                                            <span class="text-xs font-bold text-stone-900 group-hover:text-bakery-600 transition-colors block">
                                                {{ $variant->value }}
                                            </span>
                                            <span class="text-sm font-extrabold text-chocolate font-serif block mt-1">
                                                Rp {{ number_format($variantPrice, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="w-6 h-6 rounded-full flex items-center justify-center border-2 transition-all flex-shrink-0"
                                            :class="selectedVariantId == {{ $variant->id }} ? 'bg-bakery-600 border-bakery-600 text-white' : 'border-stone-300 text-transparent'">
                                            <i class="fa-solid fa-check text-[11px]"></i>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Custom Text on Cake (Optional for Tart/Cake) -->
                    @if(Str::contains(strtolower($product->category->slug), 'ulang-tahun') || Str::contains(strtolower($product->category->name), 'tart') || Str::contains(strtolower($product->name), 'tart'))
                        <div>
                            <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                ✍️ Tulisan Ucapan di Kue (Gratis Cokelat Plaque):
                            </label>
                            <input type="text" name="cake_text" placeholder="Contoh: Happy 25th Birthday Sarah 🎉" maxlength="80" class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                            <span class="text-[11px] text-stone-500">Maksimal 80 karakter. Tulis nama penerima dan lilin angka jika diperlukan.</span>
                        </div>
                    @endif

                    <!-- Note -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                            Catatan Khusus (Opsional):
                        </label>
                        <input type="text" name="note" placeholder="Misal: Jangan terlalu pedas, saus dipisah, ekstra oregano, dll." class="w-full px-4 py-2.5 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                    </div>

                    <!-- Quantity & Action Buttons -->
                    <div class="flex items-center space-x-4 pt-2">
                        <!-- Quantity Controller -->
                        <div x-data="{ qty: 1 }" class="flex items-center border border-stone-300 rounded-2xl bg-white p-1">
                            <button type="button" @click="if(qty > 1) qty--" class="w-9 h-9 rounded-xl flex items-center justify-center text-stone-600 hover:bg-stone-100 font-bold">-</button>
                            <input type="number" name="quantity" x-model="qty" min="1" max="{{ $product->stock }}" class="w-12 text-center border-0 p-0 text-sm font-bold text-stone-800 focus:ring-0">
                            <button type="button" @click="if(qty < {{ $product->stock }}) qty++" class="w-9 h-9 rounded-xl flex items-center justify-center text-stone-600 hover:bg-stone-100 font-bold">+</button>
                        </div>

                        <!-- Add to Cart Submit -->
                        @if($product->stock > 0)
                            <button type="submit" class="flex-grow py-3.5 px-6 rounded-2xl bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold text-sm shadow-lg shadow-amber-600/30 hover:scale-[1.01] transition-all flex items-center justify-center space-x-2">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <span>Tambah ke Keranjang</span>
                            </button>
                        @else
                            <button type="button" disabled class="flex-grow py-3.5 px-6 rounded-2xl bg-stone-300 text-stone-500 font-bold text-sm cursor-not-allowed">
                                Stok Saat Ini Habis
                            </button>
                        @endif
                    </div>
                </form>

                <!-- WhatsApp Direct Order Button -->
                <div class="pt-2">
                    <a :href="'https://wa.me/6285360233531?text=' + encodeURIComponent('Halo Khadijah Donat & Cake / Happizza, saya mau pesan ' + '{{ $product->name }}' + (selectedVariantObj ? ' - ' + selectedVariantObj.value : '') + ' seharga ' + formattedPrice)" target="_blank" class="w-full py-3.5 px-4 rounded-2xl border border-emerald-300 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs flex items-center justify-center space-x-2 transition-all shadow-sm">
                        <i class="fa-brands fa-whatsapp text-lg text-emerald-600"></i>
                        <span>Pesan Cepat via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->isNotEmpty())
            <div class="mt-20 pt-10 border-t border-stone-200/80">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="font-serif text-2xl font-bold text-chocolate">Kue Terkait Yang Mungkin Anda Suka</h2>
                    <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="text-xs font-bold text-bakery-600 hover:underline">Lihat Lebih Banyak</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $rel)
                        <div class="bg-white rounded-3xl overflow-hidden border border-stone-200/80 hover:shadow-xl transition-all group">
                            <div class="h-48 overflow-hidden bg-stone-100">
                                <img src="{{ $rel->main_image }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                            </div>
                            <div class="p-4">
                                <h4 class="font-bold text-stone-900 text-sm line-clamp-1 group-hover:text-bakery-600">
                                    <a href="{{ route('products.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h4>
                                <div class="mt-2 flex items-center justify-between">
                                    <span class="text-sm font-extrabold text-chocolate font-serif">Rp {{ number_format($rel->active_price, 0, ',', '.') }}</span>
                                    <a href="{{ route('products.show', $rel->slug) }}" class="text-xs font-bold text-bakery-600">Lihat</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
