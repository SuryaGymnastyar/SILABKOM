<aside class="w-64 bg-white border-r border-slate-200 hidden md:block flex-shrink-0 min-h-[calc(100vh-4rem)] p-4">
    <nav class="space-y-1">
        <a href="{{ route('dashboard') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
            <span>Dashboard</span>
        </a>

        @if(Auth::user()->role === 'mahasiswa')
            <div class="pt-4 pb-1 px-3 text-[11px] font-semibold text-slate-400 tracking-wider uppercase">Mahasiswa</div>
            <a href="{{ route('mahasiswa.katalog') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('mahasiswa.katalog') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="grid" class="w-4 h-4"></i>
                <span>Katalog Lab</span>
            </a>
            <a href="{{ route('mahasiswa.booking.create') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('mahasiswa.booking.create') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="calendar-plus" class="w-4 h-4"></i>
                <span>Ajukan Pinjam</span>
            </a>
            <a href="{{ route('mahasiswa.booking.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('mahasiswa.booking.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="history" class="w-4 h-4"></i>
                <span>Riwayat Saya</span>
            </a>
        @endif

        @if(Auth::user()->role === 'admin')
            <div class="pt-4 pb-1 px-3 text-[11px] font-semibold text-slate-400 tracking-wider uppercase">Laboran / Admin</div>
            <a href="{{ route('admin.rooms.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.rooms.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="door-open" class="w-4 h-4"></i>
                <span>Kelola Lab</span>
            </a>
            <a href="{{ route('admin.verifikasi.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.verifikasi.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="check-square" class="w-4 h-4"></i>
                <span>Verifikasi Pinjam</span>
            </a>
            
            <a href="{{ route('admin.verifikasi.history') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.verifikasi.history') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="clipboard-list" class="w-4 h-4"></i>
                <span>Riwayat Peminjaman</span>
            </a>

            <a href="{{ route('admin.users.index') }}" 
               class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                <i data-lucide="users" class="w-4 h-4"></i>
                <span>Kelola Pengguna</span>
            </a>
        @endif

        <div class="pt-4 pb-1 px-3 text-[11px] font-semibold text-slate-400 tracking-wider uppercase">Akun</div>
        <a href="{{ route('profile.index') }}" 
           class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('profile.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
            <i data-lucide="user-cog" class="w-4 h-4"></i>
            <span>Profil Saya</span>
        </a>
    </nav>
</aside>