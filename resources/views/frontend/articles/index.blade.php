@extends('layouts.app')

@section('content')
<!-- Header Banner -->
<section class="bg-gradient-to-r from-slate-900 via-sky-950 to-slate-900 text-white py-12 border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-sky-500/20 text-sky-300 border border-sky-400/30 mb-3">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-pulse"></span>
                <span>Modul Edukasi & Tips Breeder Pamulang Fish</span>
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Panduan Perawatan Ikan Cupang Hias</h1>
            <p class="text-sm text-slate-300 mt-2 leading-relaxed">
                Pelajari teknik perawatan air ketapang, racikan pakan alami peningkat warna, diagnosis penyakit (fin rot, velvet), dan kiat memelihara mental tarung cupang kontes.
            </p>
        </div>
    </div>
</section>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <!-- Filter Categories -->
    <div class="flex flex-wrap items-center gap-2 pb-6 border-b border-slate-200 mb-8 text-xs">
        <a href="{{ route('articles.index') }}" class="px-4 py-2 rounded-xl font-bold transition {{ !request('category') ? 'bg-sky-600 text-white shadow-xs' : 'bg-white border text-slate-700 hover:bg-slate-50' }}">
            Semua Topik Panduan
        </a>
        @foreach($categories as $ac)
            <a href="{{ route('articles.index', ['category' => $ac->slug]) }}" class="px-4 py-2 rounded-xl font-bold transition {{ request('category') === $ac->slug ? 'bg-sky-600 text-white shadow-xs' : 'bg-white border text-slate-700 hover:bg-slate-50' }}">
                {{ $ac->name }} ({{ $ac->articles_count }})
            </a>
        @endforeach
    </div>

    <!-- Articles Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($articles as $art)
            <article class="bg-white rounded-3xl border border-slate-200/90 shadow-xs overflow-hidden flex flex-col justify-between hover:-translate-y-1 hover:shadow-md transition duration-300">
                <div>
                    <!-- Image or Decorative Header -->
                    <div class="h-48 bg-gradient-to-br from-sky-900 to-slate-900 relative overflow-hidden flex items-center justify-center p-6 text-white">
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(#38bdf8_1px,transparent_1px)] [background-size:16px_16px]"></div>
                        <div class="relative z-10 text-center space-y-2">
                            <span class="inline-block px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-sky-500/30 text-sky-200 border border-sky-400/30 uppercase">
                                {{ $art->category->name }}
                            </span>
                            <div class="text-xs text-slate-300 flex items-center justify-center gap-2">
                                <span>{{ $art->reading_time_minutes }} menit baca</span>
                                <span>&bull;</span>
                                <span>{{ $art->published_at ? $art->published_at->format('d M Y') : $art->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 space-y-3 text-xs">
                        <a href="{{ route('articles.show', $art->slug) }}" class="block">
                            <h3 class="font-extrabold text-slate-900 text-base leading-snug hover:text-sky-600 transition line-clamp-2">
                                {{ $art->title }}
                            </h3>
                        </a>
                        <p class="text-slate-600 line-clamp-3 leading-relaxed">
                            {{ $art->excerpt ?? strip_tags($art->content) }}
                        </p>
                    </div>
                </div>

                <div class="p-6 pt-0 border-t border-slate-100 flex items-center justify-between mt-4">
                    <span class="text-[11px] text-slate-400">Oleh: {{ $art->author->name ?? 'Tim Pamulang Fish' }}</span>
                    <a href="{{ route('articles.show', $art->slug) }}" class="text-xs font-bold text-sky-600 hover:text-sky-700 hover:underline">
                        Baca Selengkapnya &rarr;
                    </a>
                </div>
            </article>
        @empty
            <div class="col-span-full py-16 text-center text-slate-400 text-xs bg-white rounded-3xl border">
                Tidak ada artikel edukasi yang sesuai kriteria pencarian.
            </div>
        @endforelse
    </div>

    @if($articles->hasPages())
        <div class="pt-8">
            {{ $articles->links() }}
        </div>
    @endif
</div>
@endsection
