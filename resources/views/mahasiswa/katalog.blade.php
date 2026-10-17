@extends('layouts.app')

@section('title', 'Katalog Laboratorium')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Katalog Laboratorium</h1>
            <p class="text-sm text-slate-500 mt-1">
                Temukan laboratorium yang sesuai dengan kebutuhan kegiatanmu.
            </p>
        </div>

        <a href="{{ route('mahasiswa.booking.create') }}"
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition">
            <i data-lucide="calendar-plus" class="w-4 h-4"></i>
            Ajukan Peminjaman
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
        @forelse($rooms as $room)
            <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                <div class="h-2 {{ $room->condition === 'Baik' ? 'bg-indigo-500' : 'bg-amber-500' }}"></div>

                <div class="p-5 space-y-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600">
                            <i data-lucide="building-2" class="w-6 h-6"></i>
                        </div>

                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                            {{ $room->condition === 'Baik'
                                ? 'bg-emerald-50 text-emerald-700'
                                : 'bg-amber-50 text-amber-700' }}">
                            {{ $room->condition }}
                        </span>
                    </div>

                    <div>
                        <h2 class="text-lg font-bold text-slate-800">
                            {{ $room->name }}
                        </h2>
                        <p class="text-sm text-slate-500 mt-1 flex items-center gap-2">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                            {{ $room->location }}
                        </p>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-slate-600">
                        <i data-lucide="users" class="w-4 h-4 text-indigo-500"></i>
                        Kapasitas {{ $room->capacity }} orang
                    </div>

                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-slate-400 mb-2">
                            Fasilitas
                        </p>
                        <p class="text-sm text-slate-600 leading-6 whitespace-pre-line">
                            {{ $room->facilities ?: 'Informasi fasilitas belum tersedia.' }}
                        </p>
                    </div>

                    <div class="pt-3 border-t border-slate-100">
                        @if($room->condition === 'Baik')
                            <a href="{{ route('mahasiswa.booking.create', ['room_id' => $room->id]) }}"
                               class="flex items-center justify-center gap-2 w-full px-4 py-2.5 rounded-xl bg-indigo-600 text-white text-sm font-semibold hover:bg-indigo-700 transition">
                                Ajukan Peminjaman
                                <i data-lucide="arrow-right" class="w-4 h-4"></i>
                            </a>
                        @else
                            <button type="button" disabled
                                    class="w-full px-4 py-2.5 rounded-xl bg-slate-100 text-slate-400 text-sm font-semibold cursor-not-allowed">
                                Lab Sedang Diperbaiki
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="sm:col-span-2 xl:col-span-3 bg-white border border-dashed border-slate-300 rounded-2xl p-10 text-center">
                <i data-lucide="building-2" class="w-10 h-10 text-slate-300 mx-auto mb-3"></i>
                <h2 class="font-semibold text-slate-700">Belum Ada Laboratorium</h2>
                <p class="text-sm text-slate-500 mt-1">
                    Daftar laboratorium akan muncul setelah data ditambahkan oleh admin.
                </p>
            </div>
        @endforelse
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection