<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Maintenance Request</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.maintenance.update', $maintenance) }}" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tenant</label>
                                <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    @foreach($tenants as $t)
                                        <option value="{{ $t->id }}" @if(old('user_id', $maintenance->user_id) == $t->id) selected @endif>{{ $t->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Room</label>
                                <select name="room_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    @foreach($rooms as $r)
                                        <option value="{{ $r->id }}" @if(old('room_id', $maintenance->room_id) == $r->id) selected @endif>{{ $r->number }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Title</label>
                            <input name="title" value="{{ old('title', $maintenance->title) }}" class="mt-1 block w-full rounded-md border-gray-300" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300" required>{{ old('description', $maintenance->description) }}</textarea>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Priority</label>
                                <select name="priority" class="mt-1 block w-full rounded-md border-gray-300">
                                    @foreach(['low'=>'Low','medium'=>'Medium','high'=>'High'] as $val=>$label)
                                        <option value="{{ $val }}" @if(old('priority', $maintenance->priority) === $val) selected @endif>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                    @foreach(['open'=>'Open','in_progress'=>'In Progress','resolved'=>'Resolved','closed'=>'Closed'] as $val=>$label)
                                        <option value="{{ $val }}" @if(old('status', $maintenance->status) === $val) selected @endif>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Assignee</label>
                            <select name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Unassigned</option>
                                @foreach($staff as $s)
                                    <option value="{{ $s->id }}" @if(old('assigned_to', $maintenance->assigned_to) == $s->id) selected @endif>{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="pt-4">
                            <a href="{{ route('admin.maintenance.index') }}" class="inline-flex items-center px-4 py-2 mr-3 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                            <button class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
