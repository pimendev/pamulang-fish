@extends('layouts.app')

@section('content')
<div class="py-16 sm:py-24 bg-gradient-to-b from-sky-50 to-slate-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border border-slate-200/80">
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-xl bg-sky-600 flex items-center justify-center text-white mx-auto mb-3 shadow-md shadow-sky-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Daftar Akun Baru</h2>
            <p class="text-xs text-slate-500 mt-1">Gabung bersama komunitas pecinta ikan cupang (Betta Fish) di Pamulang Fish Store.</p>
        </div>

        @if($errors->any())
            <div class="p-3 mb-5 text-xs text-rose-700 bg-rose-50 rounded-xl border border-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    placeholder="Budi Santoso"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
            </div>

            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    placeholder="nama@email.com"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
            </div>

            <div>
                <label for="phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nomor WhatsApp / HP</label>
                <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                    placeholder="08123456789"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                <input id="password" type="password" name="password" required
                    placeholder="Minimal 8 karakter"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
            </div>

            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Konfirmasi Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    placeholder="Ulangi password"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
            </div>

            <button type="submit" class="w-full btn-primary justify-center py-3 text-sm mt-2">
                <span>Daftar Akun</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
            <span>Sudah memiliki akun?</span>
            <a href="{{ route('login') }}" class="font-bold text-sky-600 hover:text-sky-700 ml-1">Masuk sekarang</a>
        </div>
    </div>
</div>
@endsection
