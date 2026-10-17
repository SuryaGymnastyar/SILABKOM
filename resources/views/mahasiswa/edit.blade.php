@extends('layouts.app')

@section('title', 'Edit Pengajuan Peminjaman')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div>
        <a href="{{ route('mahasiswa.booking.index') }}"
           class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 mb-4">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Riwayat
        </a>

        <h1 class="text-2xl font-bold text-slate-800">Edit Pengajuan Peminjaman</h1>
        <p class="text-sm text-slate-500 mt-1">
            Perbarui informasi pengajuan yang masih menunggu verifikasi.
        </p>
    </div>

    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 sm:p-7">
        <form action="{{ route('mahasiswa.booking.update', $booking->id) }}"
              method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="room_id" class="block text-sm font-semibold text-slate-700 mb-2">
                    Laboratorium
                </label>

                <select id="room_id" name="room_id" required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}"
                            {{ (string) old('room_id', $booking->room_id) === (string) $room->id ? 'selected' : '' }}
                            {{ $room->condition !== 'Baik' && $room->id != $booking->room_id ? 'disabled' : '' }}>
                            {{ $room->name }} — {{ $room->location }}
                            ({{ $room->condition }})
                        </option>
                    @endforeach
                </select>

                @error('room_id')
                    <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="booking_date" class="block text-sm font-semibold text-slate-700 mb-2">
                    Tanggal Peminjaman
                </label>

                <input type="date" id="booking_date" name="booking_date"
                       min="{{ now()->toDateString() }}"
                       value="{{ old('booking_date', $booking->booking_date) }}" required
                       class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                @error('booking_date')
                    <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="start_time" class="block text-sm font-semibold text-slate-700 mb-2">
                        Waktu Mulai
                    </label>

                    <input type="time" id="start_time" name="start_time"
                           value="{{ old('start_time', substr($booking->start_time, 0, 5)) }}" required
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                    @error('start_time')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-semibold text-slate-700 mb-2">
                        Waktu Selesai
                    </label>

                    <input type="time" id="end_time" name="end_time"
                           value="{{ old('end_time', substr($booking->end_time, 0, 5)) }}" required
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none">

                    @error('end_time')
                        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="purpose" class="block text-sm font-semibold text-slate-700 mb-2">
                    Tujuan Peminjaman
                </label>

                <textarea id="purpose" name="purpose" rows="4" minlength="10" maxlength="2000" required
                          class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 outline-none resize-y">{{ old('purpose', $booking->purpose) }}</textarea>

                @error('purpose')
                    <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex flex-col-reverse sm:flex-row sm:justify-end gap-3 pt-2">
                <a href="{{ route('mahasiswa.booking.index') }}"
                   class="px-5 py-3 text-center text-sm font-semibold text-slate-600 border border-slate-300 rounded-xl hover:bg-slate-50 transition">
                    Batal
                </a>

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 px-5 py-3 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
@endsection