@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <a href="{{ route('mahasiswa.katalog') }}"
           class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Katalog Lab
        </a>

        <h1 class="text-2xl font-bold text-slate-800">Ajukan Peminjaman Lab</h1>
        <p class="text-sm text-slate-500 mt-1">
            Lengkapi formulir berikut untuk mengajukan peminjaman laboratorium.
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 sm:p-7">
        <form action="{{ route('mahasiswa.booking.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="room_id" class="block text-sm font-semibold text-slate-700 mb-2">
                    Laboratorium <span class="text-rose-500">*</span>
                </label>

                <select id="room_id" name="room_id" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
                    <option value="">Pilih laboratorium</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}"
                            {{ (string) old('room_id', request('room_id')) === (string) $room->id ? 'selected' : '' }}>
                            {{ $room->name }} — {{ $room->location }} ({{ $room->capacity }} orang)
                        </option>
                    @endforeach
                </select>

                @error('room_id')
                    <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                @enderror

                @if($rooms->isEmpty())
                    <p class="text-sm text-amber-600 mt-2">
                        Belum ada laboratorium dengan kondisi baik yang dapat dipinjam.
                    </p>
                @endif
            </div>

            <div>
                <label for="booking_date" class="block text-sm font-semibold text-slate-700 mb-2">
                    Tanggal Peminjaman <span class="text-rose-500">*</span>
                </label>

                <input type="date" id="booking_date" name="booking_date"
                       min="{{ now()->toDateString() }}"
                       value="{{ old('booking_date') }}" required
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                @error('booking_date')
                    <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="start_time" class="block text-sm font-semibold text-slate-700 mb-2">
                        Waktu Mulai <span class="text-rose-500">*</span>
                    </label>

                    <input type="time" id="start_time" name="start_time"
                           value="{{ old('start_time') }}" required
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                    @error('start_time')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-semibold text-slate-700 mb-2">
                        Waktu Selesai <span class="text-rose-500">*</span>
                    </label>

                    <input type="time" id="end_time" name="end_time"
                           value="{{ old('end_time') }}" required
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                    @error('end_time')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="purpose" class="block text-sm font-semibold text-slate-700 mb-2">
                    Tujuan Peminjaman <span class="text-rose-500">*</span>
                </label>

                <textarea id="purpose" name="purpose" rows="4" required minlength="10" maxlength="2000"
                          placeholder="Contoh: Praktikum mata kuliah, rapat organisasi, atau kegiatan penelitian."
                          class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none resize-y">{{ old('purpose') }}</textarea>

                @error('purpose')
                    <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-start gap-3 rounded-xl bg-indigo-50 border border-indigo-100 p-4">
                <i data-lucide="info" class="w-5 h-5 text-indigo-600 flex-shrink-0 mt-0.5"></i>
                <p class="text-sm text-indigo-800 leading-6">
                    Pengajuan akan berstatus <strong>Menunggu</strong> sampai diverifikasi oleh admin.
                    Pastikan tanggal dan waktu yang dipilih sudah benar.
                </p>
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                <a href="{{ route('mahasiswa.katalog') }}"
                   class="px-5 py-3 text-center text-sm font-semibold text-slate-600 border border-slate-300 rounded-xl hover:bg-slate-50 transition">
                    Batal
                </a>

                <button type="submit" {{ $rooms->isEmpty() ? 'disabled' : '' }}
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed transition">
                    <i data-lucide="send" class="w-4 h-4"></i>
                    Kirim Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection