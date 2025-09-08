<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use App\Models\Invoice;
use App\Models\MaintenanceRequest;
use App\Models\Payment;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $roomsTotal = Room::count();
        $roomsAvailable = Room::where('status', 'available')->count();
        $roomsOccupied = Room::where('status', 'occupied')->count();
        $tenants = User::where('role', User::ROLE_TENANT)->count();
        $overdueInvoices = Invoice::where('status', 'overdue')->count();
        $openMaintenance = MaintenanceRequest::whereIn('status', ['open','in_progress'])->count();
        $monthlyRevenue = Payment::whereBetween('paid_at', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount');

        return view('admin.dashboard', compact(
            'roomsTotal','roomsAvailable','roomsOccupied','tenants','overdueInvoices','openMaintenance','monthlyRevenue'
        ));
    }
}
