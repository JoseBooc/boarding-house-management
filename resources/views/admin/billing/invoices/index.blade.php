<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoices</h2>
            <a href="{{ route('admin.billing.invoices.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">Add Invoice</a>
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
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Number</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tenant</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Due</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @foreach($invoices as $invoice)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $invoice->number }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $invoice->user->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($invoice->amount, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $invoice->due_date->format('Y-m-d') }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($invoice->status) }}</td>
                                    <td class="px-4 py-2 text-right space-x-3">
                                        <a href="{{ route('admin.billing.invoices.edit', $invoice) }}" class="text-blue-600 hover:underline">Edit</a>
                                        <a href="{{ route('admin.billing.payments.index', $invoice) }}" class="text-green-600 hover:underline">Payments</a>
                                        <form method="POST" action="{{ route('admin.billing.invoices.destroy', $invoice) }}" class="inline" onsubmit="return confirm('Delete this invoice?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $invoices->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
