<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Khadijah Donat & Cake — Toko Donat, Kue Tart & Pastry')</title>
    <meta name="description" content="Khadijah Donat & Cake - Aneka donat lembut, kue tart ulang tahun custom, dan pastry lezat dengan bahan berkualitas terbaik.">

    <!-- Fonts: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,700;0,800;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    @stack('styles')

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS (CDN for instant styling + Vite support) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'serif'],
                    },
                    colors: {
                        bakery: {
                            50: '#fffbf5',
                            100: '#fef5ea',
                            200: '#fde8cc',
                            300: '#fad4a3',
                            400: '#f5b56b',
                            500: '#f09138',
                            600: '#e1711c',
                            700: '#bb5315',
                            800: '#944218',
                            900: '#793817',
                        },
                        cream: '#FFF9F2',
                        chocolate: '#2B170B',
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        .glass-header {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .hero-gradient {
            background: radial-gradient(circle at top right, rgba(254, 243, 199, 0.7), transparent 50%),
                        radial-gradient(circle at bottom left, rgba(255, 237, 213, 0.6), transparent 50%),
                        #fffbf5;
        }

        /* Scroll Reveal Animations */
        .reveal-ready .reveal {
            opacity: 0;
            will-change: opacity, transform;
            transition: opacity 0.7s cubic-bezier(0.22, 1, 0.36, 1),
                        transform 0.7s cubic-bezier(0.22, 1, 0.36, 1) !important;
        }
        .reveal-ready .reveal-up:not(.is-visible) {
            transform: translateY(32px);
        }
        .reveal-ready .reveal-left:not(.is-visible) {
            transform: translateX(-32px);
        }
        .reveal-ready .reveal-right:not(.is-visible) {
            transform: translateX(32px);
        }
        .reveal-ready .reveal-zoom:not(.is-visible) {
            transform: scale(0.94) translateY(16px);
        }
        .reveal-ready .reveal.is-visible {
            opacity: 1;
        }
        @media (prefers-reduced-motion: reduce) {
            .reveal-ready .reveal {
                opacity: 1;
                transform: none;
                transition: none !important;
            }
        }
    </style>
    <script>document.documentElement.classList.add('reveal-ready');</script>
</head>
<body class="font-sans antialiased bg-[#FAF8F5] text-stone-800 flex flex-col min-h-screen selection:bg-amber-200 selection:text-amber-900">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-amber-700 via-bakery-600 to-amber-700 text-white text-xs sm:text-sm py-2 px-4 text-center font-medium shadow-inner flex items-center justify-center space-x-2">
        <span>🎉 <strong>Promo Hari Ini:</strong> Gratis Ongkir untuk pesanan di atas Rp 200.000!</span>
        <span class="hidden md:inline text-amber-200">|</span>
        <span class="hidden md:inline">🕒 Jam Buka: 08:00 - 21:00 WIB</span>
    </div>

    <!-- Navigation Bar -->
    <header x-data="{ mobileMenuOpen: false, userDropdown: false }" class="sticky top-0 z-50 glass-header border-b border-stone-200/80 shadow-sm transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo Khadijah Donat & Cake" class="w-12 h-12 rounded-full object-contain shadow-md shadow-amber-500/20 group-hover:scale-105 transition-transform duration-300">
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-tight text-chocolate block leading-none">Khadijah</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-bakery-600 mt-1 block">Donat &amp; Cake</span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center space-x-8 text-sm font-semibold text-stone-700">
                    <a href="{{ route('home') }}" class="hover:text-bakery-600 transition-colors {{ request()->routeIs('home') ? 'text-bakery-600 font-bold' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('products.index') }}" class="hover:text-bakery-600 transition-colors {{ request()->routeIs('products.index') ? 'text-bakery-600 font-bold' : '' }}">
                        Katalog Kue
                    </a>
                    <a href="{{ route('products.index', ['sort' => 'best-seller']) }}" class="hover:text-bakery-600 transition-colors">
                        Best Seller 🔥
                    </a>
                    <a href="#about-us" class="hover:text-bakery-600 transition-colors">
                        Tentang Kami
                    </a>
                    <a href="#kontak" class="hover:text-bakery-600 transition-colors">
                        Kontak
                    </a>
                </nav>

                <!-- Right Actions: Search, Cart, User -->
                <div class="flex items-center space-x-4 sm:space-x-5">
                    <!-- Search Icon (open desktop search or link) -->
                    <a href="{{ route('products.index') }}" class="w-10 h-10 rounded-full flex items-center justify-center text-stone-600 hover:text-bakery-600 hover:bg-amber-50 transition-colors" title="Cari Kue">
                        <i class="fa-solid fa-magnifying-glass text-lg"></i>
                    </a>

                    <!-- Cart Button with Count Badge -->
                    @php
                        $cartCount = 0;
                        if (auth()->check()) {
                            $cart = \App\Models\Cart::where('user_id', auth()->id())->first();
                            $cartCount = $cart ? $cart->items()->sum('quantity') : 0;
                        } else {
                            $sessionId = session()->getId();
                            $cart = \App\Models\Cart::where('session_id', $sessionId)->first();
                            $cartCount = $cart ? $cart->items()->sum('quantity') : 0;
                        }
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative w-10 h-10 rounded-full flex items-center justify-center text-stone-700 hover:text-bakery-600 hover:bg-amber-50 transition-colors" title="Keranjang Belanja">
                        <i class="fa-solid fa-basket-shopping text-xl"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-bakery-600 text-white text-[11px] font-extrabold w-5 h-5 rounded-full flex items-center justify-center ring-2 ring-white animate-pulse">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Account / Auth Dropdown -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 p-1.5 pl-3 rounded-full border border-stone-200 hover:border-bakery-400 bg-white transition-all shadow-sm">
                                <span class="text-xs font-bold text-stone-700 hidden sm:inline">{{ Auth::user()->name }}</span>
                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-amber-500 to-bakery-600 text-white flex items-center justify-center text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            </button>

                            <div x-show="open" @click.outside="open = false" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-stone-100 py-2 z-50 transition-all">
                                <div class="px-4 py-2 border-b border-stone-100">
                                    <p class="text-xs text-stone-500">Masuk sebagai</p>
                                    <p class="text-sm font-bold text-stone-800 truncate">{{ Auth::user()->email }}</p>
                                    <span class="inline-block mt-1 px-2 py-0.5 text-[10px] font-bold rounded-full {{ Auth::user()->isAdmin() ? 'bg-purple-100 text-purple-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ strtoupper(Auth::user()->role) }}
                                    </span>
                                </div>

                                @if(Auth::user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm text-purple-700 hover:bg-purple-50 font-bold transition-colors">
                                        <i class="fa-solid fa-chart-pie w-4"></i>
                                        <span>Panel Administrator</span>
                                    </a>
                                @endif

                                <a href="{{ route('orders.index') }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm text-stone-700 hover:bg-amber-50 hover:text-bakery-600 transition-colors">
                                    <i class="fa-solid fa-box-open w-4"></i>
                                    <span>Riwayat Pesanan</span>
                                </a>

                                <a href="{{ route('profile.edit') }}" class="flex items-center space-x-3 px-4 py-2.5 text-sm text-stone-700 hover:bg-amber-50 hover:text-bakery-600 transition-colors">
                                    <i class="fa-solid fa-user-pen w-4"></i>
                                    <span>Edit Profil</span>
                                </a>

                                <form method="POST" action="{{ route('logout') }}" class="border-t border-stone-100 mt-1">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 text-left transition-colors">
                                        <i class="fa-solid fa-right-from-bracket w-4"></i>
                                        <span>Keluar (Logout)</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-semibold text-stone-700 hover:text-bakery-600 transition-colors">
                                Masuk
                            </a>
                            <a href="{{ route('register') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-bakery-600 to-amber-500 rounded-full shadow-md shadow-amber-500/25 hover:from-bakery-700 hover:to-amber-600 transition-all">
                                Daftar
                            </a>
                        </div>
                    @endauth

                    <!-- Mobile Menu Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden w-10 h-10 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center hover:bg-stone-200">
                        <i :class="mobileMenuOpen ? 'fa-solid fa-xmark text-lg' : 'fa-solid fa-bars text-lg'"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" x-cloak class="md:hidden bg-white border-b border-stone-200 px-4 pt-3 pb-6 space-y-3">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-stone-700 hover:bg-amber-50 hover:text-bakery-600">Beranda</a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-stone-700 hover:bg-amber-50 hover:text-bakery-600">Katalog Kue</a>
            <a href="{{ route('products.index', ['sort' => 'best-seller']) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-stone-700 hover:bg-amber-50 hover:text-bakery-600">Best Seller 🔥</a>
            <a href="{{ route('cart.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-stone-700 hover:bg-amber-50 hover:text-bakery-600">Keranjang Belanja ({{ $cartCount }})</a>
            @guest
                <div class="pt-2 border-t border-stone-100 flex flex-col space-y-2">
                    <a href="{{ route('login') }}" class="w-full text-center py-2.5 rounded-xl border border-stone-200 text-sm font-bold text-stone-700">Masuk Akun</a>
                    <a href="{{ route('register') }}" class="w-full text-center py-2.5 rounded-xl bg-bakery-600 text-sm font-bold text-white shadow">Daftar Sekarang</a>
                </div>
            @endguest
        </div>
    </header>

    <!-- Global Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition class="flex items-center justify-between p-4 mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-emerald-600 hover:text-emerald-900"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-transition class="flex items-center justify-between p-4 mb-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl shadow-sm">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-full bg-rose-500 text-white flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <p class="text-sm font-semibold">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-rose-600 hover:text-rose-900"><i class="fa-solid fa-xmark"></i></button>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Floating WhatsApp Help Button -->
    <a href="https://wa.me/+6285360233531?text=Halo%20Sweet%20Crumbs%20Bakery,%20saya%20ingin%20tanya%20seputar%20pemesanan%20kue..." target="_blank" class="fixed bottom-6 right-6 z-40 bg-emerald-500 hover:bg-emerald-600 text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center text-2xl hover:scale-110 transition-transform duration-300 group" title="Chat WhatsApp Customer Care">
        <i class="fa-brands fa-whatsapp"></i>
        <span class="absolute right-16 bg-stone-900 text-white text-xs px-3 py-1.5 rounded-lg whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 shadow-md">
            Konsultasi / Pesan via WA
        </span>
    </a>

    <!-- Footer -->
    <footer id="kontak" class="bg-chocolate text-stone-300 pt-16 pb-10 border-t border-amber-950 mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-stone-800">
                <!-- Col 1: Store Intro -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo Khadijah Donat & Cake" class="w-11 h-11 rounded-full object-contain shadow-md">
                        <div>
                            <span class="font-serif text-2xl font-bold text-white tracking-tight block leading-tight">Khadijah</span>
                            <span class="text-[10px] uppercase tracking-wider text-amber-400 font-semibold block">Donat &amp; Cake</span>
                        </div>
                    </div>
                    <p class="text-sm text-stone-400 leading-relaxed mb-6">
                        Menghadirkan aneka kreasi donat lezat dan kue istimewa dengan bahan pilihan tanpa pengawet. Setiap gigitan adalah kebahagiaan manis untuk keluarga.
                    </p>
                    <div class="flex items-center space-x-3">
                        <a href="#" class="w-9 h-9 rounded-full bg-stone-800 hover:bg-bakery-600 text-stone-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-stone-800 hover:bg-bakery-600 text-stone-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-tiktok"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-stone-800 hover:bg-bakery-600 text-stone-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-facebook"></i></a>
                        <a href="https://wa.me/+6285360233531" target="_blank" class="w-9 h-9 rounded-full bg-stone-800 hover:bg-emerald-600 text-stone-300 hover:text-white flex items-center justify-center transition-colors"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>

                <!-- Col 2: Kategori Populer -->
                <div>
                    <h4 class="text-white font-serif text-lg font-bold mb-4">Kategori Pilihan</h4>
                    <ul class="space-y-2.5 text-sm">
                        <li><a href="{{ route('products.index', ['category' => 'kue-ulang-tahun']) }}" class="hover:text-bakery-400 transition-colors">🎂 Kue Tart & Ulang Tahun</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'pastry-croissant']) }}" class="hover:text-bakery-400 transition-colors">🥐 French Pastry & Croissant</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'kue-kering-cookies']) }}" class="hover:text-bakery-400 transition-colors">🍪 Cookies & Nastar Wijsman</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'dessert-box-cupcake']) }}" class="hover:text-bakery-400 transition-colors">🧁 Tiramisu & Dessert Box</a></li>
                        <li><a href="{{ route('products.index', ['category' => 'kue-tradisional']) }}" class="hover:text-bakery-400 transition-colors">🍃 Aneka Jajanan Pasar Gurih</a></li>
                    </ul>
                </div>

                <!-- Col 3: Layanan Pelanggan -->
                <div>
                    <h4 class="text-white font-serif text-lg font-bold mb-4">Layanan Toko</h4>
                    <ul class="space-y-2.5 text-sm text-stone-400">
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition-colors">Keranjang Belanja</a></li>
                        <li><a href="{{ route('orders.index') }}" class="hover:text-white transition-colors">Cek Status Pesanan</a></li>
                        <li><a href="#about-us" class="hover:text-white transition-colors">Ketentuan Pemesanan Custom H-1</a></li>
                        <li><a href="#about-us" class="hover:text-white transition-colors">Area Pengiriman & Ongkir</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition-colors">Login Akun Member</a></li>
                    </ul>
                </div>

                <!-- Col 4: Informasi Outlet & Jam Buka -->
                <div>
                    <h4 class="text-white font-serif text-lg font-bold mb-4">Kunjungi Toko Kami</h4>
                    <ul class="space-y-3 text-sm text-stone-400">
                        <li class="flex items-start space-x-3">
                            <i class="fa-solid fa-location-dot text-bakery-400 mt-1 flex-shrink-0"></i>
                            <span>Jl. Paya Billi - Panggoi Road, Panggoi, Kec. Muara Dua, Kota Lhokseumawe, Aceh</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa-solid fa-phone text-bakery-400 flex-shrink-0"></i>
                            <span>0853-6023-3531</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa-regular fa-clock text-bakery-400 flex-shrink-0"></i>
                            <span>Setiap Hari: 08:00 - 21:00 WIB</span>
                        </li>
                    </ul>
                    <div class="mt-4 pt-4 border-t border-stone-800">
                        <span class="text-xs uppercase tracking-wider text-stone-400 block mb-2 font-bold">Metode Pembayaran:</span>
                        <div class="flex items-center space-x-2 text-stone-400 text-xl">
                            <i class="fa-solid fa-building-columns" title="Transfer Bank"></i>
                            <i class="fa-solid fa-qrcode" title="QRIS All Payment"></i>
                            <i class="fa-solid fa-money-bill-wave" title="Cash on Pickup"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Copyright -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-stone-400">
                <p>&copy; {{ date('Y') }} Khadijah Donat & Cake. Hak Cipta Dilindungi Undang-Undang.</p>
                <p class="mt-2 sm:mt-0">Dibuat dengan ❤️ & Butter Berkualitas Tinggi.</p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const elements = document.querySelectorAll('.reveal');
            if (!elements.length) return;

            if (!('IntersectionObserver' in window)) {
                elements.forEach((el) => el.classList.add('is-visible'));
                return;
            }

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return;
                    const el = entry.target;
                    const delay = parseInt(el.dataset.delay || '0', 10);
                    if (delay > 0) {
                        el.style.transitionDelay = `${delay}ms`;
                    }
                    el.classList.add('is-visible');
                    obs.unobserve(el);

                    setTimeout(() => {
                        el.classList.remove('reveal', 'reveal-up', 'reveal-left', 'reveal-right', 'reveal-zoom', 'is-visible');
                        el.style.transitionDelay = '';
                    }, delay + 750);
                });
            }, {
                threshold: 0.12,
                rootMargin: '0px 0px -40px 0px',
            });

            elements.forEach((el) => observer.observe(el));
        });
    </script>

    @stack('scripts')
</body>
</html>
