<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $requests = MaintenanceRequest::with(['user','room','assignee'])->latest()->paginate(15);
        return view('admin.maintenance.index', compact('requests'));
    }

    public function create()
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->get();
        $rooms = Room::orderBy('number')->get();
        $staff = User::where('role', User::ROLE_STAFF)->orderBy('name')->get();
        return view('admin.maintenance.create', compact('tenants','rooms','staff'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        MaintenanceRequest::create($data);
        return redirect()->route('admin.maintenance.index')->with('status', 'Request created');
    }

    public function edit(MaintenanceRequest $maintenance)
    {
        $tenants = User::where('role', User::ROLE_TENANT)->orderBy('name')->get();
        $rooms = Room::orderBy('number')->get();
        $staff = User::where('role', User::ROLE_STAFF)->orderBy('name')->get();
        return view('admin.maintenance.edit', ['maintenance' => $maintenance, 'tenants' => $tenants, 'rooms' => $rooms, 'staff' => $staff]);
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:open,in_progress,resolved,closed',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $maintenance->update($data);
        return redirect()->route('admin.maintenance.index')->with('status', 'Request updated');
    }

    public function destroy(MaintenanceRequest $maintenance)
    {
        $maintenance->delete();
        return redirect()->route('admin.maintenance.index')->with('status', 'Request deleted');
    }
}
