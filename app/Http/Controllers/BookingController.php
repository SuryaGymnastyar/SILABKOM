<?php

namespace App\Http\Controllers;

use App\Models\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $bookings = RoomBooking::with(['user', 'room'])->latest()->get();
        } else {
            $bookings = RoomBooking::with('room')->where('user_id', $user->id)->latest()->get();
        }

        return view('bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = RoomBooking::findOrFail($id);
        $booking->status = $request->status; 
        $booking->save();

        return redirect()->back()->with('success', 'Status peminjaman berhasil diperbarui.');
    }
}