@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">Katalog Toko</span>
            <span class="text-xs text-slate-400">100% Khusus Ikan Cupang Hias</span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Manajemen Spesimen Ikan Cupang</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola katalog ikan cupang kontes, upload foto asli spesimen, ukuran (BO), umur, dan status ketersediaan.</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-500/20 transition flex items-center gap-2 self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Spesimen Cupang</span>
    </a>
</div>

<!-- Filters Bar -->
<div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-xs mb-6">
    <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 text-xs">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, SKU, corak..." class="w-full px-3 py-2 border rounded-xl focus:outline-none focus:border-sky-500">
        </div>
        <div>
            <select name="category_id" class="w-full px-3 py-2 border rounded-xl bg-white focus:outline-none focus:border-sky-500">
                <option value="">Semua Kategori Varietas</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <select name="betta_type" class="w-full px-3 py-2 border rounded-xl bg-white focus:outline-none focus:border-sky-500">
                <option value="">Semua Tipe Sirip</option>
                <option value="halfmoon" {{ request('betta_type') === 'halfmoon' ? 'selected' : '' }}>Halfmoon</option>
                <option value="plakat" {{ request('betta_type') === 'plakat' ? 'selected' : '' }}>Plakat</option>
                <option value="crowntail" {{ request('betta_type') === 'crowntail' ? 'selected' : '' }}>Crowntail</option>
                <option value="double_tail" {{ request('betta_type') === 'double_tail' ? 'selected' : '' }}>Double Tail</option>
                <option value="giant" {{ request('betta_type') === 'giant' ? 'selected' : '' }}>Giant</option>
            </select>
        </div>
        <div>
            <select name="status" class="w-full px-3 py-2 border rounded-xl bg-white focus:outline-none focus:border-sky-500">
                <option value="">Semua Status Stok</option>
                <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available (Tersedia)</option>
                <option value="sold_out" {{ request('status') === 'sold_out' ? 'selected' : '' }}>Sold Out (Terjual)</option>
                <option value="reserved" {{ request('status') === 'reserved' ? 'selected' : '' }}>Reserved (Dipesan)</option>
                <option value="coming_soon" {{ request('status') === 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
            </select>
        </div>
        <div class="flex items-center gap-2">
            <button type="submit" class="flex-1 py-2 rounded-xl font-bold bg-sky-600 text-white hover:bg-sky-700 transition">
                Filter
            </button>
            <a href="{{ route('admin.products.index') }}" class="px-3 py-2 rounded-xl text-slate-500 border hover:bg-slate-50 transition" title="Reset filter">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <th class="py-3 px-4">Spesimen</th>
                    <th class="py-3 px-4">Varietas & Tipe</th>
                    <th class="py-3 px-4">Gender & Fisik</th>
                    <th class="py-3 px-4">Harga & Diskon</th>
                    <th class="py-3 px-4">Stok</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($products as $p)
                    <tr class="hover:bg-slate-50/60 transition">
                        <!-- Specimen info & thumbnail -->
                        <td class="py-3.5 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-slate-100 border overflow-hidden flex-shrink-0 flex items-center justify-center">
                                    @if($p->thumbnail)
                                        <img src="{{ $p->thumbnail }}" alt="{{ $p->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <span class="font-bold text-slate-900 block leading-tight">{{ $p->name }}</span>
                                    <span class="text-[10px] font-mono text-slate-400 block mt-0.5">SKU: {{ $p->sku }}</span>
                                    @if($p->is_featured)
                                        <span class="inline-block mt-0.5 px-1.5 py-0.2 rounded text-[9px] font-bold bg-amber-100 text-amber-800">★ Unggulan</span>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <!-- Betta Type -->
                        <td class="py-3.5 px-4">
                            <span class="font-semibold text-slate-800 block">{{ $p->category->name }}</span>
                            <span class="text-[10px] uppercase text-sky-600 font-bold block">{{ $p->betta_type }}</span>
                        </td>

                        <!-- Gender & Physical -->
                        <td class="py-3.5 px-4">
                            <div class="space-y-0.5">
                                <span class="capitalize font-semibold text-slate-700 block">{{ $p->gender }}</span>
                                <span class="text-[10px] text-slate-500 block">BO: {{ $p->size_cm ?? '-' }} cm | {{ $p->age_months ?? '-' }} bln</span>
                                @if($p->color_pattern)
                                    <span class="text-[10px] text-slate-400 block truncate max-w-[130px]">{{ $p->color_pattern }}</span>
                                @endif
                            </div>
                        </td>

                        <!-- Price -->
                        <td class="py-3.5 px-4">
                            @if($p->has_discount)
                                <span class="font-bold text-slate-900 block">Rp {{ number_format($p->discount_price, 0, ',', '.') }}</span>
                                <span class="text-[10px] text-slate-400 line-through block">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                            @else
                                <span class="font-bold text-slate-900 block">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                            @endif
                        </td>

                        <!-- Stock -->
                        <td class="py-3.5 px-4">
                            <span class="font-bold {{ $p->stock <= 2 ? 'text-rose-600' : 'text-slate-800' }}">
                                {{ $p->stock }} ekor
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="py-3.5 px-4">
                            @php
                                $badgeClass = match($p->status) {
                                    'available' => 'bg-emerald-100 text-emerald-800',
                                    'sold_out' => 'bg-rose-100 text-rose-800',
                                    'reserved' => 'bg-amber-100 text-amber-800',
                                    default => 'bg-slate-100 text-slate-700'
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $badgeClass }}">
                                {{ $p->status }}
                            </span>
                        </td>

                        <!-- Actions -->
                        <td class="py-3.5 px-4 text-right space-x-1 whitespace-nowrap">
                            <form method="POST" action="{{ route('admin.products.duplicate', $p) }}" class="inline" title="Duplikasi spesimen">
                                @csrf
                                <button type="submit" class="px-2 py-1 rounded text-[11px] font-semibold text-slate-600 hover:bg-slate-100 transition">
                                    Duplikasi
                                </button>
                            </form>
                            <a href="{{ route('admin.products.edit', $p) }}" class="px-2 py-1 rounded text-[11px] font-semibold text-sky-600 hover:bg-sky-50 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $p) }}" class="inline" onsubmit="return confirm('Hapus spesimen {{ $p->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2 py-1 rounded text-[11px] font-semibold text-rose-600 hover:bg-rose-50 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-slate-400">Tidak ada produk spesimen ikan cupang ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="p-4 border-t border-slate-200">
            {{ $products->links() }}
        </div>
    @endif
</div>
@endsection
