@extends('layouts.app')
@section('title', 'Kelola Ruangan Lab')
@section('content')
<div class="space-y-4">
    
    <!-- Header Page -->
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Kelola Ruangan Lab</h1>
        <button onclick="openModal('createModal')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition flex items-center gap-2">
            <span>+ Tambah Lab</span>
        </button>
    </div>

    <!-- Tabel Daftar Lab -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider">
                    <th class="p-4 font-semibold">Nama Lab</th>
                    <th class="p-4 font-semibold">Lokasi</th>
                    <th class="p-4 font-semibold">Fasilitas</th>
                    <th class="p-4 font-semibold">Kapasitas</th>
                    <th class="p-4 font-semibold">Kondisi</th>
                    <th class="p-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-sm text-slate-700">
                @forelse($rooms as $room)
                <tr class="hover:bg-slate-50 transition">
                    <td class="p-4 font-medium text-slate-900">{{ $room->name }}</td>
                    <td class="p-4">{{ $room->location ?? '-' }}</td>
                    <td class="p-4">{{ $room->facilities ?? '-' }}</td>
                    <td class="p-4">{{ $room->capacity }} Orang</td>
                    <td class="p-4">
                        @if($room->condition == 'Baik')
                            <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-md font-medium text-xs">Baik</span>
                        @elseif($room->condition == 'Perbaikan')
                            <span class="px-2 py-1 bg-amber-50 text-amber-600 rounded-md font-medium text-xs">Perbaikan</span>
                        @else
                            {{ $room->condition ?? '-' }}
                        @endif
                    </td>
                    <td class="p-4 text-center">
                        <div class="flex items-center justify-center space-x-3">
                            <!-- Tombol Edit Pop-up -->
                            <button onclick="openEditModal('{{ $room->id }}', '{{ addslashes($room->name) }}', '{{ addslashes($room->location) }}', '{{ addslashes($room->facilities) }}', '{{ $room->capacity }}', '{{ addslashes($room->condition) }}')" class="px-3 py-1.5 bg-indigo-50 text-indigo-600 hover:bg-indigo-100 rounded-lg font-medium text-xs transition">
                                Edit
                            </button>
                            
                            <!-- Tombol Hapus -->
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus lab ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1.5 bg-rose-50 text-rose-600 hover:bg-rose-100 rounded-lg font-medium text-xs transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-6 text-center text-slate-500">Belum ada data ruangan lab.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- MODAL POP-UP TAMBAH LAB -->
    <div id="createModal" class="fixed inset-0 z-50 flex items-start justify-center pt-2 bg-slate-900/40 backdrop-blur-sm p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-lg self-start overflow-hidden">
            <div class="px-5 pt-3 pb-2 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-800">Tambah Ruangan Lab</h3>
                <button onclick="closeModal('createModal')" class="text-slate-400 hover:text-slate-600 font-bold text-xl">&times;</button>
            </div>
            <form action="{{ route('admin.rooms.store') }}" method="POST" class="p-5 space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Nama Lab</label>
                    <input type="text" name="name" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Lokasi Lab (Gedung/Lantai)</label>
                    <input type="text" name="location" placeholder="Contoh: Gedung Lab Terpadu Lt. 2" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Fasilitas Lab</label>
                    <input type="text" name="facilities" placeholder="Contoh: AC, Proyektor, 30 PC" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Kapasitas (Orang)</label>
                    <input type="number" name="capacity" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Kondisi Lab</label>
                    <select name="condition" class="w-full rounded-lg border-slate-300 border p-2 text-sm bg-white" required>
                        <option value="Baik">Baik</option>
                        <option value="Perbaikan">Perbaikan</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" onclick="closeModal('createModal')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL POP-UP EDIT LAB -->
    <div id="editModal" class="fixed inset-0 z-50 flex items-start justify-center pt-2 bg-slate-900/40 backdrop-blur-sm p-4 hidden">
        <div class="bg-white rounded-2xl shadow-xl border border-slate-200 w-full max-w-lg self-start overflow-hidden">
            <div class="px-5 pt-3 pb-2 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-base font-bold text-slate-800">Edit Ruangan Lab</h3>
                <button onclick="closeModal('editModal')" class="text-slate-400 hover:text-slate-600 font-bold text-xl">&times;</button>
            </div>
            <form id="editForm" method="POST" class="p-5 space-y-3">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Nama Lab</label>
                    <input type="text" id="edit_name" name="name" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Lokasi Lab (Gedung/Lantai)</label>
                    <input type="text" id="edit_location" name="location" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Fasilitas Lab</label>
                    <input type="text" id="edit_facilities" name="facilities" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Kapasitas (Orang)</label>
                    <input type="number" id="edit_capacity" name="capacity" class="w-full rounded-lg border-slate-300 border p-2 text-sm" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-700 mb-1.5">Kondisi Lab</label>
                    <select id="edit_condition" name="condition" class="w-full rounded-lg border-slate-300 border p-2 text-sm bg-white" required>
                        <option value="Baik">Baik</option>
                        <option value="Perbaikan">Perbaikan</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-2 pt-2">
                    <button type="button" onclick="closeModal('editModal')" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-200">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700">Perbarui</button>
                </div>
            </form>
        </div>
    </div>

</div>

<!-- SCRIPT PENGATUR MODAL -->
<script>
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    function openEditModal(id, name, location, facilities, capacity, condition) {
        document.getElementById('editForm').action = '/admin/rooms/' + id;
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_location').value = location;
        document.getElementById('edit_facilities').value = facilities;
        document.getElementById('edit_capacity').value = capacity;
        document.getElementById('edit_condition').value = condition;
        openModal('editModal');
    }
</script>
@endsection