@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">Master Data</span>
            <span class="text-xs text-slate-400">Varietas Ikan Cupang Hias</span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Kategori Spesies & Varietas Cupang</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola 100% varietas ikan cupang hias (Halfmoon, Plakat, Crowntail, Giant, dll).</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-500/20 transition flex items-center gap-2 self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Tambah Varietas Baru</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <th class="py-3 px-6">Urutan</th>
                    <th class="py-3 px-6">Foto & Nama Varietas</th>
                    <th class="py-3 px-6">Slug URL</th>
                    <th class="py-3 px-6">Total Koleksi</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Deskripsi Ciri Fisik</th>
                    <th class="py-3 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($categories as $cat)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="py-3.5 px-6 font-bold text-slate-400">#{{ $cat->sort_order }}</td>
                        <td class="py-3.5 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-100 border border-slate-200 shrink-0">
                                    <img src="{{ $cat->image ?: asset('images/categories/' . $cat->slug . '.jpg') }}" alt="{{ $cat->name }}" class="w-full h-full object-cover" onerror="this.onerror=null; this.src='{{ asset('images/hero-betta.jpg') }}';">
                                </div>
                                <div>
                                    <span class="font-extrabold text-slate-900 text-sm block">{{ $cat->name }}</span>
                                    <span class="text-[11px] text-slate-400 flex items-center gap-1">
                                        <i data-lucide="{{ $cat->icon ?: 'fish' }}" class="w-3 h-3 text-sky-600"></i>
                                        Ikon: {{ $cat->icon ?: 'fish' }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="py-3.5 px-6 font-mono text-[11px] text-sky-600">{{ $cat->slug }}</td>
                        <td class="py-3.5 px-6">
                            <span class="px-2.5 py-1 rounded-full text-[11px] font-bold bg-sky-50 text-sky-700 border border-sky-100">
                                {{ $cat->products_count }} Ekor
                            </span>
                        </td>
                        <td class="py-3.5 px-6">
                            @if($cat->is_active ?? true)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                    Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="py-3.5 px-6 text-slate-500 max-w-xs truncate">{{ $cat->description ?? '-' }}</td>
                        <td class="py-3.5 px-6 text-right space-x-2">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold text-slate-700 hover:text-sky-600 hover:bg-slate-100 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}" class="inline" onsubmit="return confirm('Hapus kategori {{ $cat->name }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold text-rose-600 hover:bg-rose-50 transition">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-10 text-slate-400">Belum ada kategori varietas cupang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
