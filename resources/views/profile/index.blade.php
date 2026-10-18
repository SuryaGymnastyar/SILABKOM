@extends('layouts.app')

@section('title', 'Profil Akun')

@section('content')
<div class="space-y-6">
    <!-- Header Halaman -->
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Pengaturan Akun</h1>
        <p class="text-sm text-slate-500">Kelola informasi data diri dan keamanan kata sandi Anda.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        <!-- Edit Informasi Profil -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-800 mb-5 flex items-center gap-2">
                    <i data-lucide="user" class="w-5 h-5 text-indigo-600"></i>
                    Informasi Pengguna
                </h2>

                <form id="form-profile" action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">NPM / Identitas</label>
                        <input type="text" value="{{ $user->npm }}" disabled
                               class="w-full px-3.5 py-2.5 bg-slate-100 border border-slate-200 rounded-lg text-slate-500 text-sm cursor-not-allowed">
                        <p class="text-[11px] text-slate-400 mt-1">NPM tidak dapat diubah secara mandiri.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        @error('email')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </form>
            </div>

            <div class="pt-6 text-right">
                <button type="submit" form="form-profile" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                    Simpan Perubahan
                </button>
            </div>
        </div>

        <!-- Ganti Password -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 flex flex-col justify-between">
            <div>
                <h2 class="text-lg font-semibold text-slate-800 mb-5 flex items-center gap-2">
                    <i data-lucide="key" class="w-5 h-5 text-indigo-600"></i>
                    Keamanan Kata Sandi
                </h2>

                <form id="form-password" action="{{ route('profile.password') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input type="password" id="current_password" name="current_password" required placeholder="Masukkan kata sandi saat ini"
                                   class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('current_password') border-rose-500 @enderror">
                            <button type="button" onclick="togglePasswordVisibility('current_password', 'icon-current')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i id="icon-current" data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password" name="password" required placeholder="Minimal 8 karakter"
                                   class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-rose-500 @enderror">
                            <button type="button" onclick="togglePasswordVisibility('new_password', 'icon-new')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i id="icon-new" data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Ulangi Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" id="new_password_confirmation" name="password_confirmation" required placeholder="Konfirmasi kata sandi baru"
                                   class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-800 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="button" onclick="togglePasswordVisibility('new_password_confirmation', 'icon-confirm')"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-slate-600 focus:outline-none">
                                <i id="icon-confirm" data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="pt-6 text-right">
                <button type="submit" form="form-password" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm rounded-lg shadow-sm transition">
                    Perbarui Password
                </button>
            </div>
        </div>
    </div>
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