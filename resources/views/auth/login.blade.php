<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk Akun — Khadijah Donat & Cake</title>

    <!-- Google Fonts: Plus Jakarta Sans & Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

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
                        chocolate: '#2B170B',
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans antialiased bg-[#FAF8F5] text-stone-800 min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8 selection:bg-amber-200">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-stone-200/80 grid grid-cols-1 lg:grid-cols-12 min-h-[620px]">
        
        <!-- Left Banner: Visual Showcase (Hidden on mobile) -->
        <div class="hidden lg:flex lg:col-span-5 relative bg-gradient-to-tr from-chocolate via-stone-900 to-amber-950 p-10 flex-col justify-between text-white overflow-hidden">
            <!-- Background Image overlay -->
            <img src="https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=1000&auto=format&fit=crop&q=80" alt="Bakery" class="absolute inset-0 w-full h-full object-cover opacity-25 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-t from-chocolate via-transparent to-transparent"></div>

            <!-- Top Brand -->
            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo Khadijah" class="w-12 h-12 rounded-full object-contain shadow-lg shadow-amber-500/30 group-hover:scale-105 transition-transform">
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-tight text-white block leading-none">Khadijah</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-amber-400 mt-1 block">Donat &amp; Cake</span>
                    </div>
                </a>
            </div>

            <!-- Center Quote / Promo -->
            <div class="relative z-10 space-y-4 my-auto py-8">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-amber-300 text-xs font-semibold">
                    <i class="fa-solid fa-cookie-bite"></i>
                    <span>Fresh From The Oven Harian</span>
                </div>
                <h2 class="font-serif text-3xl font-bold leading-snug">
                    Nikmati Kelezatan Kue Tart & Pastry Premium Kapan Saja.
                </h2>
                <p class="text-xs text-stone-300 leading-relaxed">
                    Masuk ke akun Anda untuk melacak pesanan kue secara realtime, menyimpan kue favorit di wishlist, dan menikmati diskon khusus member.
                </p>
            </div>

            <!-- Bottom Testimonial snippet -->
            <div class="relative z-10 pt-4 border-t border-white/10 text-xs text-stone-400 flex items-center justify-between">
                <span>⭐ 4.9/5 dari 1.200+ ulasan</span>
                <a href="{{ route('home') }}" class="text-amber-300 hover:text-white font-bold flex items-center space-x-1">
                    <span>Kembali ke Toko</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Right Form: Login Area -->
        <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-between" x-data="{ email: '{{ old('email') }}', password: '', showPassword: false }">
            
            <!-- Mobile Brand Bar (Visible on mobile only) -->
            <div class="flex items-center justify-between lg:hidden mb-6 pb-4 border-b border-stone-100">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo Khadijah" class="w-9 h-9 rounded-full object-contain">
                    <span class="font-serif text-xl font-bold text-chocolate">Khadijah</span>
                </a>
                <a href="{{ route('home') }}" class="text-xs font-bold text-bakery-600">← Toko</a>
            </div>

            <div class="space-y-6">
                <!-- Heading -->
                <div>
                    <h1 class="font-serif text-3xl font-bold text-chocolate">Selamat Datang Kembali</h1>
                    <p class="text-xs sm:text-sm text-stone-500 mt-1">Masukkan email dan password untuk masuk ke akun Anda.</p>
                </div>

                <!-- Session Status / Errors -->
                @if(session('status'))
                    <div class="p-3.5 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold rounded-2xl flex items-center space-x-2">
                        <i class="fa-solid fa-check"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold rounded-2xl flex items-center space-x-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <!-- Demo Account Fast Fill Box -->
                <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-4 space-y-2">
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-extrabold uppercase tracking-wider text-bakery-800 flex items-center space-x-1.5">
                            <i class="fa-solid fa-bolt text-amber-500"></i>
                            <span>Klik Cepat Akun Demo (1-Click):</span>
                        </span>
                        <span class="text-[10px] text-stone-500 font-medium">Klik untuk isi otomatis</span>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                        <button type="button" @click="email = 'admin@tokokue.com'; password = 'password';" class="px-3 py-2 bg-white hover:bg-amber-100/70 border border-amber-300 text-chocolate rounded-xl text-xs font-bold text-left transition-all flex items-center justify-between group">
                            <div>
                                <span class="block text-purple-700 font-extrabold text-[11px]">👑 Akun Admin</span>
                                <span class="text-[10px] text-stone-500">admin@tokokue.com</span>
                            </div>
                            <i class="fa-solid fa-arrow-turn-down text-bakery-600 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </button>

                        <button type="button" @click="email = 'customer@tokokue.com'; password = 'password';" class="px-3 py-2 bg-white hover:bg-amber-100/70 border border-amber-300 text-chocolate rounded-xl text-xs font-bold text-left transition-all flex items-center justify-between group">
                            <div>
                                <span class="block text-emerald-700 font-extrabold text-[11px]">🛍️ Akun Customer</span>
                                <span class="text-[10px] text-stone-500">customer@tokokue.com</span>
                            </div>
                            <i class="fa-solid fa-arrow-turn-down text-bakery-600 opacity-0 group-hover:opacity-100 transition-opacity"></i>
                        </button>
                    </div>
                </div>

                <!-- Form Login -->
                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <input id="email" type="email" name="email" x-model="email" required autofocus autocomplete="username" placeholder="nama@email.com" class="w-full pl-10 pr-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400 bg-stone-50/50">
                        </div>
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-stone-700 uppercase tracking-wider">
                                Kata Sandi (Password)
                            </label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-bakery-600 hover:text-bakery-800 font-semibold">
                                    Lupa Password?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <i class="fa-solid fa-lock"></i>
                            </div>
                            <input id="password" :type="showPassword ? 'text' : 'password'" name="password" x-model="password" required autocomplete="current-password" placeholder="••••••••" class="w-full pl-10 pr-11 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400 bg-stone-50/50">
                            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-stone-400 hover:text-stone-700">
                                <i :class="showPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-stone-300 text-bakery-600 focus:ring-bakery-400">
                            <span class="ms-2 text-xs font-semibold text-stone-600">Ingat Saya di Perangkat Ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold text-sm shadow-lg shadow-amber-600/30 hover:shadow-xl hover:scale-[1.01] transition-all flex items-center justify-center space-x-2">
                            <span>Masuk ke Akun</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Bottom Register Link -->
            <div class="pt-6 mt-6 border-t border-stone-100 text-center text-xs text-stone-600">
                <span>Belum punya akun member?</span>
                <a href="{{ route('register') }}" class="font-bold text-bakery-600 hover:text-bakery-800 ml-1 underline">
                    Daftar Akun Baru Sekarang
                </a>
            </div>
        </div>
    </div>

</body>
</html>
