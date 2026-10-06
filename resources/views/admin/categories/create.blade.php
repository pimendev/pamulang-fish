@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.categories.index') }}" class="text-xs text-sky-600 hover:underline flex items-center gap-1">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Varietas
        </a>
    </div>
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Tambah Varietas Ikan Cupang Baru</h1>
    <p class="text-xs text-slate-500 mt-0.5">Daftarkan varietas spesimen cupang (misal: Halfmoon Plakat, Dumbo Ear, dll).</p>
</div>

<div class="max-w-2xl bg-white p-8 rounded-2xl border border-slate-200 shadow-xs">
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        @if($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
                <div class="font-bold mb-1">Terdapat kesalahan input:</div>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Kategori Varietas Cupang *</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Cupang Halfmoon (HM)" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500 focus:ring-1 focus:ring-sky-500">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Urutan Tampil (Sort Order) *</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}" required class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Icon Lucide / Keyword (Opsional)</label>
                <input type="text" name="icon" value="{{ old('icon', 'fish') }}" placeholder="fish, crown, zap, shield" class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Ciri Khas Fisik</label>
            <textarea name="description" rows="3" placeholder="Karakteristik bukaan sirip, bentuk ekor, dan keunikan genetik..." class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:outline-none focus:border-sky-500">{{ old('description') }}</textarea>
        </div>

        <!-- Foto Banner Varietas -->
        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-4">
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-800 mb-1">Foto Banner / Ikon Varietas</label>
                <p class="text-xs text-slate-500 mb-3">Foto banner yang akan tampil di beranda dan filter katalog. Format JPG/PNG maksimal 3MB.</p>
                <div class="flex items-center gap-4">
                    <div id="image-preview-container" class="w-20 h-20 rounded-xl bg-slate-200 border border-slate-300 overflow-hidden flex items-center justify-center text-slate-400 shrink-0">
                        <img id="image-preview" src="" alt="Preview" class="w-full h-full object-cover hidden">
                        <svg id="image-placeholder" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div class="flex-1 space-y-2">
                        <input type="file" name="image_file" id="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100 cursor-pointer">
                        <div class="text-[11px] text-slate-400">Atau gunakan URL / path gambar:</div>
                        <input type="text" name="image_url" id="image_url" value="{{ old('image_url') }}" placeholder="/images/categories/custom.jpg atau https://..." class="w-full px-3 py-1.5 border border-slate-200 rounded-lg text-xs focus:outline-none focus:border-sky-500">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', '1') == '1' ? 'checked' : '' }} class="w-4 h-4 rounded text-sky-600 focus:ring-sky-500 border-slate-300">
            <label for="is_active" class="text-xs font-semibold text-slate-700 cursor-pointer">Status Aktif (Tampilkan varietas ini di katalog publik)</label>
        </div>

        <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">Batal</a>
            <button type="submit" class="px-6 py-2.5 rounded-xl text-xs font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md shadow-sky-500/20 transition">
                Simpan Varietas
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('image_file').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const img = document.getElementById('image-preview');
                img.src = evt.target.result;
                img.classList.remove('hidden');
                document.getElementById('image-placeholder').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('image_url').addEventListener('input', function(e) {
        if (e.target.value) {
            const img = document.getElementById('image-preview');
            img.src = e.target.value;
            img.classList.remove('hidden');
            document.getElementById('image-placeholder').classList.add('hidden');
        }
    });
</script>
@endsection
