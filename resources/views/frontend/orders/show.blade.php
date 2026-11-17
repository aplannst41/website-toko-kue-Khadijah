@extends('layouts.frontend')

@section('title', 'Pesanan #' . $order->order_number . ' — Khadijah Donat & Cake')

@push('styles')
    @if($order->delivery_type === 'delivery' && $order->shippingAddress && $order->shippingAddress->latitude && $order->shippingAddress->longitude)
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
        <style>
            .leaflet-container { font-family: inherit; z-index: 10; }
        </style>
    @endif
@endpush

@section('content')
    @php
        // Pemetaan warna status yang aman untuk Tailwind CSS
        $badgeClass = match($order->status) {
            'pending'          => 'bg-amber-100 text-amber-900 border-amber-300',
            'paid', 'verified' => 'bg-blue-100 text-blue-900 border-blue-300',
            'processing'       => 'bg-orange-100 text-orange-900 border-orange-300',
            'ready'            => 'bg-purple-100 text-purple-900 border-purple-300',
            'delivered'        => 'bg-cyan-100 text-cyan-900 border-cyan-300',
            'completed'        => 'bg-emerald-100 text-emerald-900 border-emerald-300',
            'cancelled'        => 'bg-rose-100 text-rose-900 border-rose-300',
            default            => 'bg-stone-100 text-stone-800 border-stone-300',
        };

        $isMidtrans = ($order->payment && $order->payment->method === 'midtrans');
    @endphp

    <!-- 1. Header & Konfirmasi Checkout Berhasil -->
    <div class="bg-gradient-to-b from-amber-100/70 via-amber-50/40 to-[#FAF8F5] py-8 border-b border-stone-200/70">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-2 text-xs font-bold text-bakery-700 uppercase tracking-wider mb-1">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-sm"></i>
                        <span>Checkout Selesai • Pesanan Telah Dibuat</span>
                    </div>
                    <h1 class="font-serif text-2xl sm:text-3xl font-extrabold text-chocolate">
                        Pesanan #{{ $order->order_number }}
                    </h1>
                    <p class="text-xs text-stone-500 mt-1">
                        Dibuat pada {{ $order->created_at->format('d M Y, H:i') }} WIB • Pelanggan: <strong class="text-stone-700">{{ $order->user->name }}</strong>
                    </p>
                </div>

                <div class="flex items-center space-x-3">
                    <span class="px-3.5 py-1.5 rounded-full text-xs font-extrabold uppercase border {{ $badgeClass }}">
                        {{ $order->status_label }}
                    </span>
                    <a href="{{ route('orders.index') }}" class="text-xs font-bold text-stone-600 hover:text-bakery-700 bg-white px-3.5 py-2 rounded-xl border border-stone-200 shadow-sm transition-colors flex items-center space-x-1.5">
                        <i class="fa-solid fa-arrow-left"></i>
                        <span>Riwayat Pesanan</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Container -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

        <!-- 2. Kotak Utama Pembayaran (Paling Menonjol) -->
        <div class="bg-white rounded-3xl border-2 {{ $order->status === 'pending' ? 'border-bakery-400 shadow-xl shadow-amber-500/10' : 'border-stone-200/80 shadow-md' }} overflow-hidden">
            <!-- Header Kartu Pembayaran -->
            <div class="bg-gradient-to-r from-stone-900 to-chocolate text-white p-6 sm:p-7 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <span class="text-xs font-bold text-amber-400 uppercase tracking-widest block mb-1">
                        <i class="fa-solid fa-receipt mr-1"></i> Tagihan Pembayaran
                    </span>
                    <div class="flex items-baseline space-x-2">
                        <span class="text-sm text-stone-300">Total yang harus dibayar:</span>
                        <span class="font-serif text-2xl sm:text-3xl font-extrabold text-amber-300">
                            Rp {{ number_format($order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <div class="text-left sm:text-right">
                    <span class="text-xs text-stone-300 block">Metode Pilihan:</span>
                    <span class="text-sm font-bold text-white flex items-center sm:justify-end space-x-1.5 mt-0.5">
                        @if($isMidtrans)
                            <i class="fa-solid fa-bolt-lightning text-amber-400"></i>
                            <span>Midtrans (Otomatis)</span>
                        @elseif($order->payment && $order->payment->method === 'transfer_bsi')
                            <i class="fa-solid fa-building-columns text-teal-400"></i>
                            <span>Transfer Bank BSI</span>
                        @elseif($order->payment && $order->payment->method === 'cod')
                            <i class="fa-solid fa-money-bill-wave text-emerald-400"></i>
                            <span>Bayar Tunai di Kasir</span>
                        @else
                            <i class="fa-solid fa-credit-card text-amber-400"></i>
                            <span>{{ $order->payment->method_label ?? 'Transfer Bank' }}</span>
                        @endif
                    </span>
                </div>
            </div>

            <!-- Konten Pembayaran Sesuai Metode -->
            <div class="p-6 sm:p-8 space-y-6">

                <!-- A. METODE MIDTRANS -->
                @if($isMidtrans)
                    @if($order->status === 'pending')
                        <div class="bg-gradient-to-br from-amber-50/80 via-orange-50/50 to-amber-100/40 p-6 rounded-2xl border border-amber-200/80 text-center space-y-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-bakery-600 to-amber-500 text-white font-extrabold flex items-center justify-center text-2xl mx-auto shadow-md shadow-amber-600/30">
                                <i class="fa-solid fa-wallet"></i>
                            </div>

                            <div class="max-w-md mx-auto space-y-1">
                                <h3 class="font-serif font-bold text-lg text-chocolate">Selesaikan Pembayaran Instan</h3>
                                <p class="text-xs text-stone-600">
                                    Klik tombol di bawah untuk membuka jendela pembayaran resmi Midtrans. Tersedia <strong>QRIS (GoPay, OVO, ShopeePay, DANA)</strong> dan <strong>Virtual Account (BCA, Mandiri, BRI, BSI, BNI)</strong>.
                                </p>
                            </div>

                            <!-- Tombol Bayar Sekarang -->
                            <div class="pt-2 max-w-sm mx-auto">
                                <button id="pay-button" type="button" class="w-full py-4 px-6 bg-gradient-to-r from-bakery-600 via-amber-500 to-bakery-600 hover:from-bakery-700 hover:to-amber-600 text-white font-extrabold rounded-2xl text-base shadow-xl shadow-amber-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center space-x-2">
                                    <i class="fa-solid fa-bolt-lightning text-amber-200"></i>
                                    <span>Bayar Sekarang (Buka Pembayaran)</span>
                                </button>
                                <p class="text-[11px] text-stone-500 mt-2 flex items-center justify-center space-x-1">
                                    <i class="fa-solid fa-shield-halved text-emerald-600"></i>
                                    <span>Verifikasi otomatis dalam hitungan detik setelah bayar.</span>
                                </p>
                            </div>
                        </div>
                    @else
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-900 p-5 rounded-2xl flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center text-xl flex-shrink-0">
                                <i class="fa-solid fa-check-double"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-emerald-950">Pembayaran Berhasil Terverifikasi!</h4>
                                <p class="text-xs text-emerald-800 mt-0.5">
                                    Midtrans telah mengonfirmasi pembayaran Anda. Pesanan kue langsung masuk antrean dapur untuk disiapkan.
                                </p>
                            </div>
                        </div>
                    @endif

                <!-- B. METODE TRANSFER MANUAL (BSI / BCA / MANDIRI) -->
                @elseif($order->payment && str_starts_with($order->payment->method, 'transfer_'))
                    <div class="space-y-5">
                        <div class="bg-amber-50/70 p-5 rounded-2xl border border-amber-200/90 space-y-3">
                            <span class="text-xs font-bold text-bakery-900 uppercase tracking-wider block">
                                Silakan Transfer ke Rekening Resmi Toko:
                            </span>

                            @if($order->payment->method === 'transfer_bsi')
                                <div class="bg-white p-4 rounded-xl border border-teal-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-2 py-0.5 rounded-md bg-teal-100 text-teal-800 text-[10px] font-extrabold uppercase">BSI Syariah</span>
                                            <span class="text-xs text-stone-500">Bank Syariah Indonesia</span>
                                        </div>
                                        <p class="font-mono text-xl font-extrabold text-teal-700 tracking-wider mt-1">7243432671</p>
                                        <p class="text-xs text-stone-600 mt-0.5">a.n. Khadijah Donat &amp; Cake</p>
                                    </div>
                                    <button onclick="navigator.clipboard.writeText('7243432671'); alert('Nomor rekening BSI (7243432671) berhasil disalin!');" class="text-teal-700 hover:text-teal-800 font-bold text-xs bg-teal-50 hover:bg-teal-100 px-4 py-2.5 rounded-xl border border-teal-300 transition-colors flex items-center justify-center space-x-1.5 self-start sm:self-center">
                                        <i class="fa-regular fa-copy"></i>
                                        <span>Salin No. Rekening</span>
                                    </button>
                                </div>
                            @elseif($order->payment->method === 'transfer_mandiri')
                                <div class="bg-white p-4 rounded-xl border border-yellow-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div>
                                        <span class="px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-800 text-[10px] font-extrabold uppercase">Bank Mandiri</span>
                                        <p class="font-mono text-xl font-extrabold text-yellow-800 tracking-wider mt-1">1580-0099-2314</p>
                                        <p class="text-xs text-stone-600 mt-0.5">a.n. Khadijah Donat &amp; Cake</p>
                                    </div>
                                    <button onclick="navigator.clipboard.writeText('158000992314'); alert('Nomor rekening Mandiri berhasil disalin!');" class="text-yellow-800 font-bold text-xs bg-yellow-50 px-4 py-2.5 rounded-xl border border-yellow-300 flex items-center justify-center space-x-1.5">
                                        <i class="fa-regular fa-copy"></i>
                                        <span>Salin No. Rekening</span>
                                    </button>
                                </div>
                            @else
                                <div class="bg-white p-4 rounded-xl border border-blue-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                    <div>
                                        <span class="px-2 py-0.5 rounded-md bg-blue-100 text-blue-800 text-[10px] font-extrabold uppercase">Bank BCA</span>
                                        <p class="font-mono text-xl font-extrabold text-blue-700 tracking-wider mt-1">8830-1928-3341</p>
                                        <p class="text-xs text-stone-600 mt-0.5">a.n. Khadijah Donat &amp; Cake</p>
                                    </div>
                                    <button onclick="navigator.clipboard.writeText('883019283341'); alert('Nomor rekening BCA berhasil disalin!');" class="text-blue-700 font-bold text-xs bg-blue-50 px-4 py-2.5 rounded-xl border border-blue-300 flex items-center justify-center space-x-1.5">
                                        <i class="fa-regular fa-copy"></i>
                                        <span>Salin No. Rekening</span>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <!-- Form Upload Bukti Transfer Manual -->
                        @if($order->status === 'pending')
                            <div class="border border-stone-200 rounded-2xl p-5 bg-stone-50/60 space-y-3">
                                <h4 class="font-bold text-xs text-stone-800 uppercase tracking-wider flex items-center space-x-2">
                                    <i class="fa-solid fa-cloud-arrow-up text-bakery-600"></i>
                                    <span>Unggah Bukti Transfer Manual</span>
                                </h4>
                                <form action="{{ route('orders.payment', $order->order_number) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                                    @csrf
                                    <input type="file" name="proof_image" accept="image/*" required class="w-full text-xs text-stone-600 file:mr-3 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-bakery-100 file:text-bakery-800 hover:file:bg-bakery-200 border border-stone-200 rounded-xl p-2 bg-white">
                                    
                                    <button type="submit" class="w-full py-3 bg-bakery-600 hover:bg-bakery-700 text-white font-bold rounded-xl text-xs shadow-md transition-all flex items-center justify-center space-x-2">
                                        <i class="fa-solid fa-paper-plane"></i>
                                        <span>Kirim Bukti Pembayaran ke Admin</span>
                                    </button>
                                </form>
                            </div>
                        @elseif($order->payment && $order->payment->proof_image)
                            <div class="border border-emerald-200 bg-emerald-50/40 rounded-2xl p-4 flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $order->payment->proof_image) }}" alt="Bukti Transfer" class="w-16 h-16 object-cover rounded-xl border border-stone-200 flex-shrink-0">
                                <div>
                                    <p class="text-xs font-bold text-emerald-900">Bukti transfer telah dikirim!</p>
                                    <p class="text-[11px] text-stone-500 mt-0.5">Admin sedang memverifikasi pembayaran Anda.</p>
                                </div>
                            </div>
                        @endif
                    </div>

                <!-- C. METODE COD / BAYAR DI TEMPAT -->
                @else
                    <div class="bg-amber-50/60 border border-amber-200 p-5 rounded-2xl text-xs space-y-2">
                        <h4 class="font-bold text-stone-800 text-sm flex items-center space-x-2">
                            <i class="fa-solid fa-money-bill-wave text-emerald-600"></i>
                            <span>Bayar di Tempat (COD / Kasir Outlet)</span>
                        </h4>
                        <p class="text-stone-600">
                            Silakan siapkan uang pas sebesar <strong>Rp {{ number_format($order->total, 0, ',', '.') }}</strong> saat mengambil kue di outlet kami (Panggoi, Muara Dua) atau saat kurir tiba di alamat Anda.
                        </p>
                    </div>
                @endif

                <!-- Rincian Biaya -->
                <div class="border-t border-stone-100 pt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 text-xs text-stone-500">
                    <div class="flex items-center space-x-4">
                        <span>Subtotal: <strong class="text-stone-700">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</strong></span>
                        <span>•</span>
                        <span>Ongkir: <strong class="text-stone-700">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</strong></span>
                    </div>

                    <!-- Tombol Bantuan WhatsApp -->
                    @php
                        $phoneClean = preg_replace('/[^0-9]/', '', \App\Models\Setting::get('store_phone', '085360233531'));
                        if (str_starts_with($phoneClean, '0')) {
                            $phoneClean = '62' . substr($phoneClean, 1);
                        }
                    @endphp
                    <a href="https://wa.me/{{ $phoneClean }}?text=Halo%20Admin%20Khadijah%20Cake,%20saya%20sudah%20membuat%20pesanan%20dengan%20nomor%20*{{ $order->order_number }}*%20total%20Rp%20{{ number_format($order->total, 0, ',', '.') }}." target="_blank" class="inline-flex items-center space-x-1.5 text-emerald-700 hover:text-emerald-800 font-bold bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-xl border border-emerald-200 transition-colors">
                        <i class="fa-brands fa-whatsapp text-sm text-emerald-600"></i>
                        <span>Konfirmasi via WhatsApp</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- 3. Dua Kolom: Detail Kue & Informasi Pengiriman -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">

            <!-- Detail Kue Yang Dipesan -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-stone-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                    <h3 class="font-serif font-bold text-lg text-chocolate flex items-center space-x-2">
                        <i class="fa-solid fa-cake-candles text-bakery-600 text-sm"></i>
                        <span>Kue Yang Dipesan</span>
                    </h3>
                    <span class="text-xs font-bold text-stone-400">{{ $order->items->count() }} Menu</span>
                </div>

                <div class="space-y-4 divide-y divide-stone-100">
                    @foreach($order->items as $item)
                        <div class="pt-3 first:pt-0 flex items-start justify-between gap-3">
                            <div class="flex items-start space-x-3">
                                <div class="w-14 h-14 rounded-xl bg-amber-50 overflow-hidden flex-shrink-0 border border-stone-200">
                                    <img src="{{ $item->product->main_image ?? 'https://images.unsplash.com/photo-1578985545062-69928b1d9587?w=200' }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h4 class="font-bold text-xs sm:text-sm text-stone-900 line-clamp-1">{{ $item->product_name }}</h4>
                                    @if($item->variant_info)
                                        <p class="text-[10px] text-bakery-800 bg-amber-50 px-2 py-0.5 rounded-md font-semibold mt-0.5 inline-block border border-amber-200">
                                            🍕 {{ $item->variant_info }}
                                        </p>
                                    @endif
                                    <p class="text-xs text-stone-500 mt-0.5">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                    @if($item->cake_text)
                                        <p class="text-[10px] text-amber-800 bg-amber-50 px-2 py-0.5 rounded-md font-semibold mt-1 inline-block">
                                            🎂 Ucapan: "{{ $item->cake_text }}"
                                        </p>
                                    @endif
                                </div>
                            </div>
                            <span class="font-serif font-bold text-xs sm:text-sm text-chocolate whitespace-nowrap">
                                Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Detail Pengiriman & Jadwal -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-stone-200/80 shadow-sm space-y-4">
                <div class="flex items-center justify-between border-b border-stone-100 pb-3">
                    <h3 class="font-serif font-bold text-lg text-chocolate flex items-center space-x-2">
                        <i class="fa-solid fa-calendar-check text-bakery-600 text-sm"></i>
                        <span>Jadwal & Pengiriman</span>
                    </h3>
                    <span class="text-xs font-extrabold uppercase px-2.5 py-0.5 rounded-md {{ $order->delivery_type === 'delivery' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $order->delivery_type === 'delivery' ? 'Antar Kurir' : 'Ambil Sendiri' }}
                    </span>
                </div>

                <div class="space-y-3 text-xs">
                    <div class="p-3 bg-stone-50 rounded-xl space-y-0.5">
                        <span class="text-stone-400 font-bold uppercase text-[10px]">Tanggal & Jam Pengambilan/Antar:</span>
                        <p class="text-sm font-bold text-stone-800">
                            {{ $order->delivery_date->format('d M Y') }} • {{ $order->delivery_time }}
                        </p>
                    </div>

                    @if($order->shippingAddress)
                        <div class="p-3 bg-stone-50 rounded-xl space-y-1">
                            <span class="text-stone-400 font-bold uppercase text-[10px]">Alamat Penerima:</span>
                            <p class="font-bold text-stone-800">{{ $order->shippingAddress->recipient_name }} ({{ $order->shippingAddress->phone }})</p>
                            <p class="text-stone-600 text-xs leading-relaxed">
                                {{ $order->shippingAddress->address }}, {{ $order->shippingAddress->district }}, Kota Lhokseumawe
                            </p>
                            @if($order->shippingAddress->distance_km)
                                <p class="text-[11px] text-amber-700 font-bold mt-1">
                                    <i class="fa-solid fa-route mr-1"></i> Jarak: ±{{ $order->shippingAddress->distance_km }} km dari outlet Panggoi
                                </p>
                            @endif
                        </div>
                    @endif

                    @if($order->note)
                        <div class="p-3 bg-amber-50/60 rounded-xl border border-amber-200/50 space-y-0.5">
                            <span class="text-amber-800 font-bold uppercase text-[10px]">Catatan Khusus:</span>
                            <p class="text-stone-700 italic">{{ $order->note }}</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
@endsection

@push('scripts')
    @if($isMidtrans && $order->status === 'pending')
        <!-- Midtrans Snap JS Modal -->
        @php
            $snapJsUrl = config('midtrans.is_production', false)
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js';
        @endphp
        <script src="{{ $snapJsUrl }}" data-client-key="{{ $clientKey ?? config('midtrans.client_key') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const payButton = document.getElementById('pay-button');
                if (!payButton) return;

                let currentSnapToken = @json($snapToken);

                async function openSnapPayment() {
                    payButton.disabled = true;
                    payButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i><span>Mempersiapkan Pembayaran...</span>';

                    // Jika token belum terisi di view, minta via AJAX
                    if (!currentSnapToken) {
                        try {
                            const res = await fetch("{{ route('orders.snap_token', $order->order_number) }}");
                            const data = await res.json();
                            if (data.status === 'success' && data.snap_token) {
                                currentSnapToken = data.snap_token;
                            } else {
                                alert(data.message || 'Gagal memuat sesi Midtrans. Silakan periksa kredensial Midtrans di .env.');
                                payButton.disabled = false;
                                payButton.innerHTML = '<i class="fa-solid fa-wallet mr-2"></i><span>Bayar Sekarang (Buka Pembayaran)</span>';
                                return;
                            }
                        } catch (err) {
                            alert('Terjadi kesalahan jaringan saat menghubungi server.');
                            payButton.disabled = false;
                            payButton.innerHTML = '<i class="fa-solid fa-wallet mr-2"></i><span>Bayar Sekarang (Buka Pembayaran)</span>';
                            return;
                        }
                    }

                    // Buka Modal Pop-up Snap Midtrans
                    window.snap.pay(currentSnapToken, {
                        onSuccess: function (result) {
                            window.location.reload();
                        },
                        onPending: function (result) {
                            window.location.reload();
                        },
                        onError: function (result) {
                            alert('Pembayaran gagal atau dibatalkan.');
                            window.location.reload();
                        },
                        onClose: function () {
                            payButton.disabled = false;
                            payButton.innerHTML = '<i class="fa-solid fa-wallet mr-2"></i><span>Bayar Sekarang (Buka Pembayaran)</span>';
                        }
                    });
                }

                // Event Listener Klik Tombol
                payButton.addEventListener('click', openSnapPayment);

                // Auto-open Snap jika pengguna baru saja checkout (opsional, jika token sudah tersedia)
                @if(session('success') && $snapToken)
                    setTimeout(openSnapPayment, 800);
                @endif
            });
        </script>
    @endif
@endpush
