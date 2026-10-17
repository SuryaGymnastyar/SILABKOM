@extends('layouts.app')
@section('title', 'Edit Lab')
@section('content')
<div class="max-w-xl mx-auto space-y-4">
    <h1 class="text-2xl font-bold text-slate-800">Edit Ruangan Lab</h1>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.rooms.update', $room->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lab</label>
                <input type="text" name="name" value="{{ $room->name }}" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi Lab (Gedung/Lantai)</label>
                <input type="text" name="location" value="{{ $room->location }}" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Fasilitas Lab</label>
                <input type="text" name="facilities" value="{{ $room->facilities }}" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kapasitas (Orang)</label>
                <input type="number" name="capacity" value="{{ $room->capacity }}" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kondisi Lab</label>
                <input type="text" name="condition" value="{{ $room->condition }}" placeholder="Contoh: Baik / Layak Pakai" class="w-full rounded-lg border-slate-300 border p-2 text-sm">
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm">Perbarui</button>
            </div>
        </form>
    </div>
</div>
@endsection