<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;

class ReportsController extends Controller
{
    public function index()
    {
        $revenueByMonth = Payment::selectRaw('DATE_FORMAT(paid_at, "%Y-%m") as ym, SUM(amount) as total')
            ->groupBy('ym')
            ->orderBy('ym', 'desc')
            ->limit(12)
            ->get();

        $occupancy = [
            'total' => Room::count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'available' => Room::where('status', 'available')->count(),
        ];

        $tenantCount = User::where('role', User::ROLE_TENANT)->count();
        $arrears = Invoice::whereIn('status', ['pending','overdue'])->sum('amount') - Payment::sum('amount');

        return view('admin.reports.index', compact('revenueByMonth','occupancy','tenantCount','arrears'));
    }
}
