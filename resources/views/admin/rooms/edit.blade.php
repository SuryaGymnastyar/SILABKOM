@extends('layouts.app')
@section('title', 'Edit Ruangan Lab')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Ruangan Lab</h1>
            <p class="text-slate-500 text-sm mt-0.5">Perbarui informasi data laboratorium.</p>
        </div>
        <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" class="p-6 space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Lab <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $room->name) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Lokasi Lab (Gedung/Lantai) <span class="text-rose-500">*</span></label>
                <input type="text" name="location" value="{{ old('location', $room->location) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Fasilitas Lab <span class="text-rose-500">*</span></label>
                <input type="text" name="facilities" value="{{ old('facilities', $room->facilities ?? $room->facility) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kapasitas (Orang) <span class="text-rose-500">*</span></label>
                <input type="number" name="capacity" min="1" value="{{ old('capacity', $room->capacity) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kondisi Lab <span class="text-rose-500">*</span></label>
                <select name="condition" required class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                    <option value="Baik" {{ old('condition', $room->condition) == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Perbaikan" {{ old('condition', $room->condition) == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.rooms.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-semibold text-xs rounded-xl hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold text-xs rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    Perbarui Lab
                </button>
            </div>
        </form>
    </div>
</div>
@endsection