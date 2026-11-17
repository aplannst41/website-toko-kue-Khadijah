@extends('layouts.frontend')

@section('title', 'Profil Saya & Pengaturan Alamat — Khadijah Donat & Cake')

@push('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        .leaflet-container { font-family: inherit; z-index: 10; }
    </style>
@endpush

@section('content')
    <div class="bg-gradient-to-b from-amber-100/60 to-[#FAF8F5] py-8 border-b border-stone-200/60">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-3xl font-bold text-chocolate">Profil & Alamat Pengiriman Saya</h1>
            <p class="text-sm text-stone-600 mt-1">Kelola data diri dan titik lokasi alamat pengantaran kue default Anda.</p>
        </div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
        
        <!-- Status Notification -->
        @if (session('status') === 'profile-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span class="font-bold">Profil dan alamat pengiriman Anda berhasil diperbarui!</span>
            </div>
        @endif

        @if (session('status') === 'password-updated')
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center space-x-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                <span class="font-bold">Password akun Anda berhasil diperbarui!</span>
            </div>
        @endif

        <!-- Card 1: Data Profil & Alamat Pengiriman Lhokseumawe -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-stone-200/80 shadow-sm space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-stone-100">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-bakery-700 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-user-gear"></i>
                </div>
                <div>
                    <h2 class="font-serif font-bold text-xl text-chocolate">Informasi Akun & Alamat Default</h2>
                    <p class="text-xs text-stone-500">Alamat ini akan otomatis terpilih dan terpasang di peta saat Anda checkout.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Nama Lengkap <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Email <span class="text-rose-500">*</span>
                        </label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                        @error('email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- No. WhatsApp / HP -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            No. WhatsApp / HP
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 085360233531"
                               class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                        @error('phone')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kecamatan Lhokseumawe -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Kecamatan (Kota Lhokseumawe)
                        </label>
                        <select name="district" id="profileDistrict" class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400 bg-white">
                            <option value="">-- Pilih Kecamatan --</option>
                            <option value="Muara Dua" {{ old('district', $user->district) === 'Muara Dua' ? 'selected' : '' }}>Muara Dua</option>
                            <option value="Banda Sakti" {{ old('district', $user->district) === 'Banda Sakti' ? 'selected' : '' }}>Banda Sakti</option>
                            <option value="Muara Satu" {{ old('district', $user->district) === 'Muara Satu' ? 'selected' : '' }}>Muara Satu</option>
                            <option value="Blang Mangat" {{ old('district', $user->district) === 'Blang Mangat' ? 'selected' : '' }}>Blang Mangat</option>
                        </select>
                        @error('district')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kota & Provinsi (Readonly) -->
                    <div>
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Kota & Provinsi
                        </label>
                        <input type="text" value="Kota Lhokseumawe, Aceh" readonly
                               class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm bg-stone-100 text-stone-600 cursor-not-allowed">
                        <input type="hidden" name="city" value="Kota Lhokseumawe">
                        <input type="hidden" name="province" value="Aceh">
                    </div>

                    <!-- Alamat Lengkap / Jalan / Gampong -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">
                            Alamat Jalan, No. Rumah, Gampong / Dusun, Patokan
                        </label>
                        <textarea name="address" rows="2" placeholder="Contoh: Jl. Paya Billi - Panggoi Road, Panggoi, samping meunasah"
                                  class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Titik Lokasi Peta Pengantaran -->
                    <div class="sm:col-span-2 space-y-2 pt-2">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider">
                                    <i class="fa-solid fa-map-location-dot text-bakery-600 mr-1"></i> Titik Lokasi Peta Pengantaran
                                </label>
                                <p class="text-[11px] text-stone-500">Geser pin biru ke lokasi rumah Anda agar saat checkout titiknya langsung pas.</p>
                            </div>
                            <button type="button" id="btnCurrentLocation" class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold bg-amber-100 hover:bg-amber-200 text-bakery-800 transition shadow-sm w-fit">
                                <i class="fa-solid fa-crosshairs text-bakery-600"></i>
                                <span>Gunakan Lokasi Saya Saat Ini</span>
                            </button>
                        </div>

                        <!-- Map Leaflet Container -->
                        <div id="profileMap" class="w-full h-64 rounded-2xl border-2 border-stone-200 overflow-hidden shadow-inner relative z-0"></div>

                        <!-- Hidden Inputs for Coordinates -->
                        <input type="hidden" name="latitude" id="inputLat" value="{{ old('latitude', $user->latitude ?? 5.161100) }}">
                        <input type="hidden" name="longitude" id="inputLng" value="{{ old('longitude', $user->longitude ?? 97.135200) }}">

                        <p class="text-[11px] text-stone-500 italic">
                            Koordinat terpilih: <span id="labelCoordinates" class="font-bold text-stone-700">{{ old('latitude', $user->latitude ?? 5.161100) }}, {{ old('longitude', $user->longitude ?? 97.135200) }}</span>
                        </p>
                    </div>
                </div>

                <div class="pt-4 flex justify-end">
                    <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-bakery-600 to-amber-500 hover:from-bakery-700 hover:to-amber-600 text-white font-bold rounded-2xl shadow-lg shadow-amber-600/30 hover:scale-[1.01] transition-all flex items-center space-x-2 text-sm">
                        <i class="fa-solid fa-floppy-disk"></i>
                        <span>Simpan Perubahan Profil & Alamat</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Card 2: Ubah Password -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-stone-200/80 shadow-sm space-y-6">
            <div class="flex items-center space-x-3 pb-4 border-b border-stone-100">
                <div class="w-10 h-10 rounded-2xl bg-amber-100 text-bakery-700 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-lock"></i>
                </div>
                <div>
                    <h2 class="font-serif font-bold text-xl text-chocolate">Ubah Kata Sandi</h2>
                    <p class="text-xs text-stone-500">Pastikan akun Anda menggunakan kata sandi yang kuat dan aman.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4 max-w-xl">
                @csrf
                @method('put')

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required autocomplete="current-password"
                           class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                    @error('current_password', 'updatePassword')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">Kata Sandi Baru</label>
                    <input type="password" name="password" required autocomplete="new-password"
                           class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                    @error('password', 'updatePassword')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-stone-700 uppercase tracking-wider mb-1.5">Ulangi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full px-4 py-3 rounded-2xl border border-stone-200 text-sm focus:ring-2 focus:ring-bakery-400 focus:border-bakery-400">
                    @error('password_confirmation', 'updatePassword')
                        <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="px-6 py-3 bg-stone-800 hover:bg-stone-900 text-white font-bold rounded-2xl text-xs transition-all shadow-md">
                        <span>Perbarui Kata Sandi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputLat = document.getElementById('inputLat');
            const inputLng = document.getElementById('inputLng');
            const labelCoordinates = document.getElementById('labelCoordinates');
            const districtSelect = document.getElementById('profileDistrict');
            const btnCurrentLocation = document.getElementById('btnCurrentLocation');

            let initialLat = parseFloat(inputLat.value) || 5.161100;
            let initialLng = parseFloat(inputLng.value) || 97.135200;

            const map = L.map('profileMap').setView([initialLat, initialLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const userIcon = L.divIcon({
                className: 'custom-pin-user',
                html: `<div style="background-color:#2563eb; color:#fff; width:34px; height:34px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 3px 6px rgba(0,0,0,0.3); border:2px solid #fff;"><i class="fa-solid fa-house-chimney text-sm"></i></div>`,
                iconSize: [34, 34],
                iconAnchor: [17, 17]
            });

            const marker = L.marker([initialLat, initialLng], {
                draggable: true,
                icon: userIcon
            }).addTo(map).bindPopup("<b>Titik Rumah Anda</b><br>Geser ke lokasi rumah Anda").openPopup();

            function updateCoords(lat, lng) {
                const fLat = parseFloat(lat.toFixed(6));
                const fLng = parseFloat(lng.toFixed(6));
                inputLat.value = fLat;
                inputLng.value = fLng;
                labelCoordinates.textContent = fLat + ', ' + fLng;
            }

            marker.on('dragend', function (e) {
                const pos = e.target.getLatLng();
                updateCoords(pos.lat, pos.lng);
            });

            map.on('click', function (e) {
                marker.setLatLng(e.latlng);
                updateCoords(e.latlng.lat, e.latlng.lng);
            });

            // GPS button
            btnCurrentLocation.addEventListener('click', function () {
                if (!navigator.geolocation) {
                    alert('Browser Anda tidak mendukung deteksi lokasi otomatis.');
                    return;
                }

                navigator.geolocation.getCurrentPosition(
                    (pos) => {
                        const lat = pos.coords.latitude;
                        const lng = pos.coords.longitude;
                        marker.setLatLng([lat, lng]);
                        map.setView([lat, lng], 15);
                        updateCoords(lat, lng);
                    },
                    (err) => {
                        alert('Gagal mendeteksi lokasi GPS: ' + err.message);
                    },
                    { enableHighAccuracy: true, timeout: 8000 }
                );
            });

            // District change centers map
            if (districtSelect) {
                const centers = {
                    'Muara Dua': [5.161100, 97.135200],
                    'Banda Sakti': [5.180200, 97.143200],
                    'Muara Satu': [5.215000, 97.070000],
                    'Blang Mangat': [5.127000, 97.149000]
                };

                districtSelect.addEventListener('change', function (e) {
                    const target = centers[e.target.value];
                    if (target) {
                        map.setView(target, 14);
                        marker.setLatLng(target);
                        updateCoords(target[0], target[1]);
                    }
                });
            }
        });
    </script>
@endpush
