@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Hero Banner Admin -->
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-6 sm:p-8 text-white shadow-md flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div class="space-y-1 z-10">
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight">Selamat Datang Kembali, Admin! 👋</h1>
            <p class="text-indigo-100 text-xs sm:text-sm max-w-xl leading-relaxed">
                Pantau dan kelola seluruh aktivitas peminjaman laboratorium SILABKOM di sini.
            </p>
        </div>
        <div class="flex items-center gap-3 z-10 flex-shrink-0">
            <a href="{{ route('admin.verifikasi.index') }}" class="px-5 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-xl text-xs font-semibold text-white transition-all">
                Cek Verifikasi
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="px-5 py-2.5 bg-white text-indigo-700 hover:bg-indigo-50 rounded-xl text-xs font-semibold transition-all shadow-sm">
                Kelola Lab
            </a>
        </div>
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    <!-- Card Statistik Admin (5 Card) -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Ruangan</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalRooms ?? 0 }}</p>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5"/></svg>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Mahasiswa</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalUsers ?? 0 }}</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-amber-600 uppercase tracking-wider">Menunggu</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $pendingCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-emerald-600 uppercase tracking-wider">Disetujui</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $approvedCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
        </div>

        <div class="p-4 bg-white rounded-2xl shadow-sm border border-slate-200/80 flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold text-rose-600 uppercase tracking-wider">Ditolak</p>
                <p class="text-2xl font-bold text-rose-600 mt-1">{{ $rejectedCount ?? 0 }}</p>
            </div>
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
        </div>
    </div>

    <!-- Tabel Pengajuan Peminjaman Terbaru Admin -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h2 class="text-base font-bold text-slate-800">Pengajuan Peminjaman Terbaru</h2>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/80 text-slate-500 uppercase text-xs font-semibold border-b border-slate-200/80">
                    <tr>
                        <th class="p-4">Mahasiswa</th>
                        <th class="p-4">Ruangan</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentBookings as $booking)
                        @php
                            $st = strtolower($booking->status ?? '');
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-4 font-medium text-slate-800">{{ $booking->user->name ?? '-' }}</td>
                            <td class="p-4">{{ $booking->room->name ?? '-' }}</td>
                            <td class="p-4 text-xs text-slate-500">{{ $booking->created_at ? $booking->created_at->format('d M Y, H:i') : '-' }}</td>
                            <td class="p-4">
                                @if($st === 'disetujui' || $st === 'approved')
                                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Disetujui</span>
                                @elseif($st === 'ditolak' || $st === 'rejected')
                                    <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold">Ditolak</span>
                                @else
                                    <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Menunggu</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400 text-xs">Belum ada peminjaman terbaru.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection