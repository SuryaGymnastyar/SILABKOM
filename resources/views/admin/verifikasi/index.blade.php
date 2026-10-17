@extends('layouts.app')
@section('title', 'Verifikasi & Riwayat Peminjaman')

@section('content')
<div class="space-y-4">
    <h1 class="text-2xl font-bold text-slate-800">Peminjaman & Verifikasi</h1>

    @if(session('success'))
        <div class="p-3 bg-emerald-100 text-emerald-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase text-xs">
                <tr>
                    <th class="p-3">Mahasiswa</th>
                    <th class="p-3">Ruangan</th>
                    <th class="p-3">Status</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($bookings as $booking)
                    <tr>
                        <td class="p-3 font-medium text-slate-800">{{ $booking->user->name ?? '-' }}</td>
                        <td class="p-3">{{ $booking->room->name ?? '-' }}</td>
                        <td class="p-3">
                            <span class="px-2.5 py-1 text-xs rounded-full font-medium
                                @if($booking->status == 'Menunggu') bg-amber-100 text-amber-700
                                @elseif($booking->status == 'Disetujui') bg-emerald-100 text-emerald-700
                                @else bg-rose-100 text-rose-700 @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="p-3 text-right space-x-1">
                            @if($booking->status == 'Menunggu')
                                <form action="{{ route('admin.verifikasi.approve', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-emerald-600 text-white rounded-md text-xs hover:bg-emerald-700">Setujui</button>
                                </form>
                                <form action="{{ route('admin.verifikasi.reject', $booking->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-rose-600 text-white rounded-md text-xs hover:bg-rose-700">Tolak</button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400">Selesai</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-slate-400">Tidak ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection