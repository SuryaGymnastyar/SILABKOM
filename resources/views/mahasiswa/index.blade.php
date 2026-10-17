@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Riwayat Peminjaman Saya</h1>
            <p class="text-sm text-slate-500 mt-1">
                Pantau status pengajuan dan lihat riwayat peminjaman laboratoriummu.
            </p>
        </div>

        <a href="{{ route('mahasiswa.booking.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Ajukan Peminjaman
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @foreach([
            ['label' => 'Total Pengajuan', 'value' => $bookings->total(), 'icon' => 'clipboard-list', 'color' => 'indigo'],
            ['label' => 'Menunggu', 'value' => $bookings->getCollection()->where('status', 'Menunggu')->count(), 'icon' => 'clock', 'color' => 'amber'],
            ['label' => 'Disetujui', 'value' => $bookings->getCollection()->where('status', 'Disetujui')->count(), 'icon' => 'check-circle', 'color' => 'emerald']
        ] as $stat)
            <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-slate-500">{{ $stat['label'] }}</p>
                        <p class="text-2xl font-bold text-slate-800 mt-2">{{ $stat['value'] }}</p>
                    </div>

                    <div class="w-11 h-11 rounded-xl flex items-center justify-center
                        {{ $stat['color'] === 'indigo' ? 'bg-indigo-50 text-indigo-600' : '' }}
                        {{ $stat['color'] === 'amber' ? 'bg-amber-50 text-amber-600' : '' }}
                        {{ $stat['color'] === 'emerald' ? 'bg-emerald-50 text-emerald-600' : '' }}">
                        <i data-lucide="{{ $stat['icon'] }}" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100">
            <h2 class="font-bold text-slate-800">Daftar Pengajuan</h2>
            <p class="text-sm text-slate-500 mt-1">Pengajuan terbaru ditampilkan terlebih dahulu.</p>
        </div>

        @forelse($bookings as $booking)
            <div class="p-5 sm:p-6 border-b border-slate-100 last:border-b-0">
                <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                    <div class="flex gap-4">
                        <div class="hidden sm:flex w-12 h-12 flex-shrink-0 items-center justify-center bg-indigo-50 text-indigo-600 rounded-xl">
                            <i data-lucide="building-2" class="w-6 h-6"></i>
                        </div>

                        <div class="space-y-3 min-w-0">
                            <div>
                                <h3 class="font-bold text-slate-800">
                                    {{ $booking->room->name ?? 'Laboratorium tidak tersedia' }}
                                </h3>
                                <p class="text-sm text-slate-500 mt-1">
                                    {{ $booking->room->location ?? '-' }}
                                </p>
                            </div>

                            <div class="flex flex-wrap gap-x-5 gap-y-2 text-sm text-slate-600">
                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                                    {{ date('d-m-Y', strtotime($booking->booking_date)) }}
                                </span>

                                <span class="inline-flex items-center gap-2">
                                    <i data-lucide="clock" class="w-4 h-4 text-slate-400"></i>
                                    {{ substr($booking->start_time, 0, 5) }}
                                    – {{ substr($booking->end_time, 0, 5) }}
                                </span>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-1">
                                    Tujuan
                                </p>
                                <p class="text-sm text-slate-600 whitespace-pre-line">
                                    {{ $booking->purpose }}
                                </p>
                            </div>

                            @if($booking->admin_note)
                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-3">
                                    <p class="text-xs font-semibold text-slate-500 mb-1">Catatan Admin</p>
                                    <p class="text-sm text-slate-700">{{ $booking->admin_note }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row lg:flex-col items-start sm:items-center lg:items-end gap-3">
                        <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold
                            {{ $booking->status === 'Menunggu' ? 'bg-amber-50 text-amber-700' : '' }}
                            {{ $booking->status === 'Disetujui' ? 'bg-emerald-50 text-emerald-700' : '' }}
                            {{ $booking->status === 'Ditolak' ? 'bg-rose-50 text-rose-700' : '' }}">
                            <span class="w-1.5 h-1.5 rounded-full
                                {{ $booking->status === 'Menunggu' ? 'bg-amber-500' : '' }}
                                {{ $booking->status === 'Disetujui' ? 'bg-emerald-500' : '' }}
                                {{ $booking->status === 'Ditolak' ? 'bg-rose-500' : '' }}"></span>
                            {{ $booking->status }}
                        </span>

                        @if($booking->status === 'Menunggu')
                            <div class="flex items-center gap-2">
                                <a href="{{ route('mahasiswa.booking.edit', $booking->id) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-indigo-600 border border-indigo-200 hover:bg-indigo-50 transition">
                                    <i data-lucide="pencil" class="w-4 h-4"></i>
                                    Edit
                                </a>

                                <form action="{{ route('mahasiswa.booking.destroy', $booking->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin membatalkan pengajuan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-2 rounded-lg text-sm font-medium text-rose-600 border border-rose-200 hover:bg-rose-50 transition">
                                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                                        Batalkan
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="p-10 text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center mb-4">
                    <i data-lucide="clipboard-list" class="w-7 h-7"></i>
                </div>

                <h3 class="font-semibold text-slate-800">Belum Ada Riwayat Peminjaman</h3>
                <p class="text-sm text-slate-500 mt-2">
                    Pengajuan yang kamu buat akan ditampilkan di halaman ini.
                </p>

                <a href="{{ route('mahasiswa.katalog') }}"
                   class="inline-flex items-center gap-2 mt-5 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
                    Lihat Katalog Lab
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        @endforelse

        @if($bookings->hasPages())
            <div class="p-5 border-t border-slate-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection