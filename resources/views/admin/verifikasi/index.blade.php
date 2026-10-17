@extends('layouts.app')
@section('title', 'Verifikasi Peminjaman')
@section('content')
<div class="space-y-4">
    <h1 class="text-2xl font-bold text-slate-800">Verifikasi Peminjaman Lab</h1>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-800 rounded-xl border border-emerald-200 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 text-slate-700 text-xs uppercase font-semibold">
                <tr>
                    <th class="p-4">Peminjam</th>
                    <th class="p-4">Lab</th>
                    <th class="p-4">Tanggal / Waktu</th>
                    <th class="p-4">Keperluan</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm text-slate-600">
                @forelse($bookings as $booking)
                <tr>
                    <td class="p-4 font-medium text-slate-800">{{ $booking->user->name ?? 'User' }}</td>
                    <td class="p-4">{{ $booking->room->name ?? 'Lab' }}</td>
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
                    <td class="p-4 text-center space-x-1">
                        @if($booking->status == 'Menunggu')
                            <!-- Tombol Setujui sesuai route temanmu -->
                            <form action="{{ route('admin.verifikasi.approve', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1 bg-emerald-600 text-white rounded text-xs hover:bg-emerald-700">Setujui</button>
                            </form>
                            <!-- Tombol Tolak sesuai route temanmu -->
                            <form action="{{ route('admin.verifikasi.reject', $booking->id) }}" method="POST" class="inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="px-3 py-1 bg-rose-600 text-white rounded text-xs hover:bg-rose-700">Tolak</button>
                            </form>
                        @else
                            <span class="text-xs text-slate-400 font-medium">Selesai Diverifikasi</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-slate-400">Belum ada pengajuan peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection