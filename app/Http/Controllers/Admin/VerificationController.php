<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomBooking;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index()
    {
        $bookings = RoomBooking::with(['user', 'room'])
            ->where('status', 'Menunggu') 
            ->latest()
            ->get();

        return view('admin.verifikasi.index', compact('bookings'));
    }

    public function approve($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $booking->status = 'Disetujui';
        $booking->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject($id)
    {
        $booking = RoomBooking::findOrFail($id);
        $booking->status = 'Ditolak';
        $booking->save();

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function history()
    {
        $bookings = RoomBooking::with(['user', 'room'])
            ->whereIn('status', ['Disetujui', 'Ditolak']) 
            ->latest()
            ->get();

        return view('admin.verifikasi.history', compact('bookings'));
    }
}