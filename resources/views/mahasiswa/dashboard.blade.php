@extends('layouts.app')
@section('title', 'Dashboard Mahasiswa')
@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard Mahasiswa</h1>
            <div class="p-4 bg-indigo-50 text-indigo-800 rounded-xl border border-indigo-200 text-sm mt-2">
                Selamat datang di SILABKOM!
            </div>
        </div>
        <!-- Disesuaikan dengan route asli buatan temanmu: mahasiswa.booking.create -->
        <a href="{{ route('mahasiswa.booking.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">+ Pinjam Lab</a>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500 font-medium">Menunggu Verifikasi</p>
            <h3 class="text-3xl font-bold text-amber-600 mt-2">{{ $myPendingCount ?? 0 }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500 font-medium">Peminjaman Disetujui</p>
            <h3 class="text-3xl font-bold text-emerald-600 mt-2">{{ $myApprovedCount ?? 0 }}</h3>
        </div>
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500 font-medium">Peminjaman Ditolak</p>
            <h3 class="text-3xl font-bold text-rose-600 mt-2">{{ $myRejectedCount ?? 0 }}</h3>
        </div>
    </div>

    <!-- Riwayat Terbaru -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-4 border-b border-slate-200 font-semibold text-slate-800">Riwayat Peminjaman Terakhir</div>
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-semibold">
                <tr>
                    <th class="p-4">Lab</th>
                    <th class="p-4">Tanggal</th>
                    <th class="p-4">Keperluan</th>
                    <th class="p-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm text-slate-600">
                @forelse($myRecentBookings ?? [] as $booking)
                <tr>
                    <td class="p-4 font-medium text-slate-800">{{ $booking->room->name ?? 'Lab' }}</td>
                    <td class="p-4">{{ $booking->booking_date ?? '-' }}</td>
                    <td class="p-4">{{ $booking->purpose ?? '-' }}</td>
                    <td class="p-4">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold
                            @if($booking->status == 'Disetujui') bg-emerald-100 text-emerald-700
                            @elseif($booking->status == 'Ditolak') bg-rose-100 text-rose-700
                            @else bg-amber-100 text-amber-700 @endif">
                            {{ $booking->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-slate-400">Belum ada riwayat peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection