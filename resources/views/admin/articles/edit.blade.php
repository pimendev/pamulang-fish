@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.articles.index') }}" class="text-xs text-sky-600 hover:underline">&larr; Kembali ke Daftar Artikel</a>
    </div>
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Edit Artikel: {{ $article->title }}</h1>
    <p class="text-xs text-slate-500 mt-0.5">Perbarui isi konten artikel panduan cupang dan relasi cross-selling spesimen.</p>
</div>

<form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Form (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Judul Artikel *</label>
                    <input type="text" name="title" value="{{ old('title', $article->title) }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Topik Kategori *</label>
                        <select name="category_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:outline-none focus:border-sky-500">
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $article->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Estimasi Waktu Baca (Menit) *</label>
                        <input type="number" name="reading_time_minutes" value="{{ old('reading_time_minutes', $article->reading_time_minutes) }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Ringkasan Singkat (Excerpt)</label>
                    <textarea name="excerpt" rows="2" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">{{ old('excerpt', $article->excerpt) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Isi Konten Artikel *</label>
                    <textarea name="content" rows="12" required class="w-full px-4 py-2.5 border rounded-xl text-sm font-mono focus:outline-none focus:border-sky-500">{{ old('content', $article->content) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Sidebar / Cross-selling & Publish (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900">Publikasi</h3>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Status Publikasi *</label>
                    <select name="status" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:outline-none focus:border-sky-500">
                        <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published (Terbit)</option>
                        <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft (Draf)</option>
                        <option value="archived" {{ old('status', $article->status) === 'archived' ? 'selected' : '' }}>Archived (Arsip)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Cover Foto Baru (Opsional)</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:bg-sky-50 file:text-sky-700">
                </div>
            </div>

            <!-- Cross-Selling Rekomendasi Ikan Cupang -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-3">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Cross-Selling Cupang</h3>
                    <span class="text-[10px] bg-sky-100 text-sky-800 font-bold px-2 py-0.5 rounded-full">Rekomendasi Produk</span>
                </div>
                <p class="text-[11px] text-slate-400">Centang spesimen ikan yang direkomendasikan:</p>

                @php
                    $attachedIds = $article->relatedProducts->pluck('id')->toArray();
                @endphp
                <div class="max-h-56 overflow-y-auto space-y-2 border rounded-xl p-3 text-xs">
                    @foreach($products as $p)
                        <label class="flex items-center gap-2 cursor-pointer hover:bg-slate-50 p-1 rounded">
                            <input type="checkbox" name="related_products[]" value="{{ $p->id }}" {{ in_array($p->id, $attachedIds) ? 'checked' : '' }} class="w-4 h-4 rounded text-sky-600">
                            <span class="font-medium text-slate-800 truncate">{{ $p->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl text-xs font-bold bg-sky-600 hover:bg-sky-700 text-white shadow-md shadow-sky-500/20 transition">
                Perbarui Panduan Cupang
            </button>
        </div>
    </div>
</form>
@endsection
