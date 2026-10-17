@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-4">
    <h1 class="text-2xl font-bold text-slate-800">Riwayat Peminjaman Ruangan</h1>

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
                    <tr>
                        <td class="p-3 font-medium text-slate-800">{{ $booking->user->name ?? '-' }}</td>
                        <td class="p-3">{{ $booking->room->name ?? '-' }}</td>
                        <td class="p-3">{{ $booking->created_at->format('d M Y, H:i') }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                @if($booking->status == 'Disetujui') bg-emerald-100 text-emerald-700
                                @else bg-rose-100 text-rose-700 @endif">
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