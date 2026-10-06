@extends('layouts.app')

@section('content')
<div class="py-16 sm:py-24 bg-gradient-to-b from-sky-50 to-slate-100 flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white p-8 rounded-2xl shadow-xl border border-slate-200/80">
        <div class="text-center mb-8">
            <div class="w-12 h-12 rounded-xl bg-sky-600 flex items-center justify-center text-white mx-auto mb-3 shadow-md shadow-sky-500/30">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Selamat Datang Kembali</h2>
            <p class="text-xs text-slate-500 mt-1">Masuk ke akun Anda untuk belanja ikan cupang pilihan dan memantau pesanan.</p>
        </div>

        @if($errors->any())
            <div class="p-3 mb-5 text-xs text-rose-700 bg-rose-50 rounded-xl border border-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
            @csrf
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    placeholder="nama@email.com"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password</label>
                <input id="password" type="password" name="password" required
                    placeholder="••••••••"
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:outline-hidden focus:ring-2 focus:ring-sky-500 focus:border-sky-500 transition">
            </div>

            <div class="flex items-center justify-between text-xs pt-1">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember" class="rounded text-sky-600 focus:ring-sky-500 border-slate-300">
                    <span>Ingat Saya</span>
                </label>
                <span class="text-sky-600 font-semibold cursor-pointer hover:underline">Lupa Password?</span>
            </div>

            <button type="submit" class="w-full btn-primary justify-center py-3 text-sm mt-2">
                <span>Masuk Akun</span>
            </button>
        </form>

        <div class="mt-6 pt-6 border-t border-slate-100 text-center text-xs text-slate-500">
            <span>Belum memiliki akun?</span>
            <a href="{{ route('register') }}" class="font-bold text-sky-600 hover:text-sky-700 ml-1">Daftar sekarang</a>
        </div>

        <div class="mt-6 p-3 bg-slate-50 rounded-xl text-[11px] text-slate-500 text-center border border-slate-200/60">
            <strong>Info Akun Uji Coba:</strong><br>
            Super Admin: <code class="text-sky-700">admin@pamulangfish.com</code> / <code class="text-sky-700">password</code><br>
            Customer: <code class="text-sky-700">customer@pamulangfish.com</code> / <code class="text-sky-700">password</code>
        </div>
    </div>
</div>
@endsection
