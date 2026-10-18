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
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                NPM <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="npm" value="{{ old('npm') }}" required autofocus
                   inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   placeholder="Contoh: 2117051000"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('npm') border-rose-500 @enderror">
            @error('npm')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                Nama Lengkap <span class="text-rose-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   placeholder="Masukkan nama lengkap Anda"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('name') border-rose-500 @enderror">
            @error('name')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                Alamat Email <span class="text-rose-500">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   placeholder="nama@students.unila.ac.id"
                   class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-rose-500 @enderror">
            @error('email')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                Kata Sandi <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <input type="password" id="password" name="password" required
                       placeholder="Minimal 8 karakter"
                       class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('password') border-rose-500 @enderror">
                <button type="button" onclick="togglePasswordVisibility('password', 'icon-pass')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <i id="icon-pass" data-lucide="eye" class="w-4 h-4"></i>
                </button>
            </div>
            @error('password')
                <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">
                Ulangi Kata Sandi <span class="text-rose-500">*</span>
            </label>
            <div class="relative">
                <input type="password" id="password_confirmation" name="password_confirmation" required
                       placeholder="Konfirmasi kata sandi Anda"
                       class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-slate-300 rounded-lg text-sm text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', 'icon-confirm')"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                    <i id="icon-confirm" data-lucide="eye" class="w-4 h-4"></i>
                </button>
            </div>
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

<script>
    function togglePasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
        }

        if (window.lucide) {
            lucide.createIcons();
        }
    }
</script>
@endsection