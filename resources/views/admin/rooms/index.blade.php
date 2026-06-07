@extends('layouts.admin')

@section('title', 'Manage Rooms')

@section('page-title', 'Room Management')

@section('page-subtitle', 'Add, update, search and manage hotel rooms.')

@section('content')

<div class="flex flex-col xl:flex-row xl:items-center justify-between gap-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 flex-1">

<div class="bg-white p-6 rounded-3xl shadow border-l-4 border-blue-500 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">            
    <p class="text-slate-500">Total Rooms</p>
            <h2 class="text-3xl font-extrabold text-blue-600">
                {{ $rooms->total() }}
            </h2>
        </div>

<div class="bg-white p-6 rounded-3xl shadow border-l-4 border-green-500 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">            
    <p class="text-slate-500">Available</p>
            <h2 class="text-3xl font-extrabold text-green-600">
                {{ \App\Models\Room::where('status', 'available')->count() }}
            </h2>
        </div>


<div class="bg-white p-6 rounded-3xl shadow border-l-4 border-red-500 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">         
       <p class="text-slate-500">Occupied</p>
            <h2 class="text-3xl font-extrabold text-red-600">
                {{ \App\Models\Room::where('status', 'occupied')->count() }}
            </h2>
        </div>

    </div>

    <a href="{{ route('admin.rooms.create') }}"
       class="bg-amber-400 text-slate-950 px-7 py-4 rounded-2xl font-bold shadow hover:bg-amber-300 transition-all duration-300 text-center">
        + Add Room
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-5 rounded-3xl shadow mb-6 grid md:grid-cols-3 gap-4">
    <input type="text"
           id="roomSearch"
           value="{{ $search }}"
           placeholder="Search room number or type..."
           class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

    <select id="roomStatus"
            class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
        <option value="">All Status</option>
        <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available</option>
        <option value="occupied" {{ $status == 'occupied' ? 'selected' : '' }}>Occupied</option>
        <option value="maintenance" {{ $status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
    </select>

    <button type="button"
            id="roomReset"
            class="bg-slate-950 text-white rounded-2xl px-4 py-3 font-bold hover:bg-slate-800 transition">
        Reset
    </button>
</div>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[950px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-5 text-left">Room</th>
                    <th class="p-5 text-left">Type</th>
                    <th class="p-5 text-left">Price</th>
                    <th class="p-5 text-left">Capacity</th>
                    <th class="p-5 text-left">Status</th>
                    <th class="p-5 text-left">Actions</th>
                </tr>
            </thead>

            <tbody id="roomsTableBody">
                @forelse($rooms as $room)
                    <tr class="border-b hover:bg-slate-50 transition">
                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=300&q=80' }}"
                                     class="w-24 h-16 object-cover rounded-2xl shadow">

                                <div>
                                    <p class="font-extrabold text-slate-900">{{ $room->room_number }}</p>
                                    <p class="text-sm text-slate-500">Room ID #{{ $room->id }}</p>
                                </div>
                            </div>
                        </td>

                        <td class="p-5 font-semibold">{{ $room->room_type }}</td>

                        <td class="p-5 font-bold text-purple-600">
                            Rs. {{ number_format($room->price_per_night, 2) }}
                        </td>

                        <td class="p-5">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $room->capacity }} Guests
                            </span>
                        </td>

                        <td class="p-5">
                            <span class="px-4 py-2 rounded-full text-sm font-bold
                                {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>

                        <td class="p-5">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                   class="bg-amber-400 text-slate-950 px-4 py-2 rounded-xl font-bold hover:bg-amber-300 transition">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.rooms.destroy', $room->id) }}"
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="delete-btn bg-red-500 text-white px-4 py-2 rounded-xl font-bold hover:bg-red-600 transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-slate-500">
                            No rooms found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6" id="roomsPagination">
    {{ $rooms->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const roomSearch = document.getElementById('roomSearch');
const roomStatus = document.getElementById('roomStatus');
const roomReset = document.getElementById('roomReset');
const roomsTableBody = document.getElementById('roomsTableBody');
const roomsPagination = document.getElementById('roomsPagination');

function getRoomStatusClass(status) {
    if (status === 'available') return 'bg-green-100 text-green-700';
    if (status === 'occupied') return 'bg-red-100 text-red-700';
    if (status === 'maintenance') return 'bg-yellow-100 text-yellow-700';
    return 'bg-slate-100 text-slate-700';
}

function attachDeleteEvents() {
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
}

function loadAdminRooms() {
    const search = roomSearch.value;
    const status = roomStatus.value;

    roomsTableBody.innerHTML = `
        <tr>
            <td colspan="6" class="p-10 text-center text-slate-500">
                Loading rooms...
            </td>
        </tr>
    `;

    fetch(`{{ route('admin.ajax.rooms') }}?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        roomsTableBody.innerHTML = '';
        roomsPagination.innerHTML = '';

        if (data.rooms.length === 0) {
            roomsTableBody.innerHTML = `
                <tr>
                    <td colspan="6" class="p-10 text-center text-slate-500">
                        No rooms found.
                    </td>
                </tr>
            `;
            return;
        }

        data.rooms.forEach(room => {
            let image = room.image
                ? `/storage/${room.image}`
                : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=300&q=80';

            let statusClass = getRoomStatusClass(room.status);

            roomsTableBody.innerHTML += `
                <tr class="border-b hover:bg-slate-50 transition">
                    <td class="p-5">
                        <div class="flex items-center gap-4">
                            <img src="${image}" class="w-24 h-16 object-cover rounded-2xl shadow">

                            <div>
                                <p class="font-extrabold text-slate-900">${room.room_number}</p>
                                <p class="text-sm text-slate-500">Room ID #${room.id}</p>
                            </div>
                        </div>
                    </td>

                    <td class="p-5 font-semibold">${room.room_type}</td>

                    <td class="p-5 font-bold text-purple-600">
                        Rs. ${Number(room.price_per_night).toLocaleString()}
                    </td>

                    <td class="p-5">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                            ${room.capacity} Guests
                        </span>
                    </td>

                    <td class="p-5">
                        <span class="px-4 py-2 rounded-full text-sm font-bold ${statusClass}">
                            ${room.status.charAt(0).toUpperCase() + room.status.slice(1)}
                        </span>
                    </td>

                    <td class="p-5">
                        <div class="flex gap-2">
                            <a href="/admin/rooms/${room.id}/edit"
                               class="bg-amber-400 text-slate-950 px-4 py-2 rounded-xl font-bold hover:bg-amber-300 transition">
                                Edit
                            </a>

                            <form method="POST" action="/admin/rooms/${room.id}" class="delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="delete-btn bg-red-500 text-white px-4 py-2 rounded-xl font-bold hover:bg-red-600 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `;
        });

        attachDeleteEvents();
    })
    .catch(() => {
        Swal.fire('Error', 'Failed to load rooms.', 'error');
    });
}

roomSearch.addEventListener('keyup', loadAdminRooms);
roomStatus.addEventListener('change', loadAdminRooms);

roomReset.addEventListener('click', function () {
    roomSearch.value = '';
    roomStatus.value = '';
    loadAdminRooms();
});

attachDeleteEvents();
</script>
@endpush