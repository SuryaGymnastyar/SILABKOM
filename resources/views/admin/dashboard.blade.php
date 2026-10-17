@extends('layouts.app')
@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Welcome Banner -->
    <div class="p-6 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl text-white shadow-md flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold">Selamat Datang Kembali, Admin! 👋</h1>
            <p class="text-indigo-100 text-sm mt-1">Pantau dan kelola seluruh aktivitas peminjaman laboratorium SILABKOM di sini.</p>
        </div>
        <div class="hidden md:flex gap-2">
            <a href="{{ route('admin.verifikasi.index') }}" class="px-4 py-2 bg-white/20 hover:bg-white/30 backdrop-blur-md rounded-lg text-xs font-semibold transition">
                Cek Verifikasi
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 bg-white text-indigo-700 hover:bg-indigo-50 rounded-lg text-xs font-semibold transition shadow-sm">
                Kelola Lab
            </a>
        </div>
    </div>

    <!-- Grid Ringkasan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
        <!-- Total Ruangan -->
        <div class="p-4 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Total Ruangan</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalRooms }}</p>
            </div>
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl">
                <i data-lucide="door-open" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Total Mahasiswa -->
        <div class="p-4 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-slate-500">Total Mahasiswa</p>
                <p class="text-2xl font-bold text-slate-800 mt-1">{{ $totalUsers }}</p>
            </div>
            <div class="p-3 bg-blue-50 text-blue-600 rounded-xl">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="p-4 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-amber-600">Menunggu</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $pendingCount }}</p>
            </div>
            <div class="p-3 bg-amber-50 text-amber-600 rounded-xl">
                <i data-lucide="clock" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Disetujui -->
        <div class="p-4 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-emerald-600">Disetujui</p>
                <p class="text-2xl font-bold text-emerald-600 mt-1">{{ $approvedCount }}</p>
            </div>
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl">
                <i data-lucide="check-circle" class="w-6 h-6"></i>
            </div>
        </div>

        <!-- Ditolak -->
        <div class="p-4 bg-white rounded-xl shadow-sm border border-slate-200 flex items-center justify-between">
            <div>
                <p class="text-xs font-medium text-rose-600">Ditolak</p>
                <p class="text-2xl font-bold text-rose-600 mt-1">{{ $rejectedCount }}</p>
            </div>
            <div class="p-3 bg-rose-50 text-rose-600 rounded-xl">
                <i data-lucide="x-circle" class="w-6 h-6"></i>
            </div>
        </div>
    </div>

    <!-- Tabel Pengajuan Terbaru -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-slate-800">Pengajuan Peminjaman Terbaru</h2>
            <a href="{{ route('admin.verifikasi.index') }}" class="text-xs font-medium text-indigo-600 hover:text-indigo-700">Lihat Semua →</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 text-slate-700 uppercase text-xs">
                    <tr>
                        <th class="p-3">Mahasiswa</th>
                        <th class="p-3">Ruangan</th>
                        <th class="p-3">Tanggal</th>
                        <th class="p-3">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentBookings as $booking)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3 font-medium text-slate-800">{{ $booking->user->name ?? '-' }}</td>
                            <td class="p-3">{{ $booking->room->name ?? '-' }}</td>
                            <td class="p-3">{{ $booking->created_at->format('d M Y, H:i') }}</td>
                            <td class="p-3">
                                <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                    @if($booking->status == 'Menunggu') bg-amber-100 text-amber-700
                                    @elseif($booking->status == 'Disetujui') bg-emerald-100 text-emerald-700
                                    @else bg-rose-100 text-rose-700 @endif">
                                    {{ $booking->status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-8 text-center text-slate-400">
                                <div class="flex flex-col items-center gap-2">
                                    <i data-lucide="inbox" class="w-8 h-8 text-slate-300"></i>
                                    <span>Belum ada data peminjaman terbaru.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection