<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user','room'])->latest()->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function create()
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->get();
        $rooms = Room::orderBy('number')->get();
        return view('admin.bookings.create', compact('tenants','rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,approved,rejected,cancelled',
        ]);
        Booking::create($data);
        return redirect()->route('admin.bookings.index')->with('status', 'Booking created');
    }

    public function edit(Booking $booking)
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->get();
        $rooms = Room::orderBy('number')->get();
        return view('admin.bookings.edit', compact('booking','tenants','rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,approved,rejected,cancelled',
        ]);
        $booking->update($data);
        return redirect()->route('admin.bookings.index')->with('status', 'Booking updated');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('status', 'Booking deleted');
    }
}
