@extends('layouts.guest')

@section('title', 'Masuk - SILABKOM')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl mb-3">
            <i data-lucide="monitor" class="w-6 h-6"></i>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">SILABKOM</h1>
        <p class="text-xs text-slate-500 mt-1">Sistem Peminjaman Lab Ilmu Komputer FMIPA Unila</p>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-emerald-50 text-emerald-700 text-xs rounded-lg border border-emerald-200">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login.action') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">NPM atau Email</label>
            <input type="text" name="login" value="{{ old('login') }}" required autofocus
                   placeholder="Masukkan NPM atau Email"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('login')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kata Sandi</label>
            <input type="password" name="password" required
                   placeholder="••••••••"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div class="flex items-center justify-between text-xs">
            <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                <input type="checkbox" name="remember" class="rounded text-indigo-600 focus:ring-indigo-500">
                <span>Ingat Saya</span>
            </label>
        </div>

        <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
            Masuk ke Sistem
        </button>

        <p class="text-center text-xs text-slate-500 mt-4">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-semibold">Daftar Mahasiswa</a>
        </p>
    </form>
</div>
@endsection