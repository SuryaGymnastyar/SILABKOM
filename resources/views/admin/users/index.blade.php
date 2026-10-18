@extends('layouts.app')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-4">
    <!-- Header & Search Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Pengguna</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola data dan hak akses pengguna sistem SILABKOM.</p>
        </div>
        
        <!-- Search Box -->
        <div class="relative w-full sm:w-64">
            <input 
                type="text" 
                id="searchUserInput" 
                onkeyup="filterUserTable()" 
                placeholder="Cari nama atau email..." 
                class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"
            >
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-100 text-emerald-800 rounded-lg text-xs font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-3 bg-rose-100 text-rose-800 rounded-lg text-xs font-medium">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Pengguna -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase text-xs">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody id="userTableBody" class="divide-y divide-slate-100">
                @forelse($users as $user)
                    @php
                        $uName = strtolower($user->name ?? '');
                        $uEmail = strtolower($user->email ?? '');
                    @endphp
                    <tr class="user-row" data-text="{{ $uName }} {{ $uEmail }}">
                        <td class="p-3 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="p-3 text-slate-500">{{ $user->email }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-slate-100 text-slate-600' }}">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td class="p-3 text-right space-x-2">
                            @if($user->role !== 'admin')
                                <button 
                                    onclick="openPromoteModal('{{ $user->name }}', '{{ route('admin.users.promote', $user->id) }}')" 
                                    type="button"
                                    class="px-3 py-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-md text-xs font-semibold transition"
                                >
                                    Jadikan Admin
                                </button>
                                
                                <button 
                                    onclick="openDeleteModal('{{ $user->name }}', '{{ route('admin.users.destroy', $user->id) }}')" 
                                    type="button"
                                    class="px-3 py-1 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-md text-xs font-semibold transition cursor-pointer"
                                >
                                    Hapus
                                </button>
                            @else
                                <span class="text-xs font-medium text-slate-400 italic pr-2">Utama</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400 text-xs">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Konfirmasi Admin -->
    <div id="promoteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 max-w-sm w-full mx-4 space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hak Akses</h3>
            <p class="text-xs text-slate-600">Apakah Anda yakin ingin menjadikan <strong id="promoteUserName" class="text-indigo-600"></strong> sebagai Admin?</p>
            <div class="flex justify-end gap-2 pt-2">
                <button onclick="closePromoteModal()" type="button" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200">Batal</button>
                <form id="promoteForm" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-700">Iya, Jadikan Admin</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div id="deleteModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 max-w-sm w-full mx-4 space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hapus</h3>
            <p class="text-xs text-slate-600">Apakah Anda yakin ingin menghapus pengguna <strong id="deleteUserName" class="text-rose-600"></strong>?</p>
            <div class="flex justify-end gap-2 pt-2">
                <button onclick="closeDeleteModal()" type="button" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200">Batal</button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-semibold hover:bg-rose-700">Iya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function filterUserTable() {
        let input = document.getElementById('searchUserInput').value.toLowerCase();
        let rows = document.getElementsByClassName('user-row');

        for (let i = 0; i < rows.length; i++) {
            let row = rows[i];
            let text = row.getAttribute('data-text');
            if (text.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }

    function openPromoteModal(name, url) {
        document.getElementById('promoteUserName').innerText = name;
        document.getElementById('promoteForm').action = url;
        document.getElementById('promoteModal').classList.remove('hidden');
    }
    function closePromoteModal() { document.getElementById('promoteModal').classList.add('hidden'); }
    function openDeleteModal(name, url) {
        document.getElementById('deleteUserName').innerText = name;
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    function closeDeleteModal() { document.getElementById('deleteModal').classList.add('hidden'); }
</script>
@endsection