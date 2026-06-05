@extends('layouts.admin')

@section('title', 'Manage Rooms')

@section('page-title', 'Room Management')

@section('page-subtitle', 'Add, update, search and manage hotel rooms.')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.rooms.create') }}"
       class="bg-amber-400 text-slate-950 px-6 py-3 rounded-2xl font-bold shadow hover:bg-amber-300">
        + Add Room
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<form method="GET" class="bg-white p-5 rounded-3xl shadow mb-6 grid md:grid-cols-3 gap-4">
    <input type="text"
           name="search"
           value="{{ $search }}"
           placeholder="Search room number or type"
           class="border rounded-2xl px-4 py-3">

    <select name="status" class="border rounded-2xl px-4 py-3">
        <option value="">All Status</option>
        <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available</option>
        <option value="occupied" {{ $status == 'occupied' ? 'selected' : '' }}>Occupied</option>
        <option value="maintenance" {{ $status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
    </select>

    <button class="bg-slate-950 text-white rounded-2xl px-4 py-3 font-bold">
        Filter
    </button>
</form>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[900px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-4 text-left">Image</th>
                    <th class="p-4 text-left">Room</th>
                    <th class="p-4 text-left">Type</th>
                    <th class="p-4 text-left">Price</th>
                    <th class="p-4 text-left">Capacity</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($rooms as $room)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-4">
                            <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://via.placeholder.com/100' }}"
                                 class="w-24 h-16 object-cover rounded-2xl">
                        </td>

                        <td class="p-4 font-bold">
                            {{ $room->room_number }}
                        </td>

                        <td class="p-4">
                            {{ $room->room_type }}
                        </td>

                        <td class="p-4 font-semibold">
                            Rs. {{ number_format($room->price_per_night, 2) }}
                        </td>

                        <td class="p-4">
                            {{ $room->capacity }}
                        </td>

                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                   class="bg-amber-400 text-slate-950 px-4 py-2 rounded-xl font-bold">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.rooms.destroy', $room->id) }}"
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="delete-btn bg-red-500 text-white px-4 py-2 rounded-xl font-bold">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500">
                            No rooms found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $rooms->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        Swal.fire({
            title: 'Delete this room?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
});
</script>
@endpush