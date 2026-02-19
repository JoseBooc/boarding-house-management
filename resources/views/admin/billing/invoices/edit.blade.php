<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Invoice</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.billing.invoices.update', $invoice) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tenant</label>
                            <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300">
                                @foreach($tenants as $t)
                                    <option value="{{ $t->id }}" @if(old('user_id', $invoice->user_id) == $t->id) selected @endif>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Lease (optional)</label>
                            <select name="lease_id" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">None</option>
                                @foreach($leases as $l)
                                    <option value="{{ $l->id }}" @if(old('lease_id', $invoice->lease_id) == $l->id) selected @endif>{{ $l->user->name }} - Room {{ $l->room->number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Amount</label>
                                <input type="number" step="0.01" min="0" name="amount" value="{{ old('amount', $invoice->amount) }}" class="mt-1 block w-full rounded-md border-gray-300" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Due Date</label>
                                <input type="date" name="due_date" value="{{ old('due_date', $invoice->due_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300" required />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                @foreach(['pending'=>'Pending','paid'=>'Paid','overdue'=>'Overdue','void'=>'Void'] as $val=>$label)
                                    <option value="{{ $val }}" @if(old('status', $invoice->status) === $val) selected @endif>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notes</label>
                            <textarea name="notes" rows="4" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes', $invoice->notes) }}</textarea>
                        </div>
                        <div class="pt-4">
                            <a href="{{ route('admin.billing.invoices.index') }}" class="inline-flex items-center px-4 py-2 mr-3 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
