<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Room</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.rooms.update', $room) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Number</label>
                            <input name="number" value="{{ old('number', $room->number) }}" class="mt-1 block w-full rounded-md border-gray-300" required />
                            @error('number')<div class="text-red-600 text-sm mt-1">{{ $message }}</div>@enderror
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Type</label>
                                <input name="type" value="{{ old('type', $room->type) }}" class="mt-1 block w-full rounded-md border-gray-300" />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Capacity</label>
                                <input type="number" min="1" name="capacity" value="{{ old('capacity', $room->capacity) }}" class="mt-1 block w-full rounded-md border-gray-300" required />
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rent</label>
                                <input type="number" step="0.01" min="0" name="rent" value="{{ old('rent', $room->rent) }}" class="mt-1 block w-full rounded-md border-gray-300" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                    @foreach(['available'=>'Available','occupied'=>'Occupied','maintenance'=>'Maintenance'] as $val=>$label)
                                        <option value="{{ $val }}" @if(old('status', $room->status) === $val) selected @endif>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" class="mt-1 block w-full rounded-md border-gray-300" rows="4">{{ old('description', $room->description) }}</textarea>
                        </div>
                        <div class="pt-4">
                            <a href="{{ route('admin.rooms.index') }}" class="inline-flex items-center px-4 py-2 mr-3 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
