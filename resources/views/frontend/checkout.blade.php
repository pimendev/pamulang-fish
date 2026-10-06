@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="pb-6 mb-8 border-b border-slate-200">
        <span class="text-xs font-bold uppercase tracking-wider text-sky-600">Checkout Pengiriman Hewan Hidup</span>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mt-1">Data Penerima & Ekspedisi Ikan Cupang</h1>
        <p class="text-xs text-slate-500 mt-1">Harap isi nomor telepon WhatsApp aktif untuk konfirmasi foto video ikan sebelum dipacking.</p>
    </div>

    <form method="POST" action="{{ route('checkout.process') }}" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf

        <!-- Form Penerima (7 cols) -->
        <div class="lg:col-span-7 space-y-6 text-xs">
            
            <!-- 1. Data Kontak Penerima -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs">1</span>
                    <span>Informasi Pelanggan & WhatsApp</span>
                </h3>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Nama Lengkap Penerima *</label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', $user->name ?? '') }}" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Email Aktif *</label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', $user->email ?? '') }}" required placeholder="email@domain.com" class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">No. WhatsApp Aktif *</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone', $user->phone ?? '') }}" required placeholder="081234567890" class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs">
                    </div>
                </div>
            </div>

            <!-- 2. Alamat Pengiriman -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs">2</span>
                    <span>Alamat Tujuan Pengiriman</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Provinsi *</label>
                        <input type="text" name="shipping_province" value="{{ old('shipping_province', 'Banten') }}" required class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Kota / Kabupaten *</label>
                        <input type="text" name="shipping_city" value="{{ old('shipping_city', 'Tangerang Selatan') }}" required class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Kecamatan *</label>
                        <input type="text" name="shipping_district" value="{{ old('shipping_district', 'Pamulang') }}" required class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Kode Pos *</label>
                        <input type="text" name="shipping_postal_code" value="{{ old('shipping_postal_code', '15417') }}" required class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs font-mono">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Alamat Lengkap & Patokan Rumah *</label>
                    <textarea name="shipping_address" rows="3" required placeholder="Jl. Pajajaran No. 12 RT 02/05, Kelurahan Pamulang Barat (Pagar Hitam depan musholla)..." class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs">{{ old('shipping_address', $user->address ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Catatan Khusus Pengiriman (Opsional)</label>
                    <input type="text" name="notes" value="{{ old('notes') }}" placeholder="Contoh: Titipkan ke satpam jika tidak ada orang di rumah" class="w-full px-4 py-2.5 border rounded-xl focus:outline-none focus:border-sky-500 text-xs">
                </div>
            </div>

            <!-- 3. Pilihan Ekspedisi Kilat & Metode Pembayaran -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                    <span class="w-6 h-6 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold text-xs">3</span>
                    <span>Opsi Ekspedisi Kilat & Metode Pembayaran</span>
                </h3>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-2">Pilih Kurir Kilat Hewan Hidup (Live Fish Safe)</label>
                    <div class="space-y-2">
                        <label class="border rounded-xl p-3 flex items-center justify-between cursor-pointer hover:border-sky-500 transition has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/50">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="shipping_courier" value="JNE YES (Yakin Esok Sampai) + Oksigen" checked class="text-sky-600">
                                <div>
                                    <span class="font-bold text-slate-900 block">JNE YES (Yakin Esok Sampai)</span>
                                    <span class="text-[10px] text-slate-500">Estimasi tiba 24 jam dengan karantina live fish</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-900">Rp 35.000</span>
                        </label>

                        <label class="border rounded-xl p-3 flex items-center justify-between cursor-pointer hover:border-sky-500 transition has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/50">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="shipping_courier" value="TIKI ONS (Over Night Services) + Oksigen" class="text-sky-600">
                                <div>
                                    <span class="font-bold text-slate-900 block">TIKI ONS (Over Night Services)</span>
                                    <span class="text-[10px] text-slate-500">Pengiriman kilat 1 malam khusus hewan air</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-900">Rp 35.000</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-2">Pilih Metode Pembayaran</label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="border rounded-xl p-3 flex flex-col items-center gap-1 cursor-pointer hover:border-sky-500 transition has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/50 text-center">
                            <input type="radio" name="payment_method" value="bank_transfer" checked class="sr-only">
                            <span class="font-bold text-slate-800">Transfer Bank</span>
                            <span class="text-[10px] text-slate-400">BCA, Mandiri, BRI</span>
                        </label>

                        <label class="border rounded-xl p-3 flex flex-col items-center gap-1 cursor-pointer hover:border-sky-500 transition has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/50 text-center">
                            <input type="radio" name="payment_method" value="qris" class="sr-only">
                            <span class="font-bold text-slate-800">QRIS Instan</span>
                            <span class="text-[10px] text-slate-400">Gopay, OVO, ShopeePay</span>
                        </label>

                        <label class="border rounded-xl p-3 flex flex-col items-center gap-1 cursor-pointer hover:border-sky-500 transition has-[:checked]:border-sky-600 has-[:checked]:bg-sky-50/50 text-center">
                            <input type="radio" name="payment_method" value="virtual_account" class="sr-only">
                            <span class="font-bold text-slate-800">Virtual Account</span>
                            <span class="text-[10px] text-slate-400">Verifikasi Otomatis</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary & Confirmation (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4 text-xs">
                <h3 class="font-extrabold text-slate-900 text-sm pb-3 border-b border-slate-100">
                    Ringkasan Pesanan Cupang
                </h3>

                <!-- Items list -->
                <div class="space-y-3 max-h-60 overflow-y-auto pr-1">
                    @foreach($cart as $item)
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center border">
                                    @if(!empty($item['thumbnail']))
                                        <img src="{{ $item['thumbnail'] }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-[8px] text-slate-400">Cupang</span>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block truncate max-w-[160px]">{{ $item['name'] }}</span>
                                    <span class="text-[10px] text-slate-400">{{ $item['quantity'] }} ekor &times; Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-900">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Costs Breakdown -->
                <div class="pt-3 border-t border-slate-100 space-y-2 text-slate-600">
                    <div class="flex items-center justify-between">
                        <span>Subtotal Spesimen</span>
                        <span class="font-bold text-slate-900">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Ongkir Ekspedisi Kilat 1 Hari</span>
                        <span class="font-bold text-slate-900">Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sky-700">
                        <span>Packing Oksigen & Box Sterofoam</span>
                        <span class="font-bold">Rp {{ number_format($packingCost, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-sm">
                    <span class="font-bold text-slate-900">Total Tagihan</span>
                    <span class="text-2xl font-extrabold text-sky-700">Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <!-- Terms & Live Fish Guarantee Check -->
                <div class="p-3 rounded-xl bg-slate-50 border border-slate-200 text-[11px] text-slate-600 space-y-2">
                    <label class="flex items-start gap-2 cursor-pointer">
                        <input type="checkbox" required checked class="w-4 h-4 rounded text-sky-600 mt-0.5">
                        <span>
                            Saya menyetujui ketentuan garansi <strong>Death on Arrival (D.O.A)</strong>: video unboxing utuh tanpa jeda (cut/pause) jika terjadi kendala pada ikan saat paket dibuka.
                        </span>
                    </label>
                </div>

                <button type="submit" class="w-full py-4 rounded-xl font-bold text-sm bg-sky-600 hover:bg-sky-700 text-white text-center shadow-lg shadow-sky-500/25 transition">
                    Selesaikan Pesanan & Bayar &rarr;
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
