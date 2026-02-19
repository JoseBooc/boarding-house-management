<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reports & Analytics</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800">Revenue (last 12 months)</h3>
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($revenueByMonth as $row)
                            <div class="border rounded-md p-3">
                                <div class="text-sm text-gray-500">{{ $row->ym }}</div>
                                <div class="text-xl font-semibold text-gray-800">{{ number_format($row->total, 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Rooms</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $occupancy['total'] }}</div>
                        <div class="mt-1 text-sm text-gray-600">Occupied: {{ $occupancy['occupied'] }} | Available: {{ $occupancy['available'] }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Tenants</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $tenantCount }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Estimated Arrears</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ number_format($arrears, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
