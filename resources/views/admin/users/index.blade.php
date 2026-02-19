<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admins</h2>
            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Admin</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('status') }}</div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($admins as $admin)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $admin->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $admin->email }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $admin->isBlocked() ? 'Blocked' : 'Active' }}</td>
                                    <td class="px-4 py-2 text-right space-x-3">
                                        @if($admin->isBlocked())
                                        <form method="POST" action="{{ route('admin.users.unblock', $admin) }}" class="inline">
                                            @csrf
                                            <button class="text-green-600 hover:underline">Unblock</button>
                                        </form>
                                        @else
                                        <form method="POST" action="{{ route('admin.users.block', $admin) }}" class="inline">
                                            @csrf
                                            <button class="text-red-600 hover:underline">Block</button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $admins->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
