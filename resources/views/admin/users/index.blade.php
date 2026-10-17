@extends('layouts.app')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-4" x-data="{ search: '' }">
    <!-- Header & Search Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Kelola Pengguna</h1>
        
        <!-- Search Box -->
        <div class="relative w-full sm:w-64">
            <input 
                type="text" 
                x-model="search" 
                placeholder="Cari nama atau email..." 
                class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm"
            >
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-100 text-emerald-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

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
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr 
                        x-show="search === '' || '{{ strtolower($user->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($user->email) }}'.includes(search.toLowerCase())"
                    >
                        <td class="p-3 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3 uppercase text-xs font-semibold text-slate-500">{{ $user->role }}</td>
                        <td class="p-3 text-right">
                            @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.promote', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-md text-xs font-semibold transition">
                                        Jadikan Admin
                                    </button>
                                </form>
                            @else
                                <span class="text-xs font-medium text-slate-400 italic">Utama</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <!-- Empty State saat tidak ada data sama sekali -->
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <p class="text-base font-semibold text-slate-600">Belum Ada Pengguna</p>
                                <p class="text-xs text-slate-400 mt-1">Sistem belum memiliki data pengguna terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection