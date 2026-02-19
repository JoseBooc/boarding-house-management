<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $assigned = MaintenanceRequest::where('assigned_to', auth()->id())->whereIn('status',['open','in_progress'])->count();
        $pendingBookings = Booking::where('status','pending')->count();
        return view('staff.dashboard', compact('assigned','pendingBookings'));
    }
}
