<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Panel — Khadijah Donat & Cake')</title>

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
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
                    }
                }
            }
        }
    </script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800 selection:bg-amber-200">
    <div class="min-h-screen flex flex-col md:flex-row" x-data="{ sidebarOpen: false }">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-cloak class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden"></div>

        <!-- Sidebar Navigation -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed md:static inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col transition-transform duration-300 md:translate-x-0 shadow-xl flex-shrink-0">
            <!-- Sidebar Header / Logo -->
            <div class="h-20 flex items-center px-6 border-b border-slate-800 justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo Khadijah" class="w-10 h-10 rounded-full object-contain shadow-md">
                    <div>
                        <span class="font-bold text-white text-base block leading-tight">Khadijah</span>
                        <span class="text-[10px] text-amber-400 font-extrabold uppercase tracking-wider">Donat &amp; Cake Admin</span>
                    </div>
                </a>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white"><i class="fa-solid fa-xmark"></i></button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-grow p-4 space-y-1.5 text-sm font-semibold">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-bakery-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-chart-pie w-5"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-bakery-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-bag-shopping w-5"></i>
                    <span>Pesanan Masuk</span>
                </a>

                <a href="{{ route('admin.products.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-bakery-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-cake-candles w-5"></i>
                    <span>Katalog Produk</span>
                </a>

                <a href="{{ route('admin.categories.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-2xl transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-bakery-600 text-white shadow-md' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i class="fa-solid fa-layer-group w-5"></i>
                    <span>Kategori Kue</span>
                </a>

                <div class="pt-6 pb-2 px-4 text-[10px] uppercase font-bold text-slate-500 tracking-wider">Navigasi Lain</div>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center space-x-3 px-4 py-3 rounded-2xl text-slate-400 hover:text-white hover:bg-slate-800 transition-colors">
                    <i class="fa-solid fa-globe w-5"></i>
                    <span>Lihat Halaman Toko ↗</span>
                </a>
            </nav>

            <!-- Bottom User & Logout -->
            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center justify-between px-2 py-2">
                    <div class="flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-bakery-600 text-white flex items-center justify-center font-bold text-xs">
                            A
                        </div>
                        <div class="truncate max-w-[110px]">
                            <p class="text-xs font-bold text-white truncate">{{ Auth::user()->name }}</p>
                            <p class="text-[10px] text-slate-400">Administrator</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-red-400 text-sm p-1.5 rounded-lg hover:bg-slate-800" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Admin Content Area -->
        <div class="flex-grow flex flex-col min-w-0">
            <!-- Top Mobile Bar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 sm:px-8 md:hidden">
                <div class="flex items-center space-x-3">
                    <button @click="sidebarOpen = true" class="text-slate-600 hover:text-slate-900">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <span class="font-bold text-slate-800">Panel Toko Kue</span>
                </div>
                <a href="{{ route('home') }}" class="text-xs font-bold text-bakery-600">Ke Toko ↗</a>
            </header>

            <!-- Notifications / Flash messages -->
            <div class="p-4 sm:p-8 pb-0">
                @if(session('success'))
                    <div class="flex items-center justify-between p-4 mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl shadow-sm text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i>
                            <span>{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="flex items-center justify-between p-4 mb-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl shadow-sm text-sm">
                        <div class="flex items-center space-x-2">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <main class="p-4 sm:p-8 flex-grow">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
