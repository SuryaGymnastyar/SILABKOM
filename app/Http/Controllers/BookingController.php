<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function katalog()
    {
        $rooms = Room::withCount([
            'bookings as bookings_aktif_count' => function ($query) {
                $query->whereIn('status', ['Menunggu', 'Disetujui']);
            }
        ])->orderBy('name')->get();

        return view('mahasiswa.katalog', compact('rooms'));
    }

    public function index()
    {
        $bookings = RoomBooking::with('room')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('mahasiswa.index', compact('bookings'));
    }

    public function create()
    {
        $rooms = Room::where('condition', 'Baik')
            ->orderBy('name')
            ->get();

        return view('mahasiswa.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'room_id' => [
                'required',
                'integer',
                'exists:rooms,id',
            ],
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'purpose' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ], [
            'room_id.required' => 'Pilih laboratorium terlebih dahulu.',
            'booking_date.after_or_equal' => 'Tanggal peminjaman tidak boleh sebelum hari ini.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
            'purpose.min' => 'Tujuan peminjaman minimal 10 karakter.',
        ]);

        $room = Room::findOrFail($data['room_id']);

        if ($room->condition !== 'Baik') {
            throw ValidationException::withMessages([
                'room_id' => 'Laboratorium sedang tidak tersedia.',
            ]);
        }

        $this->checkScheduleConflict($data);

        RoomBooking::create([
            'user_id' => Auth::id(),
            'room_id' => $data['room_id'],
            'booking_date' => $data['booking_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'purpose' => $data['purpose'],
            'status' => 'Menunggu',
        ]);

        return redirect()
            ->route('mahasiswa.booking.index')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim dan menunggu verifikasi admin.');
    }

    public function edit($id)
    {
        $booking = RoomBooking::with('room')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        abort_unless($booking->status === 'Menunggu', 403);

        $rooms = Room::orderBy('name')->get();

        return view('mahasiswa.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        $booking = RoomBooking::where('user_id', Auth::id())
            ->findOrFail($id);

        abort_unless($booking->status === 'Menunggu', 403);

        $data = $request->validate([
            'room_id' => [
                'required',
                'integer',
                'exists:rooms,id',
            ],
            'booking_date' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'start_time' => [
                'required',
                'date_format:H:i',
            ],
            'end_time' => [
                'required',
                'date_format:H:i',
                'after:start_time',
            ],
            'purpose' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ]);

        $room = Room::findOrFail($data['room_id']);

        if ($room->condition !== 'Baik') {
            throw ValidationException::withMessages([
                'room_id' => 'Laboratorium sedang tidak tersedia.',
            ]);
        }

        $this->checkScheduleConflict($data, $booking->id);

        $booking->update($data);

        return redirect()
            ->route('mahasiswa.booking.index')
            ->with('success', 'Pengajuan peminjaman berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $booking = RoomBooking::where('user_id', Auth::id())
            ->findOrFail($id);

        abort_unless($booking->status === 'Menunggu', 403);

        $booking->delete();

        return redirect()
            ->route('mahasiswa.booking.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }

    private function checkScheduleConflict(array $data, ?int $ignoreId = null): void
    {
        $query = RoomBooking::where('room_id', $data['room_id'])
            ->whereDate('booking_date', $data['booking_date'])
            ->whereIn('status', ['Menunggu', 'Disetujui'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time']);

        if ($ignoreId !== null) {
            $query->where('id', '!=', $ignoreId);
        }

        if ($query->exists()) {
            throw ValidationException::withMessages([
                'start_time' => 'Jadwal tersebut bertabrakan dengan pengajuan lain. Silakan pilih waktu berbeda.',
            ]);
        }
    }
}