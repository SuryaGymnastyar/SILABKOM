@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-4" x-data="{ search: '' }">
    <!-- Header & Search Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Peminjaman Ruangan</h1>
        
        <!-- Search Box -->
        <div class="relative w-full sm:w-64">
            <input 
                type="text" 
                x-model="search" 
                placeholder="Cari mahasiswa atau ruangan..." 
                class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent shadow-sm"
            >
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase text-xs">
                <tr>
                    <th class="p-3">Mahasiswa</th>
                    <th class="p-3">Ruangan</th>
                    <th class="p-3">Tanggal Pengajuan</th>
                    <th class="p-3">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($bookings as $booking)
                    @php
                        $userName = strtolower($booking->user->name ?? $booking->user_id ?? '');
                        $roomName = strtolower($booking->room->name ?? $booking->room_id ?? '');
                        $status = strtolower($booking->status ?? '');
                    @endphp
                    <tr 
                        x-show="search === '' || '{{ $userName }}'.includes(search.toLowerCase()) || '{{ $roomName }}'.includes(search.toLowerCase())"
                    >
                        <td class="p-3 font-medium text-slate-800">{{ $booking->user->name ?? $booking->user_id }}</td>
                        <td class="p-3">{{ $booking->room->name ?? $booking->room_id }}</td>
                        <td class="p-3 text-xs text-slate-500">{{ $booking->created_at ? $booking->created_at->format('d M Y, H:i') : '-' }}</td>
                        <td class="p-3">
                            @if($status === 'approved' || $status === 'disetujui')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Disetujui</span>
                            @elseif($status === 'rejected' || $status === 'ditolak')
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold">Ditolak</span>
                            @else
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <!-- Empty State saat riwayat peminjaman kosong -->
                    <tr>
                        <td colspan="4" class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-12 h-12 mb-3 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                <p class="text-base font-semibold text-slate-600">Belum Ada Riwayat Peminjaman</p>
                                <p class="text-xs text-slate-400 mt-1">Semua data peminjaman yang telah disetujui atau ditolak akan muncul di sini.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection