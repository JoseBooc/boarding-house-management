<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Rooms</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $roomsTotal }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Available</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $roomsAvailable }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Occupied</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $roomsOccupied }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Tenants</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $tenants }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Overdue Invoices</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $overdueInvoices }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Open Maintenance</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $openMaintenance }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Revenue (This Month)</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ number_format($monthlyRevenue, 2) }}</div>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <a href="{{ route('admin.rooms.index') }}" class="bg-white block overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-lg font-semibold text-gray-800">Rooms Management</div>
                        <p class="mt-1 text-gray-600">Add, edit, and track rooms.</p>
                    </div>
                </a>
                <a href="{{ route('admin.tenants.index') }}" class="bg-white block overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-lg font-semibold text-gray-800">Tenants Management</div>
                        <p class="mt-1 text-gray-600">Manage tenant profiles and leases.</p>
                    </div>
                </a>
                <a href="{{ route('admin.billing.invoices.index') }}" class="bg-white block overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-lg font-semibold text-gray-800">Billing & Payments</div>
                        <p class="mt-1 text-gray-600">Generate invoices and record payments.</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
