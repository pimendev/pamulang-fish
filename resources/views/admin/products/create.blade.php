@extends('layouts.admin')

@section('content')
<div class="pb-8 mb-8 border-b border-slate-200">
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.products.index') }}" class="text-xs text-sky-600 hover:underline">&larr; Kembali ke Daftar Spesimen</a>
    </div>
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">Tambah Spesimen Ikan Cupang Baru</h1>
    <p class="text-xs text-slate-500 mt-0.5">Input spesifikasi rinci ikan cupang kontes (WYSIWYG: What You See Is What You Get).</p>
</div>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="space-y-8">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Info (8 cols) -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Identitas Dasar -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900">1. Identitas Spesimen Cupang</h3>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Nama Spesimen Ikan Cupang *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Ikan Cupang Halfmoon Blue Rim Grade A" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">SKU / Kode Spesimen *</label>
                        <input type="text" name="sku" value="{{ old('sku', 'HM-' . strtoupper(Str::random(5))) }}" required class="w-full px-4 py-2.5 border rounded-xl text-sm font-mono focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Kategori Varietas *</label>
                        <select name="category_id" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:outline-none focus:border-sky-500">
                            <option value="">Pilih Kategori Varietas</option>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Deskripsi Spesimen</label>
                    <textarea name="description" rows="4" placeholder="Jelaskan karakteristik mental, bukaan ekor, warna, dan keistimewaan ikan..." class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Panduan Perawatan Khusus (Care Guide)</label>
                    <textarea name="care_guide" rows="3" placeholder="Ukuran soliter, takaran daun ketapang olahan, suhu ideal..." class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">{{ old('care_guide') }}</textarea>
                </div>
            </div>

            <!-- Morfologi & Karakteristik Fisik -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900">2. Morfologi & Atribut Khusus Cupang</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tipe Sirip (Betta Type) *</label>
                        <select name="betta_type" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:outline-none focus:border-sky-500">
                            <option value="halfmoon" {{ old('betta_type') === 'halfmoon' ? 'selected' : '' }}>Halfmoon</option>
                            <option value="plakat" {{ old('betta_type') === 'plakat' ? 'selected' : '' }}>Plakat</option>
                            <option value="crowntail" {{ old('betta_type') === 'crowntail' ? 'selected' : '' }}>Crowntail</option>
                            <option value="double_tail" {{ old('betta_type') === 'double_tail' ? 'selected' : '' }}>Double Tail</option>
                            <option value="giant" {{ old('betta_type') === 'giant' ? 'selected' : '' }}>Giant</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jenis Kelamin (Gender) *</label>
                        <select name="gender" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:outline-none focus:border-sky-500">
                            <option value="male" {{ old('gender') === 'male' ? 'selected' : '' }}>Jantan (Male)</option>
                            <option value="female" {{ old('gender') === 'female' ? 'selected' : '' }}>Betina (Female)</option>
                            <option value="unsexed" {{ old('gender') === 'unsexed' ? 'selected' : '' }}>Unsexed (Burayak)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Tingkat Perawatan *</label>
                        <select name="care_level" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:outline-none focus:border-sky-500">
                            <option value="beginner" {{ old('care_level') === 'beginner' ? 'selected' : '' }}>Beginner (Pemula)</option>
                            <option value="intermediate" {{ old('care_level') === 'intermediate' ? 'selected' : '' }}>Intermediate (Sedang)</option>
                            <option value="advanced" {{ old('care_level') === 'advanced' ? 'selected' : '' }}>Advanced (Kontes/Breeder)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Ukuran Badan / BO (cm)</label>
                        <input type="number" step="0.1" name="size_cm" value="{{ old('size_cm', '4.5') }}" placeholder="4.5" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Umur Ikan (Bulan)</label>
                        <input type="number" step="0.1" name="age_months" value="{{ old('age_months', '3.5') }}" placeholder="3.5" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Pola / Corak Warna</label>
                        <input type="text" name="color_pattern" value="{{ old('color_pattern') }}" placeholder="Contoh: Multicolor Galaxy Blue" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar / Pricing & Images (4 cols) -->
        <div class="lg:col-span-4 space-y-6">
            
            <!-- Harga & Status Stok -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900">3. Harga & Ketersediaan</h3>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Harga Normal (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price') }}" placeholder="250000" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Harga Diskon / Promo (Rp)</label>
                    <input type="number" name="discount_price" value="{{ old('discount_price') }}" placeholder="199000" class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Jumlah Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', 1) }}" min="0" required class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none focus:border-sky-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Status Stok *</label>
                        <select name="status" required class="w-full px-4 py-2.5 border rounded-xl text-sm bg-white focus:outline-none focus:border-sky-500">
                            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="sold_out" {{ old('status') === 'sold_out' ? 'selected' : '' }}>Sold Out</option>
                            <option value="reserved" {{ old('status') === 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="coming_soon" {{ old('status') === 'coming_soon' ? 'selected' : '' }}>Coming Soon</option>
                        </select>
                    </div>
                </div>

                <div class="pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="w-4 h-4 rounded text-sky-600">
                        <span class="text-xs font-bold text-slate-800">Tampilkan di Pilihan Terpopuler (Featured)</span>
                    </label>
                </div>
            </div>

            <!-- Upload Foto Spesimen -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900">4. Foto Asli Spesimen Cupang</h3>
                <p class="text-[11px] text-slate-400 leading-relaxed">
                    Unggah foto close-up spesimen ikan atau gunakan URL gambar beresolusi tinggi.
                </p>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Upload File Foto</label>
                    <input type="file" name="image_file" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-sky-50 file:text-sky-700 hover:file:bg-sky-100">
                </div>

                <div class="relative flex py-1 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-2 text-[10px] text-slate-400 uppercase font-bold">atau URL Gambar</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">URL Foto (Online Image)</label>
                    <input type="url" name="image_url" value="{{ old('image_url') }}" placeholder="https://..." class="w-full px-4 py-2 border rounded-xl text-xs focus:outline-none focus:border-sky-500">
                </div>
            </div>

            <!-- Actions -->
            <div class="p-6 rounded-2xl bg-slate-900 text-white space-y-3">
                <button type="submit" class="w-full py-3 rounded-xl text-xs font-bold bg-sky-500 hover:bg-sky-400 transition text-white shadow-md shadow-sky-500/20">
                    Simpan Spesimen Cupang
                </button>
                <a href="{{ route('admin.products.index') }}" class="block text-center text-xs text-slate-400 hover:text-white py-1 transition">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
