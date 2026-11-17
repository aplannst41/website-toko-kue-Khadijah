@extends('layouts.frontend')

@section('title', 'Khadijah Donat & Cake — Toko Donat, Kue Tart & Pastry')

@section('content')
    <!-- 1. HERO SECTION -->
    <section class="relative overflow-hidden hero-gradient py-12 lg:py-20 border-b border-amber-100/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Text Left -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left reveal reveal-up">
                    <div class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-amber-100 text-bakery-800 text-xs font-bold uppercase tracking-wider">
                        <span class="w-2 h-2 rounded-full bg-bakery-600 animate-ping"></span>
                        <span>✨ Freshly Baked Everyday Since 2018</span>
                    </div>

                    <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-extrabold text-chocolate leading-[1.15] tracking-tight">
                        Kehangatan Manis di Setiap <span class="text-transparent bg-clip-text bg-gradient-to-r from-bakery-600 to-amber-500">Gigitan Sempurna</span>
                    </h1>

                    <p class="text-base sm:text-lg text-stone-600 max-w-2xl mx-auto lg:mx-0 font-normal leading-relaxed">
                        Rasakan kelembutan donat kentang khas Khadijah, aneka pizza lezat dengan lelehan keju mozarella melimpah, kue tart artisan, pastry Prancis, dan dessert istimewa.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('products.index') }}" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold rounded-2xl shadow-lg shadow-amber-600/30 hover:shadow-xl hover:scale-[1.02] transition-all flex items-center justify-center space-x-3">
                            <span>Jelajahi Menu Kue</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </a>
                        <a href="https://wa.me/6281234567890?text=Halo%20Sweet%20Crumbs,%20saya%20mau%20pesan%20kue%20custom" target="_blank" class="w-full sm:w-auto px-7 py-4 bg-white hover:bg-stone-50 text-chocolate font-bold rounded-2xl border border-stone-200/80 shadow-sm hover:border-bakery-300 transition-all flex items-center justify-center space-x-2">
                            <i class="fa-brands fa-whatsapp text-emerald-600 text-lg"></i>
                            <span>Pesan Custom Cake</span>
                        </a>
                    </div>

                    <!-- Trust Points -->
                    <div class="pt-6 grid grid-cols-3 gap-4 border-t border-amber-200/50">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-bakery-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-leaf"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-bold text-stone-800">100% Halal</p>
                                <p class="text-[11px] text-stone-500">Bahan Alami</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-bakery-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-bold text-stone-800">Fresh Harian</p>
                                <p class="text-[11px] text-stone-500">Dipanggang Subuh</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2.5">
                            <div class="w-9 h-9 rounded-xl bg-amber-100 text-bakery-700 flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-truck-fast"></i>
                            </div>
                            <div class="text-left">
                                <p class="text-xs font-bold text-stone-800">Kirim Aman</p>
                                <p class="text-[11px] text-stone-500">Special Box</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hero Image Right -->
                <div class="lg:col-span-5 relative reveal reveal-zoom" data-delay="150">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <!-- Glow behind -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-bakery-400/30 to-amber-300/30 rounded-3xl filter blur-2xl transform scale-95"></div>

                        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
                            <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=1000&auto=format&fit=crop&q=80" alt="Belgian Chocolate Cake" class="w-full h-[420px] object-cover hover:scale-105 transition-transform duration-700">
                            
                            <!-- Floating Card Badge -->
                            <div class="absolute bottom-4 left-4 right-4 bg-white/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/60 flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 rounded-xl bg-amber-50 overflow-hidden flex-shrink-0">
                                        <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=200&auto=format&fit=crop&q=80" alt="Strawberry" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <div class="flex items-center space-x-1 text-amber-500 text-xs">
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <i class="fa-solid fa-star"></i>
                                            <span class="text-stone-700 font-bold ml-1">4.9 / 5.0</span>
                                        </div>
                                        <p class="text-xs font-bold text-stone-800">Fresh Strawberry Shortcake</p>
                                    </div>
                                </div>
                                <span class="text-xs font-extrabold text-bakery-600 bg-amber-50 px-2.5 py-1 rounded-lg">Terfavorit</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. KATEGORI KUE -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between mb-10 text-center sm:text-left reveal reveal-up">
            <div>
                <span class="text-xs font-bold text-bakery-600 uppercase tracking-widest">Katalog Pilihan</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-chocolate mt-1">Pilih Kategori Favoritmu</h2>
            </div>
            <a href="{{ route('products.index') }}" class="mt-4 sm:mt-0 text-sm font-bold text-bakery-600 hover:text-bakery-700 flex items-center space-x-1 group">
                <span>Lihat Semua Menu</span>
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-7 gap-4 sm:gap-6">
            @foreach($categories as $index => $cat)
                <a href="{{ route('products.index', ['category' => $cat->slug]) }}" class="reveal reveal-up group bg-white rounded-3xl p-5 text-center border border-stone-200/70 hover:border-bakery-400 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col items-center" data-delay="{{ ($index % 7) * 60 }}">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-100 to-amber-50 text-bakery-600 flex items-center justify-center text-2xl mb-3 group-hover:scale-110 group-hover:bg-bakery-600 group-hover:text-white transition-all duration-300 shadow-sm">
                        @if($cat->slug === 'donat' || str_contains($cat->slug, 'donat'))
                            <i class="fa-solid fa-circle-dot"></i>
                        @elseif($cat->slug === 'pizza' || str_contains($cat->slug, 'pizza'))
                            <i class="fa-solid fa-pizza-slice"></i>
                        @elseif($cat->slug === 'kue-ulang-tahun')
                            <i class="fa-solid fa-cake-candles"></i>
                        @elseif($cat->slug === 'pastry-croissant')
                            <i class="fa-solid fa-bread-slice"></i>
                        @elseif($cat->slug === 'kue-kering-cookies')
                            <i class="fa-solid fa-cookie-bite"></i>
                        @elseif($cat->slug === 'kue-tradisional')
                            <i class="fa-solid fa-sparkles"></i>
                        @else
                            <i class="fa-solid fa-box-open"></i>
                        @endif
                    </div>
                    <h3 class="font-bold text-stone-800 text-xs sm:text-sm group-hover:text-bakery-600 transition-colors leading-snug">{{ $cat->name }}</h3>
                    <p class="text-[11px] text-stone-500 mt-1">{{ $cat->products_count }} Menu</p>
                </a>
            @endforeach
        </div>
    </section>

    <!-- 3. PRODUK BEST SELLER PILIHAN -->
    <section class="py-16 bg-white border-y border-stone-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-center justify-between mb-10 text-center sm:text-left reveal reveal-up">
                <div>
                    <span class="text-xs font-bold text-bakery-600 uppercase tracking-widest flex items-center justify-center sm:justify-start space-x-1.5">
                        <i class="fa-solid fa-fire-flame-curved text-amber-500"></i>
                        <span>Pilihan Terlaris</span>
                    </span>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold text-chocolate mt-1">Menu Best Seller Pilihan 🔥</h2>
                    <p class="text-stone-500 text-xs sm:text-sm mt-1">Menu favorit pelanggan yang paling sering dipesan dan dipanggang fresh setiap hari.</p>
                </div>
                <div class="mt-4 sm:mt-0 flex items-center space-x-3">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 text-xs sm:text-sm font-bold text-bakery-600 hover:text-bakery-700 bg-amber-50 hover:bg-amber-100 px-4 py-2.5 rounded-2xl border border-amber-200 transition-all group">
                        <span>Lihat Semua Menu</span>
                        <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                @foreach($bestSellers as $index => $product)
                    <div class="reveal reveal-up bg-[#FAF8F5] rounded-3xl overflow-hidden border border-stone-200/80 hover:shadow-2xl hover:border-bakery-300 transition-all duration-300 flex flex-col group" data-delay="{{ ($index % 3) * 100 }}">
                        <!-- Product Image Box -->
                        <div class="relative h-64 overflow-hidden bg-stone-100">
                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                                <span class="bg-gradient-to-r from-amber-600 to-amber-500 text-white text-[11px] font-extrabold uppercase px-3 py-1 rounded-full shadow-md flex items-center space-x-1">
                                    <i class="fa-solid fa-fire text-amber-200 text-[10px]"></i>
                                    <span>Best Seller</span>
                                </span>
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

                        <!-- Product Content -->
                        <div class="p-6 flex flex-col flex-grow justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-[11px] font-bold text-bakery-600 uppercase tracking-wider">{{ $product->category->name }}</span>
                                    <div class="flex items-center text-amber-500 text-xs font-bold">
                                        <i class="fa-solid fa-star mr-1"></i> {{ number_format($product->rating_avg, 1) }}
                                    </div>
                                </div>
                                <h3 class="font-serif font-bold text-stone-900 text-lg group-hover:text-bakery-600 transition-colors">
                                    <a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>
                                </h3>
                                <p class="text-xs text-stone-500 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $product->description }}
                                </p>

                                <!-- Sold & Variant info badges -->
                                <div class="mt-3 flex items-center flex-wrap gap-2 text-xs text-stone-500">
                                    <span class="inline-flex items-center text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full font-semibold border border-emerald-200 text-[11px]">
                                        <i class="fa-solid fa-circle-check mr-1 text-[10px]"></i> {{ $product->sold_count }} Terjual
                                    </span>
                                    @if($product->variants->isNotEmpty())
                                        <span class="inline-flex items-center text-amber-800 bg-amber-50 px-2 py-0.5 rounded-full font-semibold border border-amber-200 text-[11px]">
                                            {{ $product->variants->count() }} Pilihan Ukuran
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Price & Add Button -->
                            <div class="pt-4 mt-5 border-t border-stone-200/60 flex items-center justify-between">
                                <div>
                                    @if($product->variants->isNotEmpty())
                                        <span class="text-[10px] text-bakery-600 font-bold uppercase tracking-wider block">Mulai dari</span>
                                    @endif
                                    @if($product->discount_price)
                                        <span class="text-xs text-stone-500 line-through block">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-xl font-extrabold text-chocolate font-serif">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-xl font-extrabold text-chocolate font-serif">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                    @endif
                                </div>

                                <a href="{{ route('products.show', $product->slug) }}" class="px-4 py-2.5 rounded-2xl bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold text-xs shadow-md shadow-amber-500/20 hover:scale-105 transition-all flex items-center space-x-1.5" title="Pesan Sekarang">
                                    <span>Pesan</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- View All Menu CTA Bottom -->
            <div class="mt-12 text-center reveal reveal-up">
                <a href="{{ route('products.index') }}" class="inline-flex items-center space-x-2 px-8 py-3.5 rounded-2xl bg-white hover:bg-stone-50 text-chocolate font-bold text-sm border-2 border-stone-200 hover:border-bakery-400 shadow-sm hover:shadow-md transition-all">
                    <span>Lihat Seluruh Menu & Katalog Lengkap</span>
                    <i class="fa-solid fa-arrow-right text-bakery-600"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- 4. BANNER PROMOSI & CUSTOM CAKE ORDER -->
    <section class="py-16 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="reveal reveal-zoom bg-gradient-to-r from-chocolate via-stone-900 to-amber-950 rounded-3xl p-8 sm:p-12 text-white relative overflow-hidden shadow-2xl">
            <!-- Decorative circle -->
            <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full bg-bakery-500/10 filter blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                <div class="lg:col-span-8 space-y-4">
                    <span class="inline-block px-3 py-1 rounded-full bg-bakery-500 text-stone-950 text-xs font-extrabold uppercase tracking-wider">
                        Special Custom Cake
                    </span>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold tracking-tight">
                        Mau Kue Ulang Tahun atau Wedding dengan Desain Impianmu?
                    </h2>
                    <p class="text-stone-300 text-sm sm:text-base leading-relaxed max-w-2xl">
                        Konsultasikan tema warna, tulisan nama, ukuran tier, dan rasa favoritmu. Baker ahli kami siap membuat momen perayaan Anda tak terlupakan.
                    </p>
                    <div class="pt-2 flex flex-wrap gap-4">
                        <a href="https://wa.me/6281234567890?text=Halo%20Sweet%20Crumbs,%20saya%20mau%20konsultasi%20kue%20custom" target="_blank" class="px-6 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl shadow-lg transition-all flex items-center space-x-2">
                            <i class="fa-brands fa-whatsapp text-lg"></i>
                            <span>Chat Baker via WhatsApp</span>
                        </a>
                        <a href="{{ route('products.index', ['category' => 'kue-ulang-tahun']) }}" class="px-6 py-3.5 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl border border-white/20 transition-all">
                            Lihat Contoh Tart
                        </a>
                    </div>
                </div>

                <div class="lg:col-span-4 flex justify-center">
                    <div class="w-48 h-48 sm:w-60 sm:h-60 rounded-3xl bg-white/5 border border-white/10 p-4 flex flex-col items-center justify-center text-center backdrop-blur-md">
                        <i class="fa-solid fa-cake-candles text-5xl text-amber-400 mb-3 animate-bounce"></i>
                        <h4 class="font-bold text-white text-base">Pesan H-1</h4>
                        <p class="text-xs text-stone-400 mt-1">Slot custom terbatas 10 pesanan/hari agar kualitas terjaga sempurna.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. TENTANG KAMI & KEUNGGULAN (ABOUT US) -->
    <section id="about-us" class="py-16 bg-[#FAF8F5]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14 reveal reveal-up">
                <span class="text-xs font-bold text-bakery-600 uppercase tracking-widest">Filosofi Dapur Kami</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-chocolate mt-2">Dibuat Dengan Cinta & Kualitas Terbaik</h2>
                <p class="text-stone-600 text-sm mt-3">Komitmen kami untuk memberikan kualitas rasa autentik di setiap helai roti dan krim kue.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="reveal reveal-up bg-white rounded-3xl p-8 border border-stone-200/80 shadow-sm text-center" data-delay="0">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-bakery-700 flex items-center justify-center text-2xl mx-auto mb-5">
                        <i class="fa-solid fa-wheat-awn"></i>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-chocolate mb-2">Bahan Organik Pilihan</h3>
                    <p class="text-sm text-stone-600 leading-relaxed">
                        Menggunakan pure butter Elle & Vire, dark chocolate Belgia murni, serta telur omega segar tanpa pengembang kimiawi berlebih.
                    </p>
                </div>

                <div class="reveal reveal-up bg-white rounded-3xl p-8 border border-stone-200/80 shadow-sm text-center" data-delay="120">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-bakery-700 flex items-center justify-center text-2xl mx-auto mb-5">
                        <i class="fa-solid fa-temperature-arrow-up"></i>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-chocolate mb-2">Dipanggang Fresh Harian</h3>
                    <p class="text-sm text-stone-600 leading-relaxed">
                        Dapur kami mulai memanggang sejak pukul 04:00 subuh sehingga croissant dan kue sampai di tangan Anda dalam aroma terbaik.
                    </p>
                </div>

                <div class="reveal reveal-up bg-white rounded-3xl p-8 border border-stone-200/80 shadow-sm text-center" data-delay="240">
                    <div class="w-14 h-14 rounded-2xl bg-amber-100 text-bakery-700 flex items-center justify-center text-2xl mx-auto mb-5">
                        <i class="fa-solid fa-shield-heart"></i>
                    </div>
                    <h3 class="font-serif font-bold text-xl text-chocolate mb-2">Garansi Pengiriman Aman</h3>
                    <p class="text-sm text-stone-600 leading-relaxed">
                        Kotak pengaman berstruktur kokoh dengan ice gel pendingin untuk menjamin kue tart cantik Anda tidak leleh atau berantakan saat sampai.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. TESTIMONI PELANGGAN -->
    <section class="py-16 bg-white border-t border-stone-200/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 reveal reveal-up">
                <span class="text-xs font-bold text-bakery-600 uppercase tracking-widest">Cerita Pelanggan</span>
                <h2 class="font-serif text-3xl sm:text-4xl font-bold text-chocolate mt-1">Kata Mereka Yang Sudah Mencoba</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="reveal reveal-up bg-cream rounded-3xl p-6 border border-amber-200/60 shadow-sm" data-delay="0">
                    <div class="flex items-center space-x-1 text-amber-500 text-xs mb-3">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-sm text-stone-700 italic leading-relaxed">
                        "Belgian Double Chocolate Tart-nya luar biasa! Cokelatnya kaya rasa tapi tidak bikin eneg sama sekali. Suami dan anak-anak pas ulang tahun langsung habis dalam sekejap."
                    </p>
                    <div class="flex items-center space-x-3 mt-4 pt-4 border-t border-amber-200/40">
                        <div class="w-10 h-10 rounded-full bg-bakery-200 text-bakery-800 font-bold flex items-center justify-center text-xs">
                            AS
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-stone-900">Anindya Saraswati</h4>
                            <p class="text-[11px] text-stone-500">Muara Dua, Lhokseumawe</p>
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-up bg-cream rounded-3xl p-6 border border-amber-200/60 shadow-sm" data-delay="120">
                    <div class="flex items-center space-x-1 text-amber-500 text-xs mb-3">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-sm text-stone-700 italic leading-relaxed">
                        "Donat dan kuenya beneran lembut dan enak banget. Setiap ada acara keluarga wajib order donat dan cake dari Khadijah Donat & Cake. Packaging rapi dan higienis!"
                    </p>
                    <div class="flex items-center space-x-3 mt-4 pt-4 border-t border-amber-200/40">
                        <div class="w-10 h-10 rounded-full bg-bakery-200 text-bakery-800 font-bold flex items-center justify-center text-xs">
                            RP
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-stone-900">Rian Pratama</h4>
                            <p class="text-[11px] text-stone-500">Banda Sakti, Lhokseumawe</p>
                        </div>
                    </div>
                </div>

                <div class="reveal reveal-up bg-cream rounded-3xl p-6 border border-amber-200/60 shadow-sm" data-delay="240">
                    <div class="flex items-center space-x-1 text-amber-500 text-xs mb-3">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-sm text-stone-700 italic leading-relaxed">
                        "Kue dari Khadijah Donat & Cake beneran lembut dan manisnya pas, tidak bikin eneg. Kemarin pesan kue untuk acara keluarga di rumah, semua tamu suka dan langsung ludes!"
                    </p>
                    <div class="flex items-center space-x-3 mt-4 pt-4 border-t border-amber-200/40">
                        <div class="w-10 h-10 rounded-full bg-bakery-200 text-bakery-800 font-bold flex items-center justify-center text-xs">
                            ML
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-stone-900">Maria Lestari</h4>
                            <p class="text-[11px] text-stone-500">Blang Pulo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
