<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Payments for {{ $invoice->number }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('status') }}</div>
            @endif
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800">Record Payment</h3>
                        <form method="POST" action="{{ route('admin.billing.payments.store', $invoice) }}" class="mt-4 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" step="0.01" min="0.01" name="amount" class="mt-1 block w-full rounded-md border-gray-300" required />
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Paid At</label>
                                    <input type="datetime-local" name="paid_at" class="mt-1 block w-full rounded-md border-gray-300" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Method</label>
                                    <input name="method" value="cash" class="mt-1 block w-full rounded-md border-gray-300" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Reference</label>
                                <input name="reference" class="mt-1 block w-full rounded-md border-gray-300" />
                            </div>
                            <div class="pt-2">
                                <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">Add Payment</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 overflow-x-auto">
                        <h3 class="text-lg font-semibold text-gray-800">Payments History</h3>
                        <table class="mt-4 min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Paid At</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($payments as $payment)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ number_format($payment->amount, 2) }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $payment->paid_at->format('Y-m-d H:i') }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $payment->method }}</td>
                                        <td class="px-4 py-2 text-sm text-gray-700">{{ $payment->reference }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-4">{{ $payments->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
