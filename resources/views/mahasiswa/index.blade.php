@extends('layouts.app')
@section('title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="space-y-6">
    <!-- Header Page & Action Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Peminjaman Saya</h1>
            <p class="text-xs text-slate-500 mt-1">Pantau status pengajuan dan lihat riwayat peminjaman laboratoriummu.</p>
        </div>
        
        <a href="{{ route('mahasiswa.booking.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-semibold hover:bg-indigo-700 transition shadow-sm">
            + Ajukan Peminjaman
        </a>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-100 text-emerald-800 rounded-xl text-xs font-medium">
            {{ session('success') }}
        </div>
    @endif

    <!-- Cards Ringkasan Statistik -->
    @php
        $totalAll = $bookings->count();
        $totalPending = $bookings->whereIn('status', ['Menunggu', 'Pending', 'menunggu', 'pending'])->count();
        $totalApproved = $bookings->whereIn('status', ['Disetujui', 'Approved', 'disetujui', 'approved'])->count();
        $totalRejected = $bookings->whereIn('status', ['Ditolak', 'Rejected', 'ditolak', 'rejected'])->count();
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card Total Pengajuan -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Pengajuan</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalAll }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>

        <!-- Card Menunggu -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Menunggu</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalPending }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card Disetujui -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Disetujui</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalApproved }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        <!-- Card Ditolak -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-bold text-rose-600 uppercase tracking-wider">Ditolak</p>
                <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ $totalRejected }}</h3>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Filter & Search Section -->
    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-6">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-base font-bold text-slate-800">Daftar Pengajuan</h3>
                <p class="text-xs text-slate-400 mt-0.5">Filter dan cari riwayat pengajuan peminjaman laboratorium.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                <!-- Dropdown Filter Status -->
                <select id="mhsFilterStatus" onchange="filterMhsBookingList()" class="bg-white border border-slate-200 rounded-xl text-xs py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm">
                    <option value="all">Semua Status</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>

                <!-- Search Input Box -->
                <div class="relative flex-1 sm:w-64">
                    <input 
                        type="text" 
                        id="mhsSearchInput" 
                        onkeyup="filterMhsBookingList()" 
                        placeholder="Cari lab atau tujuan..." 
                        class="w-full pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- List Card Pengajuan -->
        <div class="space-y-4">
            @forelse($bookings as $booking)
                @php
                    $stRaw = strtolower($booking->status ?? 'menunggu');
                    $normSt = ($stRaw === 'approved' || $stRaw === 'disetujui') ? 'disetujui' : (($stRaw === 'rejected' || $stRaw === 'ditolak') ? 'ditolak' : 'menunggu');
                    $rName = $booking->room->name ?? '-';
                    $purp = $booking->purpose ?? $booking->keperluan ?? '-';
                    $searchData = strtolower($rName . ' ' . $purp);
                @endphp

                <div class="mhs-booking-card p-5 rounded-2xl border border-slate-100 hover:border-slate-200 bg-slate-50/50 hover:bg-white transition space-y-4 shadow-2xs"
                     data-status="{{ $normSt }}" 
                     data-search="{{ $searchData }}">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">{{ $rName }}</h4>
                                <p class="text-xs text-slate-400 mt-0.5">{{ $booking->room->location ?? 'Lt 2' }}</p>
                            </div>
                        </div>

                        <!-- Status Badge -->
                        <div>
                            @if($normSt === 'disetujui')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-semibold">Disetujui</span>
                            @elseif($normSt === 'ditolak')
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-xs font-semibold">Ditolak</span>
                            @else
                                <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-xs font-semibold">Menunggu</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs text-slate-600">
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Tanggal & Waktu</span>
                            <div class="flex items-center gap-3 font-medium text-slate-700">
                                <span>{{ $booking->booking_date ? date('d-m-Y', strtotime($booking->booking_date)) : ($booking->date ?? '-') }}</span>
                                <span>{{ substr($booking->start_time ?? '', 0, 5) }} – {{ substr($booking->end_time ?? '', 0, 5) }} WIB</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Tujuan Peminjaman</span>
                            <p class="text-slate-600 font-normal leading-relaxed line-clamp-2">{{ $purp }}</p>
                        </div>
                    </div>

                    <!-- Tombol Aksi (Hanya jika status 'Menunggu') -->
                    @if($normSt === 'menunggu')
                        <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                            <a href="{{ route('mahasiswa.booking.edit', $booking->id) }}" class="px-3.5 py-1.5 bg-amber-50 text-amber-600 border border-amber-200 rounded-xl text-xs font-semibold hover:bg-amber-100 transition">
                                Edit
                            </a>

                            <button onclick="openCancelModal('{{ route('mahasiswa.booking.destroy', $booking->id) }}')" type="button" class="px-3.5 py-1.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-xl text-xs font-semibold hover:bg-rose-100 transition cursor-pointer">
                                Batalkan
                            </button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-12 text-center text-slate-400 text-xs">
                    Belum ada riwayat pengajuan peminjaman laboratorium.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Konfirmasi Batalkan Peminjaman -->
    <div id="cancelBookingModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 max-w-sm w-full mx-4 space-y-4">
            <h3 class="text-lg font-bold text-slate-800">Batalkan Peminjaman</h3>
            <p class="text-xs text-slate-600 leading-relaxed">
                Apakah Anda yakin ingin membatalkan pengajuan peminjaman laboratorium ini?
            </p>
            <div class="flex justify-end gap-2 pt-2">
                <button onclick="closeCancelModal()" type="button" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">Batal</button>
                <form id="cancelBookingForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded-xl text-xs font-semibold hover:bg-rose-700 transition">Iya, Batalkan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function filterMhsBookingList() {
        let input = document.getElementById('mhsSearchInput').value.trim().toLowerCase();
        let filter = document.getElementById('mhsFilterStatus').value;
        let cards = document.getElementsByClassName('mhs-booking-card');

        for (let i = 0; i < cards.length; i++) {
            let card = cards[i];
            let status = card.getAttribute('data-status');
            let searchTarget = card.getAttribute('data-search');

            let matchesSearch = (input === '' || searchTarget.includes(input));
            let matchesStatus = (filter === 'all' || status === filter);

            if (matchesSearch && matchesStatus) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }
        }
    }

    function openCancelModal(actionUrl) {
        document.getElementById('cancelBookingForm').action = actionUrl;
        document.getElementById('cancelBookingModal').classList.remove('hidden');
    }

    function closeCancelModal() {
        document.getElementById('cancelBookingModal').classList.add('hidden');
    }
</script>
@endsection