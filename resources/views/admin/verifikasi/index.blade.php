@extends('layouts.app')
@section('title', 'Verifikasi & Riwayat Peminjaman')

@section('content')
<div class="space-y-4">
    <h1 class="text-2xl font-bold text-slate-800">Peminjaman & Verifikasi</h1>

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 text-xs uppercase font-semibold">
                <tr>
                    <th class="p-4">Mahasiswa</th>
                    <th class="p-4">Ruangan</th>
                    <th class="p-4">Tanggal / Waktu</th>
                    <th class="p-4">Keperluan</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm text-slate-600">
                @forelse($bookings as $booking)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-medium text-slate-900">{{ $booking->user->name ?? '-' }}</td>
                    <td class="p-4">{{ $booking->room->name ?? $booking->lab->name ?? '-' }}</td>
                    <td class="p-4">{{ $booking->date ?? '-' }} <br><span class="text-xs text-slate-400">{{ $booking->start_time ?? '' }} - {{ $booking->end_time ?? '' }}</span></td>
                    <td class="p-4">{{ $booking->purpose ?? $booking->keperluan ?? '-' }}</td>
                    <td class="p-4">
                        @if($booking->status == 'Menunggu' || $booking->status == 'Pending')
                            <span class="px-2.5 py-1 bg-amber-50 text-amber-700 rounded-md font-medium text-xs">Menunggu</span>
                        @elseif($booking->status == 'Disetujui')
                            <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md font-medium text-xs">Disetujui</span>
                        @else
                            <span class="px-2.5 py-1 bg-rose-50 text-rose-700 rounded-md font-medium text-xs">{{ $booking->status }}</span>
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        @if($booking->status == 'Menunggu' || $booking->status == 'Pending')
                            <div class="flex items-center justify-center space-x-2">
                                <form action="{{ route('admin.verifikasi.approve', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-medium hover:bg-emerald-700 transition">Setujui</button>
                                </form>
                                <form action="{{ route('admin.verifikasi.reject', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-xs font-medium hover:bg-rose-700 transition">Tolak</button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-slate-400 italic">Selesai diproses</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-slate-500">Tidak ada riwayat peminjaman.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection