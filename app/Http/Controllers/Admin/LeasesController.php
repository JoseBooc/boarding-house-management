<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class LeasesController extends Controller
{
    public function index()
    {
        $leases = Lease::with(['user','room'])->latest()->paginate(15);
        return view('admin.leases.index', compact('leases'));
    }

    public function create()
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->get();
        $rooms = Room::orderBy('number')->get();
        return view('admin.leases.create', compact('tenants','rooms'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,active,terminated',
            'contract_text' => 'nullable|string',
        ]);
        Lease::create($data);
        return redirect()->route('admin.leases.index')->with('status', 'Lease created');
    }

    public function edit(Lease $lease)
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->get();
        $rooms = Room::orderBy('number')->get();
        return view('admin.leases.edit', compact('lease','tenants','rooms'));
    }

    public function update(Request $request, Lease $lease)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'rent_amount' => 'required|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,active,terminated',
            'contract_text' => 'nullable|string',
        ]);
        $lease->update($data);
        return redirect()->route('admin.leases.index')->with('status', 'Lease updated');
    }

    public function destroy(Lease $lease)
    {
        $lease->delete();
        return redirect()->route('admin.leases.index')->with('status', 'Lease deleted');
    }
}
