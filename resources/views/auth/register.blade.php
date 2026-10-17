@extends('layouts.guest')

@section('title', 'Daftar Akun - SILABKOM')

@section('content')
<div class="bg-white rounded-2xl shadow-xl border border-slate-200 p-8">
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl mb-3">
            <i data-lucide="user-plus" class="w-6 h-6"></i>
        </div>
        <h1 class="text-2xl font-bold text-slate-900">Buat Akun Mahasiswa</h1>
        <p class="text-xs text-slate-500 mt-1">Daftar untuk mengakses peminjaman laboratorium SILABKOM</p>
    </div>

    <form action="{{ route('register.action') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">NPM</label>
            <input type="text" name="npm" value="{{ old('npm') }}" required autofocus
                   placeholder="Contoh: 2117051000"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('npm')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   placeholder="Masukkan nama lengkap Anda"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('name')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Alamat Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   placeholder="nama@students.unila.ac.id"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('email')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kata Sandi</label>
            <input type="password" name="password" required
                   placeholder="Minimal 8 karakter"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('password')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Ulangi Kata Sandi</label>
            <input type="password" name="password_confirmation" required
                   placeholder="Konfirmasi kata sandi Anda"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
            Daftar Sekarang
        </button>

        <p class="text-center text-xs text-slate-500 mt-4">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-semibold">Masuk di sini</a>
        </p>
    </form>
</div>
@endsection