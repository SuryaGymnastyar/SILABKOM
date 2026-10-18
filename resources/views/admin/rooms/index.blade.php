@extends('layouts.app')
@section('title', 'Kelola Ruangan Lab')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Ruangan Lab</h1>
            <p class="text-xs text-slate-500 mt-1">Tambah, ubah, dan atur daftar laboratorium yang tersedia.</p>
        </div>
        
        <a href="{{ route('admin.rooms.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition shadow-sm">
            + Tambah Lab
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($rooms as $room)
            @php
                $cond = $room->condition ?? 'Baik';
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md transition flex flex-col justify-between overflow-hidden">
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold
                            {{ $cond === 'Baik' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200/60' : 'bg-amber-50 text-amber-700 border border-amber-200/60' }}">
                            {{ $cond }}
                        </span>
                    </div>

                    <div>
                        <h3 class="text-lg font-bold text-slate-800">{{ $room->name }}</h3>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>{{ $room->location ?? '-' }}</span>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-slate-500 mt-1">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <span>Kapasitas {{ $room->capacity ?? 0 }} orang</span>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Fasilitas</p>
                        <p class="text-xs text-slate-600 leading-relaxed line-clamp-3">
                            {{ $room->facilities ?? $room->facility ?? '-' }}
                        </p>
                    </div>
                </div>

                <div class="p-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between gap-3">
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="flex-1 py-2 text-center bg-amber-50 text-amber-600 border border-amber-200 rounded-xl text-xs font-semibold hover:bg-amber-100 transition">
                        Edit
                    </a>
                    
                    <button 
                        onclick="openDeleteRoomModal('{{ $room->name }}', '{{ route('admin.rooms.destroy', $room->id) }}')" 
                        type="button" 
                        class="flex-1 py-2 text-center bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-xs font-semibold hover:bg-rose-100 transition cursor-pointer"
                    >
                        Hapus
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white p-12 rounded-2xl border border-slate-200/80 text-center text-slate-400 text-xs">
                Belum ada data ruangan lab.
            </div>
        @endforelse
    </div>

    <div id="deleteRoomModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 max-w-sm w-full mx-4 space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Konfirmasi Hapus Lab</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Apakah Anda yakin ingin menghapus laboratorium <strong id="deleteRoomName" class="text-rose-600 font-semibold"></strong>?
            </p>
            <div class="flex justify-end gap-2 pt-2">
                <button onclick="closeDeleteRoomModal()" type="button" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">Batal</button>
                <form id="deleteRoomForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-semibold hover:bg-rose-700 transition">Iya, Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openDeleteRoomModal(name, actionUrl) {
        document.getElementById('deleteRoomName').innerText = name;
        document.getElementById('deleteRoomForm').action = actionUrl;
        document.getElementById('deleteRoomModal').classList.remove('hidden');
    }
    function closeDeleteRoomModal() {
        document.getElementById('deleteRoomModal').classList.add('hidden');
    }
</script>
@endsection