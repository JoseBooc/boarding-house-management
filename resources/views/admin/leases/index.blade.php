<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Leases</h2>
            <a href="{{ route('admin.leases.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Lease</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('status') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tenant</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Room</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Start</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">End</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Rent</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($leases as $lease)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $lease->user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $lease->room->number }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $lease->start_date->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ optional($lease->end_date)->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($lease->rent_amount, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($lease->status) }}</td>
                                    <td class="px-4 py-2 text-right">
                                        <a href="{{ route('admin.leases.edit', $lease) }}" class="text-blue-600 hover:underline mr-3">Edit</a>
                                        <form method="POST" action="{{ route('admin.leases.destroy', $lease) }}" class="inline" onsubmit="return confirm('Delete this lease?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $leases->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
