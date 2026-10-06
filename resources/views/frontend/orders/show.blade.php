@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Top Confirmation Banner -->
    <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-sky-100 text-sky-800">
                        No. Pesanan: {{ $order->order_number }}
                    </span>
                    <span class="text-xs text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Detail Pesanan Spesimen Cupang</h1>
            </div>

            <!-- Status Badges -->
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase {{ $order->payment_status === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                    Pembayaran: {{ $order->payment_status }}
                </span>
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-slate-900 text-white">
                    {{ str_replace('_', ' ', $order->order_status) }}
                </span>
            </div>
        </div>

        <!-- 6-Stage Live Animal Tracking Stepper (Pertemuan 10) -->
        <div class="pt-8">
            <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-6">Tahapan Live Tracking Pengiriman Ikan Hidup:</h3>
            
            @php
                $stages = [
                    'received' => 'Pesanan Diterima',
                    'payment_confirmed' => 'Pembayaran Valid',
                    'fish_preparation' => 'Puasa & Karantina',
                    'packing' => 'Packing Oksigen & Box',
                    'shipped' => 'Dalam Pengiriman',
                    'delivered' => 'Tiba Selamat'
                ];
                $stageKeys = array_keys($stages);
                $currentIdx = array_search($order->order_status, $stageKeys);
                if ($currentIdx === false) $currentIdx = 0;
            @endphp

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 text-center">
                @foreach($stages as $key => $label)
                    @php
                        $idx = array_search($key, $stageKeys);
                        $isPassed = $idx <= $currentIdx;
                        $isCurrent = $idx === $currentIdx;
                    @endphp
                    <div class="p-3 rounded-2xl border transition {{ $isCurrent ? 'bg-sky-50 border-sky-400 text-sky-950 font-bold shadow-xs' : ($isPassed ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-400') }}">
                        <div class="w-7 h-7 rounded-full mx-auto mb-2 flex items-center justify-center text-xs font-bold {{ $isCurrent ? 'bg-sky-600 text-white animate-pulse' : ($isPassed ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500') }}">
                            {{ $loop->iteration }}
                        </div>
                        <span class="text-[11px] block leading-tight">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            @if($order->tracking_number)
                <div class="mt-4 p-3 rounded-xl bg-sky-50 border border-sky-200 flex items-center justify-between text-xs">
                    <div>
                        <span class="text-slate-500 block">Nomor Resi Ekspedisi Kilat:</span>
                        <strong class="font-mono text-sky-800 text-sm">{{ $order->tracking_number }}</strong>
                        <span class="text-[10px] text-slate-400 ml-2">({{ $order->shipping_courier }})</span>
                    </div>
                    <span class="px-2.5 py-1 rounded-lg bg-white border text-sky-700 font-bold">Live Tracking Aktif</span>
                </div>
            @endif
        </div>
    </div>

    <!-- Order Items & Payment Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 text-xs">
        
        <!-- Left: Order Items & Shipping Address (7 cols) -->
        <div class="lg:col-span-7 space-y-6">
            
            <!-- Items Table -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900 pb-3 border-b border-slate-100">
                    Daftar Spesimen Ikan Cupang
                </h3>
                <div class="divide-y divide-slate-100">
                    @foreach($order->items as $it)
                        <div class="py-3 flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($it->product && $it->product->thumbnail)
                                        <img src="{{ $it->product->thumbnail }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block">{{ $it->product_name }}</span>
                                    <span class="text-[10px] text-slate-400">SKU: {{ $it->product_sku ?? '-' }} | {{ $it->quantity }} ekor</span>
                                </div>
                            </div>
                            <span class="font-bold text-slate-900">
                                Rp {{ number_format($it->subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                    @endforeach
                </div>

                <!-- Totals -->
                <div class="pt-3 border-t border-slate-100 space-y-1.5 text-slate-600">
                    <div class="flex items-center justify-between">
                        <span>Subtotal Spesimen</span>
                        <span class="font-semibold text-slate-900">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Ongkos Kirim Kilat & Packing Oksigen</span>
                        <span class="font-semibold text-slate-900">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-sm font-extrabold text-slate-900 pt-2 border-t">
                        <span>Total Pembayaran</span>
                        <span class="text-sky-700 text-lg">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Destination -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-2">
                <h3 class="text-sm font-bold text-slate-900">Tujuan Pengiriman</h3>
                <p class="font-bold text-slate-800">{{ $order->customer_name }} ({{ $order->customer_phone }})</p>
                <p class="text-slate-600 leading-relaxed">{{ $order->shipping_address }}, {{ $order->shipping_district }}, {{ $order->shipping_city }}, {{ $order->shipping_province }} ({{ $order->shipping_postal_code }})</p>
                <p class="text-[11px] text-slate-400">Kurir: {{ $order->shipping_courier }}</p>
                @if($order->notes)
                    <div class="p-2.5 rounded-xl bg-slate-50 text-[11px] text-slate-500 mt-2">
                        <strong>Catatan:</strong> {{ $order->notes }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: Payment Action Box (5 cols) -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Payment Instruction Card -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900">Instruksi Pembayaran</h3>

                @if($order->payment_status === 'paid')
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 space-y-2">
                        <div class="flex items-center gap-2 font-bold text-emerald-700">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            <span>Pembayaran Telah Dikonfirmasi</span>
                        </div>
                        <p class="text-[11px] text-emerald-800/80">
                            Terima kasih! Ikan cupang Anda sedang memasuki tahapan puasa & karantina agar prima saat dikemas dengan oksigen.
                        </p>
                    </div>
                @else
                    <div class="space-y-3">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Bank BCA Transfer</span>
                            <span class="font-mono text-base font-extrabold text-slate-900 block">7210 988 776</span>
                            <span class="text-[11px] text-slate-600 block">a.n. Pamulang Fish Store</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                            <span class="text-[10px] uppercase font-bold text-slate-400 block">Bank Mandiri Transfer</span>
                            <span class="font-mono text-base font-extrabold text-slate-900 block">164 000 8899 88</span>
                            <span class="text-[11px] text-slate-600 block">a.n. Pamulang Fish Store</span>
                        </div>

                        <!-- Payment Confirmation Form -->
                        <form method="POST" action="{{ route('orders.confirm_payment', $order->order_number) }}" enctype="multipart/form-data" class="pt-2 space-y-3">
                            @csrf
                            <div>
                                <label class="block font-bold text-slate-700 uppercase tracking-wider text-[10px] mb-1">Unggah Bukti Transfer (Opsional)</label>
                                <input type="file" name="payment_proof" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-bold file:bg-sky-50 file:text-sky-700">
                            </div>
                            <button type="submit" class="w-full py-3 rounded-xl font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-500/20 transition">
                                Konfirmasi Pembayaran Selesai &rarr;
                            </button>
                        </form>
                    </div>
                @endif

                <!-- WhatsApp Direct Notification Button -->
                @php
                    $waMessage = urlencode("Halo Admin Pamulang Fish Store, saya ingin konfirmasi pesanan cupang:\n\nNo Pesanan: {$order->order_number}\nNama: {$order->customer_name}\nTotal: Rp " . number_format($order->total_amount, 0, ',', '.') . "\n\nMohon dicek dan disiapkan karantina ikannya. Terima kasih!");
                    $waUrl = "https://wa.me/6281234567890?text={$waMessage}";
                @endphp
                <div class="pt-2 border-t border-slate-100">
                    <a href="{{ $waUrl }}" target="_blank" class="w-full py-3 rounded-xl font-bold bg-emerald-500 hover:bg-emerald-600 text-white flex items-center justify-center gap-2 shadow-xs transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Konfirmasi via WhatsApp Langsung</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
