@extends('layouts.app')
@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="space-y-6">

    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-600 to-violet-600 rounded-3xl p-8 text-white shadow-lg flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="space-y-2 z-10">
            <h1 class="text-3xl font-extrabold tracking-tight">Selamat Datang Kembali, Mahasiswa! 👋</h1>
            <p class="text-indigo-100 text-sm max-w-xl leading-relaxed">
                Pantau status pengajuan peminjaman laboratorium dan ajukan jadwal pemeliharaan fasilitas dengan cepat dan mudah di SILABKOM.
            </p>
        </div>
        <div class="flex items-center gap-3 z-10 flex-shrink-0">
            <a href="{{ url('/mahasiswa/booking/create') }}" class="px-5 py-2.5 bg-white text-indigo-600 font-semibold text-sm rounded-xl shadow-sm hover:bg-indigo-50 transition-all">
                + Pinjam Lab
            </a>
            <a href="{{ url('/mahasiswa/booking') }}" class="px-5 py-2.5 bg-indigo-700/60 text-white font-semibold text-sm rounded-xl border border-indigo-400/30 hover:bg-indigo-700 transition-all">
                Riwayat Saya
            </a>
        </div>
        <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>

    @php
        $listBookings = $recentBookings ?? $bookings ?? \App\Models\RoomBooking::where('user_id', auth()->id())->latest()->get();
        
        $pTotal = $totalCount ?? $listBookings->count();
        $pPending = $pendingCount ?? $listBookings->whereIn('status', ['Menunggu', 'Pending'])->count();
        $pApproved = $approvedCount ?? $listBookings->where('status', 'Disetujui')->count();
        $pRejected = $rejectedCount ?? $listBookings->whereIn('status', ['Ditolak', 'Rejected'])->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:border-indigo-300 transition">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pengajuan</p>
                <h3 class="text-3xl font-extrabold text-indigo-600 mt-2">{{ $pTotal }}</h3>
            </div>
            <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:border-amber-300 transition">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Menunggu</p>
                <h3 class="text-3xl font-extrabold text-amber-500 mt-2">{{ $pPending }}</h3>
            </div>
            <div class="p-3 bg-amber-50 rounded-xl text-amber-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:border-emerald-300 transition">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Disetujui</p>
                <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $pApproved }}</h3>
            </div>
            <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between hover:border-rose-300 transition">
            <div>
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Ditolak</p>
                <h3 class="text-3xl font-extrabold text-rose-500 mt-2">{{ $pRejected }}</h3>
            </div>
            <div class="p-3 bg-rose-50 rounded-xl text-rose-600">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
            <h2 class="text-base font-bold text-slate-800">Riwayat Peminjaman Terakhir</h2>
            <a href="{{ url('/mahasiswa/booking') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 transition">Lihat Semua &rarr;</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200/80">
                        <th class="p-4">Lab</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Keperluan</th>
                        <th class="p-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($listBookings as $booking)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4 font-semibold text-slate-800">
                            {{ $booking->room->name ?? $booking->lab->name ?? 'Lab Komputer' }}
                        </td>
                        <td class="p-4 text-slate-600">{{ $booking->date ?? $booking->created_at->format('Y-m-d') ?? '-' }}</td>
                        <td class="p-4 text-slate-600">{{ $booking->purpose ?? $booking->keperluan ?? '-' }}</td>
                        <td class="p-4 text-center">
                            @if($booking->status == 'Menunggu' || $booking->status == 'Pending')
                                <span class="inline-flex items-center px-2.5 py-1 bg-amber-50 text-amber-700 rounded-md font-medium text-xs border border-amber-200/60">Menunggu</span>
                            @elseif($booking->status == 'Disetujui')
                                <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md font-medium text-xs border border-emerald-200/60">Disetujui</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 bg-rose-50 text-rose-700 rounded-md font-medium text-xs border border-rose-200/60">{{ $booking->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-400">Belum ada riwayat peminjaman lab.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection