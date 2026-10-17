<header class="bg-indigo-600 text-white sticky top-0 z-30 shadow-sm w-full">
    <div class="w-full px-6 h-16 flex items-center justify-between">
        {{-- Logo & SILABKOM --}}
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 font-bold text-lg tracking-wide hover:opacity-90 transition">
            <i data-lucide="monitor" class="w-6 h-6"></i>
            <span>SILABKOM</span>
        </a>

        {{-- Profil & Logout --}}
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-full bg-indigo-800 flex items-center justify-center font-semibold text-xs text-white">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="hidden sm:block text-left">
                    <div class="text-sm font-medium leading-none">{{ Auth::user()->name }}</div>
                    <span class="inline-block mt-1 px-1.5 py-0.5 text-[10px] font-semibold tracking-wider uppercase bg-indigo-500 rounded text-indigo-100">
                        {{ Auth::user()->role }}
                    </span>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="POST" class="inline m-0">
                @csrf
                <button type="submit" title="Keluar" class="p-2 rounded-lg bg-indigo-700/50 hover:bg-rose-600 text-white transition flex items-center justify-center">
                    <i data-lucide="log-out" class="w-4 h-4"></i>
                </button>
            </form>
        </div>
    </div>
</header>