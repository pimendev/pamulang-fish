@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center max-w-xl mx-auto mb-10 space-y-2">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-100 text-sky-800">
            <span class="w-1.5 h-1.5 rounded-full bg-sky-600 animate-pulse"></span>
            <span>Live Fish Safe Delivery Tracking</span>
        </span>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pelacakan Ekspedisi Ikan Hidup</h1>
        <p class="text-xs text-slate-500">
            Cek status puasa, packing tabung oksigen, dan nomor resi pengiriman spesimen cupang Anda secara berkala.
        </p>

        <!-- Search Form -->
        <form method="GET" action="{{ route('tracking.index') }}" class="pt-4 flex items-center gap-2 max-w-md mx-auto">
            <input type="text" name="order_number" value="{{ request('order_number') }}" required placeholder="Masukkan Nomor Pesanan (BTC-...)" class="flex-1 px-4 py-3 rounded-xl border border-slate-300 text-xs font-mono uppercase focus:outline-none focus:border-sky-500 shadow-xs">
            <button type="submit" class="px-5 py-3 rounded-xl font-bold text-xs bg-sky-600 hover:bg-sky-700 text-white shadow-md shadow-sky-500/20 transition">
                Lacak Ikan
            </button>
        </form>
    </div>

    @if($order)
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xs space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-slate-100 gap-4">
                <div>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Nomor Pesanan</span>
                    <h2 class="text-xl font-extrabold text-sky-600 font-mono">{{ $order->order_number }}</h2>
                    <span class="text-xs text-slate-500">Penerima: {{ $order->customer_name }}</span>
                </div>
                <div class="text-right">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase bg-slate-900 text-white">
                        Status: {{ str_replace('_', ' ', $order->order_status) }}
                    </span>
                    @if($order->tracking_number)
                        <span class="block text-xs font-mono text-sky-700 font-bold mt-1.5">
                            Resi: {{ $order->tracking_number }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Stepper Timeline -->
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
                    <div class="p-3 rounded-2xl border {{ $isCurrent ? 'bg-sky-50 border-sky-400 text-sky-950 font-bold shadow-xs' : ($isPassed ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-slate-50 border-slate-200 text-slate-400') }}">
                        <div class="w-7 h-7 rounded-full mx-auto mb-2 flex items-center justify-center text-xs font-bold {{ $isCurrent ? 'bg-sky-600 text-white animate-pulse' : ($isPassed ? 'bg-emerald-600 text-white' : 'bg-slate-200 text-slate-500') }}">
                            {{ $loop->iteration }}
                        </div>
                        <span class="text-[11px] block leading-tight">{{ $label }}</span>
                    </div>
                @endforeach
            </div>

            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between text-xs">
                <div>
                    <span class="text-slate-500 block">Kurir Pengiriman:</span>
                    <strong class="text-slate-800">{{ $order->shipping_courier }}</strong>
                </div>
                <a href="{{ route('orders.show', $order->order_number) }}" class="font-bold text-sky-600 hover:underline">
                    Buka Detail Faktur & Bukti Transfer &rarr;
                </a>
            </div>
        </div>
    @elseif(request()->filled('order_number'))
        <div class="text-center py-12 bg-white rounded-3xl border border-slate-200 text-xs text-slate-500 space-y-2">
            <p class="text-rose-600 font-bold">Nomor pesanan "{{ request('order_number') }}" tidak ditemukan.</p>
            <p>Pastikan Anda memasukkan kode pesanan lengkap yang diawali dengan format BTC-...</p>
        </div>
    @endif
</div>
@endsection
