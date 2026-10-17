@extends('layouts.app')
@section('title', 'Kelola Ruangan Lab')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Kelola Ruangan Lab</h1>
            <p class="text-slate-500 text-sm mt-0.5">Tambah, ubah, dan atur daftar laboratorium yang tersedia.</p>
        </div>
        <div>
            <a href="{{ route('admin.rooms.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-xl text-sm font-semibold hover:bg-indigo-700 transition shadow-sm">
                + Tambah Lab
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 text-slate-500 text-xs uppercase font-semibold border-b border-slate-200/80">
                        <th class="p-4">Nama Lab</th>
                        <th class="p-4">Lokasi</th>
                        <th class="p-4">Fasilitas</th>
                        <th class="p-4">Kapasitas</th>
                        <th class="p-4">Kondisi</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                    @forelse($rooms as $room)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4 font-semibold text-slate-800">{{ $room->name }}</td>
                        <td class="p-4 text-slate-600">{{ $room->location ?? '-' }}</td>
                        <td class="p-4 text-slate-600">{{ $room->facilities ?? $room->facility ?? '-' }}</td>
                        <td class="p-4 text-slate-600">{{ $room->capacity ?? 0 }} Orang</td>
                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-md font-medium text-xs border border-emerald-200/60">
                                {{ $room->condition ?? 'Baik' }}
                            </span>
                        </td>
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="px-3 py-1.5 bg-amber-50 text-amber-600 border border-amber-200 rounded-lg text-xs font-semibold hover:bg-amber-100 transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus lab ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg text-xs font-semibold hover:bg-rose-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-400">Belum ada data ruangan lab.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection