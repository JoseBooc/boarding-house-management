<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Staff Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Assigned Maintenance</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $assigned }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Pending Bookings</div>
                        <div class="mt-2 text-2xl font-semibold text-gray-800">{{ $pendingBookings }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
