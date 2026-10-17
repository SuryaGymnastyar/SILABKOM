<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Admin
        if ($user->role === 'admin') {
            $totalRooms    = Room::count();
            $totalUsers    = User::where('role', 'mahasiswa')->count();
            $pendingCount  = RoomBooking::where('status', 'Menunggu')->count();
            $approvedCount = RoomBooking::where('status', 'Disetujui')->count();
            $rejectedCount = RoomBooking::where('status', 'Ditolak')->count();

            // Ambil 5 pengajuan terbaru 
            $recentBookings = RoomBooking::with(['user', 'room'])
                ->latest()
                ->take(5)
                ->get();

            return view('admin.dashboard', compact(
                'totalRooms',
                'totalUsers',
                'pendingCount',
                'approvedCount',
                'rejectedCount',
                'recentBookings'
            ));
        }

        // Dashboard Mahasiswa
        $myPendingCount  = RoomBooking::where('user_id', $user->id)->where('status', 'Menunggu')->count();
        $myApprovedCount = RoomBooking::where('user_id', $user->id)->where('status', 'Disetujui')->count();
        $myRejectedCount = RoomBooking::where('user_id', $user->id)->where('status', 'Ditolak')->count();

        // 5 riwayat peminjaman terakhir mahasiswa 
        $myRecentBookings = RoomBooking::with('room')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('mahasiswa.dashboard', compact(
            'myPendingCount',
            'myApprovedCount',
            'myRejectedCount',
            'myRecentBookings'
        ));
    }
}