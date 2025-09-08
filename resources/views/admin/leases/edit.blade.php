<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Lease</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.leases.update', $lease) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tenant</label>
                                <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    @foreach($tenants as $t)
                                        <option value="{{ $t->id }}" @if(old('user_id', $lease->user_id) == $t->id) selected @endif>{{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Room</label>
                                <select name="room_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    @foreach($rooms as $r)
                                        <option value="{{ $r->id }}" @if(old('room_id', $lease->room_id) == $r->id) selected @endif>{{ $r->number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" value="{{ old('start_date', $lease->start_date?->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" value="{{ old('end_date', optional($lease->end_date)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rent Amount</label>
                                <input type="number" step="0.01" min="0" name="rent_amount" value="{{ old('rent_amount', $lease->rent_amount) }}" class="mt-1 block w-full rounded-md border-gray-300" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deposit Amount</label>
                                <input type="number" step="0.01" min="0" name="deposit_amount" value="{{ old('deposit_amount', $lease->deposit_amount) }}" class="mt-1 block w-full rounded-md border-gray-300" />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                    @foreach(['pending'=>'Pending','active'=>'Active','terminated'=>'Terminated'] as $val=>$label)
                                        <option value="{{ $val }}" @if(old('status', $lease->status) === $val) selected @endif>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contract</label>
                            <textarea name="contract_text" rows="5" class="mt-1 block w-full rounded-md border-gray-300">{{ old('contract_text', $lease->contract_text) }}</textarea>
                        </div>
                        <div class="pt-4">
                            <a href="{{ route('admin.leases.index') }}" class="inline-flex items-center px-4 py-2 mr-3 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
