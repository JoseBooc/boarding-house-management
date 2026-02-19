<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }
    if ($user->role === \App\Models\User::ROLE_ADMIN) {
        return redirect()->route('admin.dashboard');
    }
    if ($user->role === \App\Models\User::ROLE_STAFF) {
        return redirect()->route('staff.dashboard');
    }
    return redirect()->route('tenant.dashboard');
})->middleware(['auth'])->name('dashboard');

// Role-based dashboards and modules
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\TenantsController;
use App\Http\Controllers\Admin\LeasesController;
use App\Http\Controllers\Admin\BillingController;
use App\Http\Controllers\Admin\BookingsController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;

Route::middleware(['auth','role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');

    Route::resource('rooms', RoomsController::class)->except(['show']);

    Route::resource('tenants', TenantsController::class)->parameters(['tenants' => 'tenant'])->except(['show']);

    Route::resource('leases', LeasesController::class)->except(['show']);

    Route::get('billing/invoices', [BillingController::class, 'invoices'])->name('billing.invoices.index');
    Route::get('billing/invoices/create', [BillingController::class, 'createInvoice'])->name('billing.invoices.create');
    Route::post('billing/invoices', [BillingController::class, 'storeInvoice'])->name('billing.invoices.store');
    Route::get('billing/invoices/{invoice}/edit', [BillingController::class, 'editInvoice'])->name('billing.invoices.edit');
    Route::put('billing/invoices/{invoice}', [BillingController::class, 'updateInvoice'])->name('billing.invoices.update');
    Route::delete('billing/invoices/{invoice}', [BillingController::class, 'destroyInvoice'])->name('billing.invoices.destroy');

    Route::get('billing/invoices/{invoice}/payments', [BillingController::class, 'payments'])->name('billing.payments.index');
    Route::post('billing/invoices/{invoice}/payments', [BillingController::class, 'storePayment'])->name('billing.payments.store');

    Route::resource('bookings', BookingsController::class)->except(['show']);

    Route::resource('maintenance', MaintenanceController::class)->parameters(['maintenance' => 'maintenance'])->except(['show']);

    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');

    Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('users', [UsersController::class, 'index'])->name('users.index');
    Route::get('users/create', [UsersController::class, 'create'])->name('users.create');
    Route::post('users', [UsersController::class, 'store'])->name('users.store');
    Route::post('users/{user}/block', [UsersController::class, 'block'])->name('users.block');
    Route::post('users/{user}/unblock', [UsersController::class, 'unblock'])->name('users.unblock');
});

Route::middleware(['auth','role:tenant'])->prefix('tenant')->name('tenant.')->group(function () {
    Route::get('/', TenantDashboardController::class)->name('dashboard');
});

Route::middleware(['auth','role:staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/', StaffDashboardController::class)->name('dashboard');
});

require __DIR__.'/auth.php';
