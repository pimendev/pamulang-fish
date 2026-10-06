@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <div class="flex items-center gap-2">
            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-sky-100 text-sky-800">Edukasi & Blog</span>
            <span class="text-xs text-slate-400">CMS Edukasi & Cross-Selling</span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Artikel Edukasi & Panduan Cupang</h1>
        <p class="text-xs text-slate-500 mt-0.5">Kelola konten tips budidaya, perawatan air ketapang, dan integrasi cross-selling spesimen cupang.</p>
    </div>
    <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-500/20 transition flex items-center gap-2 self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>Tulis Artikel Panduan Baru</span>
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <th class="py-3 px-6">Judul Artikel</th>
                    <th class="py-3 px-6">Topik Kategori</th>
                    <th class="py-3 px-6">Penulis</th>
                    <th class="py-3 px-6">Dilihat</th>
                    <th class="py-3 px-6">Status</th>
                    <th class="py-3 px-6">Tanggal Rilis</th>
                    <th class="py-3 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($articles as $art)
                    <tr class="hover:bg-slate-50/60 transition">
                        <td class="py-3.5 px-6">
                            <span class="font-extrabold text-slate-900 text-sm block leading-snug">{{ $art->title }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">/articles/{{ $art->slug }}</span>
                        </td>
                        <td class="py-3.5 px-6">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-50 text-sky-700 border border-sky-100">
                                {{ $art->category->name }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 font-medium text-slate-700">{{ $art->author->name ?? '-' }}</td>
                        <td class="py-3.5 px-6 font-bold text-slate-800">{{ number_format($art->views_count) }}x</td>
                        <td class="py-3.5 px-6">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $art->status === 'published' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-700' }}">
                                {{ $art->status }}
                            </span>
                        </td>
                        <td class="py-3.5 px-6 text-slate-400">
                            {{ $art->published_at ? $art->published_at->format('d M Y') : $art->created_at->format('d M Y') }}
                        </td>
                        <td class="py-3.5 px-6 text-right space-x-2">
                            <a href="{{ route('admin.articles.edit', $art) }}" class="inline-flex px-2.5 py-1 rounded-lg text-xs font-semibold text-sky-600 hover:bg-sky-50 transition">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.articles.destroy', $art) }}" class="inline" onsubmit="return confirm('Hapus artikel {{ $art->title }}?');">
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
                        <td colspan="7" class="text-center py-10 text-slate-400">Belum ada artikel panduan perawatan cupang.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
        <div class="p-4 border-t border-slate-100">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
