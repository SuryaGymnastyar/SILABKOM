@extends('layouts.app')
@section('title', 'Tambah Ruangan Lab')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Ruangan Lab</h1>
            <p class="text-slate-500 text-sm mt-0.5">Silakan isi formulir di bawah untuk menambahkan laboratorium baru.</p>
        </div>
        <a href="{{ route('admin.rooms.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold hover:bg-slate-200 transition">
            &larr; Kembali
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 text-rose-800 rounded-2xl border border-rose-200 text-sm space-y-1">
            <p class="font-bold">Gagal menyimpan! Periksa detail berikut:</p>
            <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <form action="{{ route('admin.rooms.store') }}" method="POST" class="p-6 space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Nama Lab <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Lab Komputer Dasar" class="w-full px-4 py-3 border @error('name') border-rose-500 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('name') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Lokasi Lab (Gedung/Lantai) <span class="text-rose-500">*</span></label>
                <input type="text" name="location" value="{{ old('location') }}" required placeholder="Contoh: Gedung Lab Terpadu Lt. 2" class="w-full px-4 py-3 border @error('location') border-rose-500 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('location') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Fasilitas Lab <span class="text-rose-500">*</span></label>
                <input type="text" name="facilities" value="{{ old('facilities') }}" required placeholder="Contoh: AC, Proyektor, 30 PC" class="w-full px-4 py-3 border @error('facilities') border-rose-500 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('facilities') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kapasitas (Orang) <span class="text-rose-500">*</span></label>
                <input type="number" name="capacity" min="1" value="{{ old('capacity') }}" required placeholder="Contoh: 30" class="w-full px-4 py-3 border @error('capacity') border-rose-500 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                @error('capacity') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 uppercase mb-1">Kondisi Lab <span class="text-rose-500">*</span></label>
                <select name="condition" required class="w-full px-4 py-3 border @error('condition') border-rose-500 @else border-slate-200 @enderror rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                    <option value="" disabled {{ old('condition') == '' ? 'selected' : '' }}>-- Pilih Kondisi Lab --</option>
                    <option value="Baik" {{ old('condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Perbaikan" {{ old('condition') == 'Perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                </select>
                @error('condition') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                <a href="{{ route('admin.rooms.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 font-semibold text-xs rounded-xl hover:bg-slate-200 transition">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white font-semibold text-xs rounded-xl hover:bg-indigo-700 transition shadow-sm">
                    Simpan Lab
                </button>
            </div>
        </form>
    </div>
</div>
@endsection