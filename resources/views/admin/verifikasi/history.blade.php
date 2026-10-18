@extends('layouts.app')
@section('title', 'Riwayat Peminjaman')

@section('content')
<div class="space-y-4">
    <!-- Header, Filter & Search Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Peminjaman Ruangan</h1>
            <p class="text-xs text-slate-500 mt-1">Kelola dan pantau seluruh riwayat pengajuan peminjaman laboratorium.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <!-- Filter Dropdown Status -->
            <select id="filterStatus" onchange="filterHistoryTable()" class="bg-white border border-slate-200 rounded-lg text-xs py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
                <option value="all">Semua Status</option>
                <option value="menunggu">Menunggu</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
            </select>

            <!-- Search Box -->
            <div class="relative w-full sm:w-64">
                <input 
                    type="text" 
                    id="searchHistoryInput" 
                    onkeyup="filterHistoryTable()" 
                    placeholder="Cari mahasiswa atau ruangan..." 
                    class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
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
            <tbody id="historyTableBody" class="divide-y divide-slate-100">
                @forelse($bookings as $booking)
                    @php
                        $userName = strtolower($booking->user->name ?? $booking->user_id ?? '');
                        $roomName = strtolower($booking->room->name ?? $booking->room_id ?? '');
                        $statusRaw = strtolower($booking->status ?? 'menunggu');
                        $normStatus = ($statusRaw === 'approved' || $statusRaw === 'disetujui') ? 'disetujui' : (($statusRaw === 'rejected' || $statusRaw === 'ditolak') ? 'ditolak' : 'menunggu');
                    @endphp
                    <tr class="history-row" data-status="{{ $normStatus }}" data-text="{{ $userName }} {{ $roomName }}">
                        <td class="p-3 font-medium text-slate-800">{{ $booking->user->name ?? $booking->user_id }}</td>
                        <td class="p-3">{{ $booking->room->name ?? $booking->room_id }}</td>
                        <td class="p-3 text-xs text-slate-500">{{ $booking->created_at ? $booking->created_at->format('d M Y, H:i') : '-' }}</td>
                        <td class="p-3">
                            @if($normStatus === 'disetujui')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Disetujui</span>
                            @elseif($normStatus === 'ditolak')
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold">Ditolak</span>
                            @else
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-12 text-center text-slate-400 text-xs">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function filterHistoryTable() {
        let input = document.getElementById('searchHistoryInput').value.toLowerCase();
        let filter = document.getElementById('filterStatus').value;
        let rows = document.getElementsByClassName('history-row');

        for (let i = 0; i < rows.length; i++) {
            let row = rows[i];
            let status = row.getAttribute('data-status');
            let text = row.getAttribute('data-text');

            let matchesSearch = text.includes(input);
            let matchesStatus = (filter === 'all' || status === filter);

            if (matchesSearch && matchesStatus) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        }
    }
</script>
@endsection