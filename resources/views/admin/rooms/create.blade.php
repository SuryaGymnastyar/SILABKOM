@extends('layouts.app')
@section('title', 'Tambah Lab')
@section('content')
<div class="max-w-xl mx-auto space-y-4">
    <h1 class="text-2xl font-bold text-slate-800">Tambah Ruangan Lab</h1>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('admin.rooms.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lab</label>
                <input type="text" name="name" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi Lab (Gedung/Lantai)</label>
                <input type="text" name="location" placeholder="Contoh: Gedung Lab Terpadu Lt. 2" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Fasilitas Lab</label>
                <input type="text" name="facilities" placeholder="Contoh: AC, Proyektor, 30 PC" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kapasitas (Orang)</label>
                <input type="number" name="capacity" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kondisi Lab</label>
                <input type="text" name="condition" placeholder="Contoh: Baik / Layak Pakai" class="w-full rounded-lg border-slate-300 border p-2 text-sm">
            </div>
            <div class="flex justify-end space-x-2">
                <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 bg-slate-200 text-slate-700 rounded-lg text-sm">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection