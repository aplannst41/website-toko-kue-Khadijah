@extends('layouts.frontend')

@section('title', 'Checkout & Pengiriman — Khadijah Donat & Cake')

@push('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        .leaflet-container { font-family: inherit; z-index: 10; }
    </style>
@endpush

@section('content')
    <div class="bg-gradient-to-b from-amber-100/60 to-[#FAF8F5] py-8 border-b border-stone-200/60">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-chocolate">Konfirmasi Pesanan & Pengiriman</h1>
            <p class="text-sm text-stone-600 mt-1">Lengkapi jadwal pengambilan dan metode pembayaran Anda.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" 
         x-data="checkoutApp({
            subtotal: {{ $subtotal }},
            freeMin: {{ $freeShippingMin }},
            storeLat: {{ $storeLat }},
            storeLng: {{ $storeLng }},
            baseKm: {{ $baseKm }},
            baseCost: {{ $baseCost }},
            perKm: {{ $perKm }},
            initialUserLat: {{ Auth::user()->latitude ?? 'null' }},
            initialUserLng: {{ Auth::user()->longitude ?? 'null' }}
         })">
        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
                
                <!-- Left 8 Columns: Form Details -->
                <div class="lg:col-span-8 space-y-8">
                    
                    <!-- 1. Tipe Pengiriman (Toggle: Ambil di Toko vs Delivery) -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/80 shadow-sm space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 rounded-full bg-bakery-600 text-white font-bold text-sm flex items-center justify-center">1</span>
                            <h2 class="font-serif font-bold text-xl text-chocolate">Pilih Cara Penerimaan</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <label class="relative flex flex-col p-5 rounded-2xl border-2 cursor-pointer transition-all" :class="deliveryType === 'delivery' ? 'border-bakery-600 bg-amber-50/50 shadow-sm' : 'border-stone-200 hover:border-stone-300'">
                                <input type="radio" name="delivery_type" value="delivery" x-model="deliveryType" class="sr-only">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-bakery-700 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-truck-fast"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-sm text-stone-900 block">Kirim ke Alamat (Delivery)</span>
                                            <span class="text-xs text-stone-500">Kurir khusus pembawa kue</span>
                                        </div>
                                    </div>
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="deliveryType === 'delivery' ? 'border-bakery-600 bg-bakery-600' : 'border-stone-300'">
                                        <div class="w-2 h-2 rounded-full bg-white"></div>
                                    </div>
                                </div>
                            </label>

                            <label class="relative flex flex-col p-5 rounded-2xl border-2 cursor-pointer transition-all" :class="deliveryType === 'pickup' ? 'border-bakery-600 bg-amber-50/50 shadow-sm' : 'border-stone-200 hover:border-stone-300'">
                                <input type="radio" name="delivery_type" value="pickup" x-model="deliveryType" class="sr-only">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-xl bg-amber-100 text-bakery-700 flex items-center justify-center text-lg">
                                            <i class="fa-solid fa-store"></i>
                                        </div>
                                        <div>
                                            <span class="font-bold text-sm text-stone-900 block">Ambil di Outlet (Pick-up)</span>
                                            <span class="text-xs text-stone-500">Gratis biaya kirim</span>
                                        </div>
                                    </div>
                                    <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center" :class="deliveryType === 'pickup' ? 'border-bakery-600 bg-bakery-600' : 'border-stone-300'">
                                        <div class="w-2 h-2 rounded-full bg-white"></div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- 2. Jadwal Pengambilan / Pengiriman -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/80 shadow-sm space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 rounded-full bg-bakery-600 text-white font-bold text-sm flex items-center justify-center">2</span>
                            <h2 class="font-serif font-bold text-xl text-chocolate">Jadwal Pengambilan / Pengantaran</h2>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                    Tanggal <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" name="delivery_date" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">
                                    Slot Jam Waktu <span class="text-rose-500">*</span>
                                </label>
                                <select name="delivery_time" required class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                                    <option value="09:00 - 11:00 WIB">Pagi (09:00 - 11:00 WIB)</option>
                                    <option value="11:00 - 14:00 WIB">Siang (11:00 - 14:00 WIB)</option>
                                    <option value="14:00 - 17:00 WIB" selected>Sore (14:00 - 17:00 WIB)</option>
                                    <option value="17:00 - 20:00 WIB">Malam (17:00 - 20:00 WIB)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Form Alamat Pengiriman (Muncul jika Delivery) -->
                    <div x-show="deliveryType === 'delivery'" x-transition class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/80 shadow-sm space-y-4">
                        <div class="flex items-center space-x-3">
                            <span class="w-8 h-8 rounded-full bg-bakery-600 text-white font-bold text-sm flex items-center justify-center">3</span>
                            <h2 class="font-serif font-bold text-xl text-chocolate">Alamat Lengkap Pengiriman</h2>
                        </div>

                        <div class="bg-amber-50 border border-amber-200 text-bakery-900 px-4 py-2.5 rounded-xl text-xs flex items-center space-x-2">
                            <i class="fa-solid fa-circle-info text-bakery-600"></i>
                            <span>Pengantaran kurir saat ini <strong>khusus wilayah Kota Lhokseumawe</strong> (Outlet: Panggoi, Muara Dua).</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Nama Penerima <span class="text-rose-500">*</span></label>
                                <input type="text" name="recipient_name" value="{{ Auth::user()->name }}" :required="deliveryType === 'delivery'" class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">No. WhatsApp Penerima <span class="text-rose-500">*</span></label>
                                <input type="text" name="phone" value="{{ Auth::user()->phone ?? '08' }}" :required="deliveryType === 'delivery'" class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Kecamatan (Kota Lhokseumawe) <span class="text-rose-500">*</span></label>
                                <select name="district" id="districtSelect" :required="deliveryType === 'delivery'" class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400 bg-white">
                                    <option value="" disabled {{ !Auth::user()->district ? 'selected' : '' }}>-- Pilih Kecamatan --</option>
                                    <option value="Muara Dua" {{ Auth::user()->district === 'Muara Dua' ? 'selected' : '' }}>Muara Dua</option>
                                    <option value="Banda Sakti" {{ Auth::user()->district === 'Banda Sakti' ? 'selected' : '' }}>Banda Sakti</option>
                                    <option value="Muara Satu" {{ Auth::user()->district === 'Muara Satu' ? 'selected' : '' }}>Muara Satu</option>
                                    <option value="Blang Mangat" {{ Auth::user()->district === 'Blang Mangat' ? 'selected' : '' }}>Blang Mangat</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Kota / Kabupaten</label>
                                <input type="text" name="city" value="Kota Lhokseumawe" readonly class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm bg-stone-100 text-stone-700 cursor-not-allowed">
                            </div>
                            <input type="hidden" name="province" value="Aceh">

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1">Alamat Jalan, No Rumah, Gampong / Dusun, Patokan <span class="text-rose-500">*</span></label>
                                <textarea name="address" id="addressText" rows="2" placeholder="Contoh: Jl. Medan - Banda Aceh, Gampong Panggoi No. 12, samping meunasah" :required="deliveryType === 'delivery'" class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">{{ Auth::user()->address }}</textarea>
                            </div>

                            <!-- Peta Interaktif Titik Antar Leaflet (Gratis OSM) -->
                            <div class="sm:col-span-2 space-y-2 pt-2">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                    <div>
                                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider">
                                            <i class="fa-solid fa-map-location-dot text-bakery-600 mr-1"></i> Titik Lokasi Antar (Peta Interaktif)
                                        </label>
                                        <p class="text-[11px] text-stone-500">Klik atau geser pin di peta untuk menentukan titik rumah Anda dengan tepat.</p>
                                    </div>
                                    <button type="button" @click="useCurrentLocation()" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-100 hover:bg-amber-200 text-bakery-800 transition shadow-sm w-fit">
                                        <i class="fa-solid fa-crosshairs text-bakery-600"></i>
                                        <span>Gunakan Lokasi Saya Saat Ini</span>
                                    </button>
                                </div>

                                <!-- Map Container -->
                                <div id="mapPicker" class="w-full h-64 rounded-2xl border-2 border-stone-200 overflow-hidden shadow-inner relative z-0"></div>

                                <!-- Delivery Distance & Route Info Badge -->
                                <div class="p-3 bg-amber-50/70 border border-amber-200/80 rounded-2xl flex items-center justify-between text-xs">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-8 h-8 rounded-xl bg-bakery-100 text-bakery-700 flex items-center justify-center font-bold">
                                            <i class="fa-solid fa-route"></i>
                                        </div>
                                        <div>
                                            <span class="text-stone-500 block text-[10px]">Perkiraan Jarak dari Outlet Panggoi:</span>
                                            <span class="font-extrabold text-stone-900 text-sm" x-text="distanceKm > 0 ? (distanceKm + ' km') : 'Memilih titik...'"></span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-stone-500 block text-[10px]">Ongkir Dihitung:</span>
                                        <span class="font-bold text-bakery-700 text-sm" x-text="subtotal >= freeMin ? 'Gratis (Promo)' : ('Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost))"></span>
                                    </div>
                                </div>

                                <!-- Hidden Inputs for Backend Coordinates -->
                                <input type="hidden" name="latitude" :value="userLat">
                                <input type="hidden" name="longitude" :value="userLng">
                                <input type="hidden" name="distance_km" :value="distanceKm">
                            </div>
                        </div>
                    </div>

                    <!-- 4. Metode Pembayaran -->
                    <!-- 4. Metode Pembayaran -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/80 shadow-sm space-y-5" x-data="{ method: 'midtrans', showManual: false }">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <span class="w-8 h-8 rounded-full bg-bakery-600 text-white font-bold text-sm flex items-center justify-center">4</span>
                                <h2 class="font-serif font-bold text-xl text-chocolate">Pilih Metode Pembayaran</h2>
                            </div>
                            <span class="text-xs text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full font-bold flex items-center space-x-1">
                                <i class="fa-solid fa-shield-halved"></i>
                                <span>100% Aman &amp; Terverifikasi</span>
                            </span>
                        </div>

                        <!-- 2 Opsi Utama yang Simetris & Normal (50% - 50%) -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 pt-1">
                            <!-- OPSI 1: Pembayaran Online & QRIS Otomatis (Midtrans) -->
                            <label class="relative flex flex-col justify-between p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200 group"
                                :class="method === 'midtrans' ? 'border-bakery-600 bg-amber-50/70 shadow-sm ring-1 ring-bakery-500' : 'border-stone-200 hover:border-stone-300 bg-white'">
                                <div>
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-bakery-600 to-amber-500 text-white flex items-center justify-center text-lg shadow-sm">
                                                <i class="fa-solid fa-bolt-lightning"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center space-x-1.5 flex-wrap">
                                                    <span class="font-bold text-stone-900 text-sm sm:text-base">Pembayaran Otomatis</span>
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 text-emerald-800 uppercase tracking-wide">Midtrans</span>
                                                </div>
                                                <span class="text-[11px] text-emerald-700 font-bold flex items-center mt-0.5">
                                                    <i class="fa-solid fa-circle-check text-[10px] mr-1"></i> Verifikasi Instan (Tanpa Struk)
                                                </span>
                                            </div>
                                        </div>
                                        <input type="radio" name="payment_method" value="midtrans" x-model="method" class="sr-only">
                                        <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all flex-shrink-0"
                                            :class="method === 'midtrans' ? 'border-bakery-600 bg-bakery-600 text-white' : 'border-stone-300'">
                                            <i class="fa-solid fa-check text-xs" x-show="method === 'midtrans'"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-stone-600 mt-3 leading-relaxed">
                                        Bisa bayar langsung via <strong>QRIS</strong> (GoPay, OVO, ShopeePay, DANA) atau <strong>Virtual Account</strong> (BCA, Mandiri, BRI, BNI, BSI).
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-1.5 mt-3 pt-3 border-t border-amber-200/60">
                                    <span class="px-2 py-0.5 rounded bg-white border border-stone-200 text-[10px] font-extrabold text-stone-800">QRIS</span>
                                    <span class="px-2 py-0.5 rounded bg-teal-50 text-[10px] font-bold text-teal-800">GoPay</span>
                                    <span class="px-2 py-0.5 rounded bg-orange-50 text-[10px] font-bold text-orange-800">ShopeePay</span>
                                    <span class="px-2 py-0.5 rounded bg-blue-50 text-[10px] font-bold text-blue-800">BCA VA</span>
                                    <span class="px-2 py-0.5 rounded bg-yellow-50 text-[10px] font-bold text-yellow-800">Mandiri VA</span>
                                    <span class="px-2 py-0.5 rounded bg-emerald-50 text-[10px] font-bold text-emerald-800">BSI VA</span>
                                </div>
                            </label>

                            <!-- OPSI 2: Bayar Tunai (Kasir Outlet / COD) -->
                            <label class="relative flex flex-col justify-between p-5 rounded-2xl border-2 cursor-pointer transition-all duration-200 group"
                                :class="method === 'cod' ? 'border-bakery-600 bg-amber-50/70 shadow-sm ring-1 ring-bakery-500' : 'border-stone-200 hover:border-stone-300 bg-white'">
                                <div>
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white flex items-center justify-center text-lg shadow-sm">
                                                <i class="fa-solid fa-money-bill-wave"></i>
                                            </div>
                                            <div>
                                                <div class="flex items-center space-x-1.5 flex-wrap">
                                                    <span class="font-bold text-stone-900 text-sm sm:text-base">Bayar Tunai di Kasir</span>
                                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-stone-100 text-stone-700 uppercase tracking-wide">COD / Outlet</span>
                                                </div>
                                                <span class="text-[11px] text-stone-500 font-medium flex items-center mt-0.5">
                                                    <i class="fa-solid fa-store text-[10px] mr-1 text-emerald-600"></i> Bayar Saat Ambil / Terima Kue
                                                </span>
                                            </div>
                                        </div>
                                        <input type="radio" name="payment_method" value="cod" x-model="method" class="sr-only">
                                        <div class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all flex-shrink-0"
                                            :class="method === 'cod' ? 'border-bakery-600 bg-bakery-600 text-white' : 'border-stone-300'">
                                            <i class="fa-solid fa-check text-xs" x-show="method === 'cod'"></i>
                                        </div>
                                    </div>
                                    <p class="text-xs text-stone-600 mt-3 leading-relaxed">
                                        Bayar secara tunai (cash) langsung di kasir Outlet Happizza saat mengambil kue atau bayar kepada kurir saat pesanan sampai.
                                    </p>
                                </div>

                                <div class="flex items-center gap-1.5 mt-3 pt-3 border-t border-stone-100 text-[11px] text-stone-500">
                                    <i class="fa-solid fa-hand-holding-dollar text-emerald-600 text-xs"></i>
                                    <span>Tanpa perlu transfer atau scan terlebih dahulu</span>
                                </div>
                            </label>
                        </div>

                        <!-- OPSI ALTERNATIF: Transfer Bank Manual (Collapsible / Toggle Rapi) -->
                        <div class="pt-2 border-t border-stone-100">
                            <button type="button" @click="showManual = !showManual" class="text-xs font-semibold text-stone-500 hover:text-bakery-700 flex items-center space-x-2 transition py-1">
                                <i class="fa-solid text-[10px] transition-transform duration-200" :class="showManual ? 'fa-chevron-down' : 'fa-chevron-right'"></i>
                                <span>Pilihan lain: Ingin Transfer Bank Manual ke Rekening Toko? (Klik di sini)</span>
                            </button>

                            <div x-show="showManual" x-collapse class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 pt-3">
                                <!-- BSI -->
                                <label class="flex items-center justify-between p-3.5 rounded-xl border-2 cursor-pointer transition-all"
                                    :class="method === 'transfer_bsi' ? 'border-bakery-600 bg-amber-50/70 font-bold' : 'border-stone-200 hover:border-stone-300'">
                                    <div class="flex items-center space-x-2.5">
                                        <input type="radio" name="payment_method" value="transfer_bsi" x-model="method" class="sr-only">
                                        <div class="w-7 h-7 rounded-lg bg-teal-50 text-teal-700 font-extrabold flex items-center justify-center text-[10px]">BSI</div>
                                        <span class="text-xs text-stone-800">Transfer BSI</span>
                                    </div>
                                    <i class="fa-solid fa-circle-check text-bakery-600 text-sm" x-show="method === 'transfer_bsi'"></i>
                                </label>

                                <!-- BCA -->
                                <label class="flex items-center justify-between p-3.5 rounded-xl border-2 cursor-pointer transition-all"
                                    :class="method === 'transfer_bca' ? 'border-bakery-600 bg-amber-50/70 font-bold' : 'border-stone-200 hover:border-stone-300'">
                                    <div class="flex items-center space-x-2.5">
                                        <input type="radio" name="payment_method" value="transfer_bca" x-model="method" class="sr-only">
                                        <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-700 font-extrabold flex items-center justify-center text-[10px]">BCA</div>
                                        <span class="text-xs text-stone-800">Transfer BCA</span>
                                    </div>
                                    <i class="fa-solid fa-circle-check text-bakery-600 text-sm" x-show="method === 'transfer_bca'"></i>
                                </label>

                                <!-- Mandiri -->
                                <label class="flex items-center justify-between p-3.5 rounded-xl border-2 cursor-pointer transition-all"
                                    :class="method === 'transfer_mandiri' ? 'border-bakery-600 bg-amber-50/70 font-bold' : 'border-stone-200 hover:border-stone-300'">
                                    <div class="flex items-center space-x-2.5">
                                        <input type="radio" name="payment_method" value="transfer_mandiri" x-model="method" class="sr-only">
                                        <div class="w-7 h-7 rounded-lg bg-yellow-50 text-yellow-800 font-extrabold flex items-center justify-center text-[10px]">MDR</div>
                                        <span class="text-xs text-stone-800">Transfer Mandiri</span>
                                    </div>
                                    <i class="fa-solid fa-circle-check text-bakery-600 text-sm" x-show="method === 'transfer_mandiri'"></i>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Catatan Tambahan -->
                    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/80 shadow-sm space-y-3">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider">Catatan Tambahan Untuk Baker / Driver (Opsional):</label>
                        <textarea name="note" rows="2" placeholder="Misal: Harap dikirim tepat pukul 14:00 untuk surprise, atau simpan di pos satpam jika tidak ada orang." class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400"></textarea>
                    </div>
                </div>

                <!-- Right 4 Columns: Order Summary & Confirm -->
                <div class="lg:col-span-4 bg-white rounded-3xl p-6 sm:p-8 border border-stone-200/80 shadow-md space-y-6 sticky top-28">
                    <h2 class="font-serif font-bold text-xl text-chocolate border-b border-stone-100 pb-3">Ringkasan Pesanan</h2>

                    <!-- Items snapshot -->
                    <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                        @foreach($cart->items as $item)
                            <div class="flex items-center justify-between text-xs py-1 border-b border-stone-50">
                                <div class="flex items-center space-x-2">
                                    <span class="w-5 h-5 rounded-md bg-stone-100 flex items-center justify-center font-bold text-stone-700">{{ $item->quantity }}x</span>
                                    <div>
                                        <p class="font-bold text-stone-800 line-clamp-1">{{ $item->product->name }}</p>
                                        @if($item->variant)
                                            <p class="text-[10px] text-bakery-700 font-semibold">{{ $item->variant->value }}</p>
                                        @endif
                                        @if($item->cake_text)
                                            <p class="text-[10px] text-amber-700 italic">"{{ $item->cake_text }}"</p>
                                        @endif
                                    </div>
                                </div>
                                <span class="font-semibold text-stone-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pricing Calculation -->
                    <div class="space-y-3 text-sm text-stone-600 border-t border-stone-100 pt-3">
                        <div class="flex justify-between">
                            <span>Subtotal Menu</span>
                            <span class="font-bold text-stone-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span>Ongkos Kirim</span>
                            <span class="font-bold" :class="deliveryType === 'pickup' || subtotal >= freeMin ? 'text-emerald-600' : 'text-stone-800'" x-text="deliveryType === 'pickup' ? 'Rp 0 (Pick-up)' : (subtotal >= freeMin ? 'Rp 0 (Gratis Promo)' : ('Rp ' + new Intl.NumberFormat('id-ID').format(shippingCost)))">
                            </span>
                        </div>
                        <div class="border-t border-stone-200/80 pt-3 flex justify-between items-baseline">
                            <span class="font-bold text-chocolate text-base">Total Bayar</span>
                            <span class="font-serif font-extrabold text-2xl text-chocolate" x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(totalPay)">
                            </span>
                        </div>
                    </div>

                    <!-- Submit Order Button -->
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold rounded-2xl shadow-lg shadow-amber-600/30 hover:shadow-xl hover:scale-[1.01] transition-all flex items-center justify-center space-x-2 text-sm">
                        <span>Konfirmasi & Buat Pesanan</span>
                        <i class="fa-solid fa-check"></i>
                    </button>

                    <p class="text-[11px] text-center text-stone-500">
                        Dengan mengklik tombol di atas, Anda menyetujui ketentuan pemesanan kue di Khadijah Donat & Cake.
                    </p>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        function checkoutApp(config) {
            return {
                deliveryType: 'delivery',
                subtotal: config.subtotal,
                freeMin: config.freeMin,
                storeLat: config.storeLat,
                storeLng: config.storeLng,
                baseKm: config.baseKm,
                baseCost: config.baseCost,
                perKm: config.perKm,
                userLat: 5.161100,
                userLng: 97.135200,
                distanceKm: 0,
                map: null,
                userMarker: null,
                storeMarker: null,
                routeLine: null,

                init() {
                    this.$watch('deliveryType', (val) => {
                        if (val === 'delivery') {
                            this.$nextTick(() => {
                                if (this.map) {
                                    this.map.invalidateSize();
                                } else {
                                    this.initMap();
                                }
                            });
                        }
                    });

                    // District change auto-centers map
                    this.$nextTick(() => {
                        this.initMap();
                        const districtSelect = document.getElementById('districtSelect');
                        if (districtSelect) {
                            districtSelect.addEventListener('change', (e) => {
                                this.onDistrictSelect(e.target.value);
                            });
                        }
                    });
                },

                initMap() {
                    const el = document.getElementById('mapPicker');
                    if (!el || this.map) return;

                    // Initialize Map centered on Panggoi, Lhokseumawe
                    this.map = L.map('mapPicker').setView([this.storeLat, this.storeLng], 14);

                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; OpenStreetMap'
                    }).addTo(this.map);

                    // Toko Marker (Panggoi)
                    const storeIcon = L.divIcon({
                        className: 'custom-pin-store',
                        html: `<div style="background-color:#bb5315; color:#fff; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 3px 6px rgba(0,0,0,0.3); border:2px solid #fff;"><i class="fa-solid fa-store text-sm"></i></div>`,
                        iconSize: [34, 34],
                        iconAnchor: [17, 17]
                    });

                    this.storeMarker = L.marker([this.storeLat, this.storeLng], { icon: storeIcon }).addTo(this.map)
                        .bindPopup("<b>Outlet Khadijah Donat & Cake</b><br>Panggoi, Muara Dua, Lhokseumawe");

                    // Customer Delivery Marker (Draggable)
                    const customerIcon = L.divIcon({
                        className: 'custom-pin-user',
                        html: `<div style="background-color:#2563eb; color:#fff; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 3px 6px rgba(0,0,0,0.3); border:2px solid #fff;"><i class="fa-solid fa-house-chimney text-sm"></i></div>`,
                        iconSize: [34, 34],
                        iconAnchor: [17, 17]
                    });

                    // Default user position from user's saved profile, or fallback slightly offset from store
                    if (config.initialUserLat && config.initialUserLng) {
                        this.userLat = parseFloat(config.initialUserLat);
                        this.userLng = parseFloat(config.initialUserLng);
                    } else {
                        this.userLat = this.storeLat + 0.005;
                        this.userLng = this.storeLng + 0.005;
                    }

                    this.userMarker = L.marker([this.userLat, this.userLng], {
                        draggable: true,
                        icon: customerIcon
                    }).addTo(this.map).bindPopup("<b>Titik Pengantaran Anda</b><br>Geser ke lokasi rumah Anda");

                    this.userMarker.on('dragend', (e) => {
                        const pos = e.target.getLatLng();
                        this.updateUserPosition(pos.lat, pos.lng);
                    });

                    this.map.on('click', (e) => {
                        this.userMarker.setLatLng(e.latlng);
                        this.updateUserPosition(e.latlng.lat, e.latlng.lng);
                    });

                    this.updateUserPosition(this.userLat, this.userLng);
                },

                updateUserPosition(lat, lng) {
                    this.userLat = parseFloat(lat.toFixed(6));
                    this.userLng = parseFloat(lng.toFixed(6));

                    // Calculate straight road distance (Haversine formula * road winding factor 1.25)
                    const straightKm = this.calculateDistance(this.storeLat, this.storeLng, this.userLat, this.userLng);
                    this.distanceKm = parseFloat((straightKm * 1.25).toFixed(1));

                    // Update Route Line
                    if (this.routeLine) {
                        this.map.removeLayer(this.routeLine);
                    }
                    this.routeLine = L.polyline([
                        [this.storeLat, this.storeLng],
                        [this.userLat, this.userLng]
                    ], {
                        color: '#f09138',
                        weight: 4,
                        opacity: 0.8,
                        dashArray: '8, 8'
                    }).addTo(this.map);
                },

                useCurrentLocation() {
                    if (!navigator.geolocation) {
                        alert('Browser Anda tidak mendukung deteksi lokasi otomatis.');
                        return;
                    }

                    navigator.geolocation.getCurrentPosition(
                        (pos) => {
                            const lat = pos.coords.latitude;
                            const lng = pos.coords.longitude;
                            if (this.userMarker && this.map) {
                                this.userMarker.setLatLng([lat, lng]);
                                this.map.setView([lat, lng], 15);
                                this.updateUserPosition(lat, lng);
                            }
                        },
                        (err) => {
                            alert('Gagal mendeteksi lokasi GPS: ' + err.message + '. Silakan klik langsung pada peta.');
                        },
                        { enableHighAccuracy: true, timeout: 8000 }
                    );
                },

                onDistrictSelect(district) {
                    // Coordinates approximate center of Lhokseumawe districts
                    const centers = {
                        'Muara Dua': [5.161100, 97.135200],
                        'Banda Sakti': [5.180200, 97.143200],
                        'Muara Satu': [5.215000, 97.070000],
                        'Blang Mangat': [5.127000, 97.149000]
                    };

                    if (centers[district] && this.map && this.userMarker) {
                        const target = centers[district];
                        this.map.setView(target, 14);
                        this.userMarker.setLatLng(target);
                        this.updateUserPosition(target[0], target[1]);
                    }
                },

                // Haversine formula
                calculateDistance(lat1, lon1, lat2, lon2) {
                    const R = 6371; // km
                    const dLat = (lat2 - lat1) * Math.PI / 180;
                    const dLon = (lon2 - lon1) * Math.PI / 180;
                    const a = 
                        Math.sin(dLat/2) * Math.sin(dLat/2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * 
                        Math.sin(dLon/2) * Math.sin(dLon/2);
                    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                    return R * c;
                },

                get shippingCost() {
                    if (this.deliveryType === 'pickup') return 0;
                    if (this.subtotal >= this.freeMin) return 0;
                    
                    if (this.distanceKm <= this.baseKm) {
                        return this.baseCost;
                    }
                    const extraKm = Math.ceil(this.distanceKm - this.baseKm);
                    return this.baseCost + (extraKm * this.perKm);
                },

                get totalPay() {
                    return this.subtotal + this.shippingCost;
                }
            }
        }
    </script>
@endpush
