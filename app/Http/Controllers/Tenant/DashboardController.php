<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Lease;
use App\Models\MaintenanceRequest;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = auth()->user();
        $activeLease = Lease::with('room')->where('user_id', $user->id)->where('status','active')->first();
        $unpaid = Invoice::where('user_id', $user->id)->whereIn('status', ['pending','overdue'])->sum('amount');
        $maintenanceOpen = MaintenanceRequest::where('user_id', $user->id)->whereIn('status',['open','in_progress'])->count();
        return view('tenant.dashboard', compact('activeLease','unpaid','maintenanceOpen'));
    }
}
