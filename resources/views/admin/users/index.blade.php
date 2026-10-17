@extends('layouts.app')
@section('title', 'Kelola Pengguna')

@section('content')
<div class="space-y-4">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Kelola Pengguna</h1>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-100 text-emerald-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 text-slate-700 uppercase text-xs">
                <tr>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                    <th class="p-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($users as $user)
                    <tr>
                        <td class="p-3 font-medium text-slate-800">{{ $user->name }}</td>
                        <td class="p-3">{{ $user->email }}</td>
                        <td class="p-3 uppercase text-xs font-bold text-slate-500">{{ $user->role }}</td>
                        <td class="p-3 text-right">
                            @if($user->role !== 'admin')
                                <form action="{{ route('admin.users.promote', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-100 text-xs font-semibold">
                                        Jadikan Admin
                                    </button>
                                </form>
                            @else
                                <span class="text-xs text-slate-400 font-medium">Utama</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-slate-400">Belum ada pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection