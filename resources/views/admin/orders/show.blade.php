@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.orders.index') }}" class="text-xs text-sky-600 hover:underline">&larr; Kembali ke Daftar Pesanan</a>
    </div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-2">
        <div>
            <span class="text-xs font-mono font-bold text-sky-600 uppercase">{{ $order->order_number }}</span>
            <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-0.5">Kelola Pesanan: {{ $order->customer_name }}</h1>
        </div>
        <div class="flex items-center gap-2">
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                Bayar: {{ $order->payment_status }}
            </span>
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-slate-900 text-white">
                Tahap: {{ str_replace('_', ' ', $order->order_status) }}
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 text-xs">
    
    <!-- Order Details & Items (7 cols) -->
    <div class="lg:col-span-7 space-y-6">
        
        <!-- Items Table -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 pb-3 border-b border-slate-100">
                Spesimen Ikan Cupang yang Dipesan
            </h3>
            <div class="divide-y divide-slate-100">
                @foreach($order->items as $it)
                    <div class="py-3 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden flex-shrink-0 flex items-center justify-center border">
                                @if($it->product && $it->product->thumbnail)
                                    <img src="{{ $it->product->thumbnail }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-[9px] text-slate-400">Cupang</span>
                                @endif
                            </div>
                            <div>
                                <span class="font-bold text-slate-900 block">{{ $it->product_name }}</span>
                                <span class="text-[10px] text-slate-400">SKU: {{ $it->product_sku ?? '-' }} | {{ $it->quantity }} ekor &times; Rp {{ number_format($it->price, 0, ',', '.') }}</span>
                            </div>
                        </div>
                        <span class="font-bold text-slate-900">
                            Rp {{ number_format($it->subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                @endforeach
            </div>

            <!-- Cost Summary -->
            <div class="pt-3 border-t border-slate-100 space-y-1 text-slate-600">
                <div class="flex items-center justify-between">
                    <span>Subtotal Ikan</span>
                    <span class="font-semibold text-slate-900">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span>Ongkir Ekspedisi & Packing Oksigen</span>
                    <span class="font-semibold text-slate-900">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between text-sm font-extrabold text-slate-900 pt-2 border-t">
                    <span>Total Transaksi</span>
                    <span class="text-sky-700 text-base">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Customer & Destination -->
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-3">
            <h3 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100">Alamat Pengiriman Penerima</h3>
            <div class="space-y-1 text-slate-700">
                <p><strong>Penerima:</strong> {{ $order->customer_name }} ({{ $order->customer_phone }})</p>
                <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                <p><strong>Alamat:</strong> {{ $order->shipping_address }}, {{ $order->shipping_district }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} - {{ $order->shipping_postal_code }}</p>
                <p><strong>Kurir Pilihan:</strong> {{ $order->shipping_courier }}</p>
                @if($order->notes)
                    <p class="pt-2 text-slate-500 italic">"{{ $order->notes }}"</p>
                @endif
            </div>
        </div>

        <!-- Payment Proof if exists -->
        @if($order->payment_proof)
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <h3 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100">Bukti Transfer Pelanggan</h3>
                <div class="rounded-xl overflow-hidden border max-w-sm">
                    <img src="{{ $order->payment_proof }}" alt="Bukti Transfer" class="w-full object-cover">
                </div>
            </div>
        @endif
    </div>

    <!-- Update Status & Tracking Form (5 cols) -->
    <div class="lg:col-span-5 space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-900 pb-2 border-b border-slate-100">
                Pembaruan Status Ekspedisi & Resi
            </h3>

            <form method="POST" action="{{ route('admin.orders.update_status', $order) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Status Pembayaran *</label>
                    <select name="payment_status" required class="w-full px-3 py-2 border rounded-xl bg-white focus:outline-none focus:border-sky-500">
                        <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending (Menunggu)</option>
                        <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid (Lunas Terverifikasi)</option>
                        <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed (Gagal)</option>
                        <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded (Dikembalikan)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Tahapan Ekspedisi Ikan Hidup *</label>
                    <select name="order_status" required class="w-full px-3 py-2 border rounded-xl bg-white focus:outline-none focus:border-sky-500">
                        <option value="received" {{ $order->order_status === 'received' ? 'selected' : '' }}>1. Pesanan Diterima</option>
                        <option value="payment_confirmed" {{ $order->order_status === 'payment_confirmed' ? 'selected' : '' }}>2. Pembayaran Terkonfirmasi</option>
                        <option value="fish_preparation" {{ $order->order_status === 'fish_preparation' ? 'selected' : '' }}>3. Puasa & Karantina Ikan</option>
                        <option value="packing" {{ $order->order_status === 'packing' ? 'selected' : '' }}>4. Packing Tabung Oksigen & Box</option>
                        <option value="shipped" {{ $order->order_status === 'shipped' ? 'selected' : '' }}>5. Sedang Dikirim (Shipped)</option>
                        <option value="delivered" {{ $order->order_status === 'delivered' ? 'selected' : '' }}>6. Ikan Tiba dengan Selamat (Delivered)</option>
                        <option value="cancelled" {{ $order->order_status === 'cancelled' ? 'selected' : '' }}>X. Dibatalkan</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Nomor Resi Ekspedisi Kilat</label>
                    <input type="text" name="tracking_number" value="{{ old('tracking_number', $order->tracking_number) }}" placeholder="Contoh: JNE0192837465" class="w-full px-3 py-2 border rounded-xl font-mono uppercase focus:outline-none focus:border-sky-500">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1.5">Catatan Internal Toko</label>
                    <textarea name="notes" rows="3" placeholder="Catatan kondisi fisik ikan, nomor batch packaging..." class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:border-sky-500">{{ old('notes', $order->notes) }}</textarea>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl font-bold bg-sky-600 hover:bg-sky-700 text-white shadow-md shadow-sky-500/20 transition">
                    Simpan Perubahan Pesanan
                </button>
            </form>
        </div>

        <!-- WhatsApp Customer Direct Link -->
        @php
            $waCustomerMsg = urlencode("Halo {$order->customer_name}, update pesanan spesimen cupang Anda (No: {$order->order_number}) saat ini berstatus: " . strtoupper(str_replace('_', ' ', $order->order_status)) . ($order->tracking_number ? " dengan nomor resi kilat: {$order->tracking_number}." : "."));
            $waCustomerUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $order->customer_phone) . "?text={$waCustomerMsg}";
        @endphp
        <a href="{{ $waCustomerUrl }}" target="_blank" class="block w-full py-3 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-center shadow-xs transition">
            Chat WhatsApp Customer &rarr;
        </a>
    </div>
</div>
@endsection
