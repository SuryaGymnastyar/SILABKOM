@extends('layouts.app')
@section('title', 'Verifikasi Pinjam')

@section('content')
<div class="space-y-4">
    <!-- Header Page -->
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Verifikasi Pinjam</h1>
        <p class="text-xs text-slate-500 mt-1">Verifikasi pengajuan peminjaman laboratorium dari mahasiswa.</p>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-100 text-emerald-800 rounded-lg text-xs font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Verifikasi -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-200 text-slate-700 text-xs uppercase font-semibold">
                <tr>
                    <th class="p-3.5">Mahasiswa</th>
                    <th class="p-3.5">Ruangan</th>
                    <th class="p-3.5">Tanggal / Waktu</th>
                    <th class="p-3.5">Keperluan</th>
                    <th class="p-3.5">Status</th>
                    <th class="p-3.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm text-slate-600">
                @forelse($bookings as $booking)
                    @php
                        $st = strtolower($booking->status ?? 'menunggu');
                        $uName = $booking->user->name ?? '-';
                        $rName = $booking->room->name ?? $booking->lab->name ?? '-';
                    @endphp
                    <tr class="hover:bg-slate-50 transition">
                        <td class="p-3.5 font-medium text-slate-800">{{ $uName }}</td>
                        <td class="p-3.5">{{ $rName }}</td>
                        <td class="p-3.5">
                            <span class="font-medium text-slate-700">{{ $booking->date ?? ($booking->booking_date ? date('d-m-Y', strtotime($booking->booking_date)) : '-') }}</span>
                            <br>
                            <span class="text-xs text-slate-400">{{ substr($booking->start_time ?? '', 0, 5) }} - {{ substr($booking->end_time ?? '', 0, 5) }}</span>
                        </td>
                        <td class="p-3.5 text-xs text-slate-600 max-w-xs truncate">{{ $booking->purpose ?? $booking->keperluan ?? '-' }}</td>
                        <td class="p-3.5">
                            @if($st === 'disetujui' || $st === 'approved')
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Disetujui</span>
                            @elseif($st === 'ditolak' || $st === 'rejected')
                                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold">Ditolak</span>
                            @else
                                <span class="px-2.5 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Menunggu</span>
                            @endif
                        </td>
                        <td class="p-3.5 text-center">
                            @if($st === 'menunggu' || $st === 'pending')
                                <div class="flex items-center justify-center gap-2">
                                    <button 
                                        onclick="openApproveModal('{{ $uName }}', '{{ $rName }}', '{{ route('admin.verifikasi.approve', $booking->id) }}')" 
                                        type="button" 
                                        class="px-3 py-1.5 bg-emerald-600 text-white rounded-lg text-xs font-semibold hover:bg-emerald-700 transition shadow-sm cursor-pointer"
                                    >
                                        Setujui
                                    </button>

                                    <button 
                                        onclick="openRejectModal('{{ $uName }}', '{{ $rName }}', '{{ route('admin.verifikasi.reject', $booking->id) }}')" 
                                        type="button" 
                                        class="px-3 py-1.5 bg-rose-600 text-white rounded-lg text-xs font-semibold hover:bg-rose-700 transition shadow-sm cursor-pointer"
                                    >
                                        Tolak
                                    </button>
                                </div>
                            @else
                                <span class="text-xs text-slate-400 italic font-medium">Selesai diproses</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-12 text-center text-slate-400 text-xs">Tidak ada peminjaman menunggu verifikasi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Konfirmasi Setujui (Vanilla JS) -->
    <div id="approveModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 max-w-sm w-full mx-4 space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Setujui Peminjaman</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Apakah Anda yakin ingin menyetujui peminjaman lab <strong id="approveRoomName" class="text-emerald-600 font-semibold"></strong> oleh <strong id="approveUserName" class="text-slate-800 font-semibold"></strong>?
            </p>
            <div class="flex justify-end gap-2 pt-2">
                <button onclick="closeApproveModal()" type="button" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">Batal</button>
                <form id="approveForm" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-xl text-xs font-semibold hover:bg-emerald-700 transition">Ya, Setujui</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Tolak (Vanilla JS) -->
    <div id="rejectModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 max-w-sm w-full mx-4 space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Tolak Peminjaman</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Apakah Anda yakin ingin menolak peminjaman lab <strong id="rejectRoomName" class="text-rose-600 font-semibold"></strong> oleh <strong id="rejectUserName" class="text-slate-800 font-semibold"></strong>?
            </p>
            <div class="flex justify-end gap-2 pt-2">
                <button onclick="closeRejectModal()" type="button" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">Batal</button>
                <form id="rejectForm" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-semibold hover:bg-rose-700 transition">Ya, Tolak</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openApproveModal(userName, roomName, actionUrl) {
        document.getElementById('approveUserName').innerText = userName;
        document.getElementById('approveRoomName').innerText = roomName;
        document.getElementById('approveForm').action = actionUrl;
        document.getElementById('approveModal').classList.remove('hidden');
    }

    function closeApproveModal() {
        document.getElementById('approveModal').classList.add('hidden');
    }

    function openRejectModal(userName, roomName, actionUrl) {
        document.getElementById('rejectUserName').innerText = userName;
        document.getElementById('rejectRoomName').innerText = roomName;
        document.getElementById('rejectForm').action = actionUrl;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
@endsection