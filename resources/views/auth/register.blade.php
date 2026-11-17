<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar Akun Baru — Khadijah Donat & Cake</title>

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
            <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?w=1000&auto=format&fit=crop&q=80" alt="Bakery" class="absolute inset-0 w-full h-full object-cover opacity-25 mix-blend-overlay">
            <div class="absolute inset-0 bg-gradient-to-t from-chocolate via-transparent to-transparent"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo Khadijah" class="w-12 h-12 rounded-full object-contain shadow-lg shadow-amber-500/30 group-hover:scale-105 transition-transform">
                    <div>
                        <span class="font-serif text-2xl font-bold tracking-tight text-white block leading-none">Khadijah</span>
                        <span class="text-[10px] uppercase font-bold tracking-widest text-amber-400 mt-1 block">Donat &amp; Cake</span>
                    </div>
                </a>
            </div>

            <div class="relative z-10 space-y-4 my-auto py-8">
                <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md text-amber-300 text-xs font-semibold">
                    <i class="fa-solid fa-gift"></i>
                    <span>Daftar & Nikmati Promo</span>
                </div>
                <h2 class="font-serif text-3xl font-bold leading-snug">
                    Bergabung Menjadi Member Khadijah Donat &amp; Cake.
                </h2>
                <p class="text-xs text-stone-300 leading-relaxed">
                    Dapatkan kemudahan menyimpan alamat pengiriman, histori pesanan kue, diskon ulang tahun khusus, dan poin belanja menarik.
                </p>
            </div>

            <div class="relative z-10 pt-4 border-t border-white/10 text-xs text-stone-400 flex items-center justify-between">
                <span>🧁 Lebih dari 5.000 kue terkirim</span>
                <a href="{{ route('home') }}" class="text-amber-300 hover:text-white font-bold flex items-center space-x-1">
                    <span>Kembali ke Toko</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Right Form: Register Area -->
        <div class="lg:col-span-7 p-6 sm:p-10 lg:p-12 flex flex-col justify-between">
            
            <div class="flex items-center justify-between lg:hidden mb-6 pb-4 border-b border-stone-100">
                <a href="{{ route('home') }}" class="flex items-center space-x-2">
                    <img src="{{ asset('images/logo.svg') }}" alt="Logo Khadijah" class="w-9 h-9 rounded-full object-contain">
                    <span class="font-serif text-xl font-bold text-chocolate">Khadijah</span>
                </a>
                <a href="{{ route('home') }}" class="text-xs font-bold text-bakery-600">← Toko</a>
            </div>

            <div class="space-y-6">
                <div>
                    <h1 class="font-serif text-3xl font-bold text-chocolate">Daftar Akun Baru</h1>
                    <p class="text-xs sm:text-sm text-stone-500 mt-1">Lengkapi data diri untuk memulai pengalaman belanja kue terbaik.</p>
                </div>

                @if($errors->any())
                    <div class="p-3.5 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold rounded-2xl flex items-center space-x-2">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Nama Lengkap
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama Anda" class="w-full pl-10 pr-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400 bg-stone-50/50">
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Alamat Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-stone-400">
                                <i class="fa-regular fa-envelope"></i>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com" class="w-full pl-10 pr-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400 bg-stone-50/50">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                                Kata Sandi
                            </label>
                            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400 bg-stone-50/50">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                                Konfirmasi Sandi
                            </label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400 bg-stone-50/50">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold text-sm shadow-lg shadow-amber-600/30 hover:shadow-xl hover:scale-[1.01] transition-all flex items-center justify-center space-x-2">
                            <span>Daftar Akun Member</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="pt-6 mt-6 border-t border-stone-100 text-center text-xs text-stone-600">
                <span>Sudah memiliki akun?</span>
                <a href="{{ route('login') }}" class="font-bold text-bakery-600 hover:text-bakery-800 ml-1 underline">
                    Masuk di Sini
                </a>
            </div>
        </div>
    </div>

</body>
</html>
