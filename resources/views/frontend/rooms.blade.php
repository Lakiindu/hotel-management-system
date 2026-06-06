@extends('layouts.customer')

@section('title', 'Browse Rooms')

@section('page-title', 'Explore Our Rooms')

@section('page-subtitle', 'Search, filter and choose your perfect stay.')

@section('content')

<div class="bg-slate-950 text-white rounded-[2rem] p-8 mb-8">
    <div class="grid lg:grid-cols-2 gap-6 items-center">
        <div>
            <h2 class="text-3xl font-extrabold mb-3">
                Find your next stay.
            </h2>

            <p class="text-slate-300">
                Browse premium hotel rooms, check availability, and continue your booking journey easily.
            </p>
        </div>

        <div class="bg-white/10 p-6 rounded-3xl">
            <p class="text-slate-300">Available Room Types</p>
            <h3 class="text-4xl font-extrabold text-amber-400">
                {{ $roomTypes->count() }}
            </h3>
        </div>
    </div>
</div>

<form method="GET" class="bg-white p-5 rounded-3xl shadow mb-8 grid md:grid-cols-4 gap-4">
    <input type="text"
           id="searchInput"
           name="search"
           value="{{ request('search') }}"
           placeholder="Search room..."
           class="border rounded-2xl px-4 py-3">

    <select id="typeFilter" name="type" class="border rounded-2xl px-4 py-3">
        <option value="">All Types</option>
        @foreach($roomTypes as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>

    <select id="statusFilter" name="status" class="border rounded-2xl px-4 py-3">
        <option value="">All Status</option>
        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
        <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
    </select>

    <button type="button"
            id="resetBtn"
            class="bg-slate-950 text-white rounded-2xl font-bold">
        Reset
    </button>
</form>

<div id="roomsGrid" class="grid md:grid-cols-2 xl:grid-cols-3 gap-8">
    @forelse($rooms as $room)
        <div class="bg-white rounded-[2rem] shadow overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="relative">
                <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                     class="h-64 w-full object-cover">

                <span class="absolute top-4 right-4 px-4 py-2 rounded-full text-sm font-semibold
                    {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                    {{ ucfirst($room->status) }}
                </span>
            </div>

            <div class="p-6">
                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="text-2xl font-extrabold">
                            {{ $room->room_type }}
                        </h3>

                        <p class="text-slate-500">
                            Room No: {{ $room->room_number }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="text-amber-500 font-bold">★★★★★</p>
                        <p class="text-xs text-slate-500">4.8 Rating</p>
                    </div>
                </div>

                <p class="text-slate-600 mb-4">
                    {{ Str::limit($room->description, 90) }}
                </p>

                <div class="flex flex-wrap gap-2 mb-5">
                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                        {{ $room->capacity }} Guests
                    </span>

                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                        Free WiFi
                    </span>

                    <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                        Breakfast
                    </span>
                </div>

                <p class="text-amber-500 font-extrabold text-xl mb-5">
                    Rs. {{ number_format($room->price_per_night, 2) }} / night
                </p>

                <a href="{{ route('rooms.details', $room->id) }}"
                   class="bg-slate-950 text-white px-5 py-3 rounded-xl font-bold inline-block hover:bg-slate-800 transition">
                    View Details
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-3 bg-white p-10 rounded-3xl shadow text-center">
            <h3 class="text-2xl font-bold mb-2">No rooms found</h3>
            <p class="text-slate-500">Try changing your search or filter options.</p>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $rooms->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const searchInput = document.getElementById('searchInput');
const typeFilter = document.getElementById('typeFilter');
const statusFilter = document.getElementById('statusFilter');
const roomsGrid = document.getElementById('roomsGrid');
const resetBtn = document.getElementById('resetBtn');

function loadRooms() {
    const search = searchInput.value;
    const type = typeFilter.value;
    const status = statusFilter.value;

    roomsGrid.innerHTML = `
        <div class="col-span-3 text-center py-10 text-slate-500 bg-white rounded-3xl shadow">
            Loading rooms...
        </div>
    `;

    fetch(`{{ route('ajax.rooms') }}?search=${encodeURIComponent(search)}&type=${encodeURIComponent(type)}&status=${encodeURIComponent(status)}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        roomsGrid.innerHTML = '';

        if (data.rooms.length === 0) {
            roomsGrid.innerHTML = `
                <div class="col-span-3 bg-white p-10 rounded-3xl shadow text-center">
                    <h3 class="text-2xl font-bold mb-2">No rooms found</h3>
                    <p class="text-slate-500">Try changing your search or filter options.</p>
                </div>
            `;
            return;
        }

        data.rooms.forEach(room => {
            let image = room.image
                ? `/storage/${room.image}`
                : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80';

            let statusClass = '';

            if (room.status === 'available') statusClass = 'bg-green-100 text-green-700';
            if (room.status === 'occupied') statusClass = 'bg-red-100 text-red-700';
            if (room.status === 'maintenance') statusClass = 'bg-yellow-100 text-yellow-700';

            roomsGrid.innerHTML += `
                <div class="bg-white rounded-[2rem] shadow overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="relative">
                        <img src="${image}" class="h-64 w-full object-cover">

                        <span class="absolute top-4 right-4 px-4 py-2 rounded-full text-sm font-semibold ${statusClass}">
                            ${room.status.charAt(0).toUpperCase() + room.status.slice(1)}
                        </span>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="text-2xl font-extrabold">${room.room_type}</h3>
                                <p class="text-slate-500">Room No: ${room.room_number}</p>
                            </div>

                            <div class="text-right">
                                <p class="text-amber-500 font-bold">★★★★★</p>
                                <p class="text-xs text-slate-500">4.8 Rating</p>
                            </div>
                        </div>

                        <p class="text-slate-600 mb-4">
                            ${room.description ? room.description.substring(0, 90) : ''}
                        </p>

                        <div class="flex flex-wrap gap-2 mb-5">
                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                                ${room.capacity} Guests
                            </span>

                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                                Free WiFi
                            </span>

                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm">
                                Breakfast
                            </span>
                        </div>

                        <p class="text-amber-500 font-extrabold text-xl mb-5">
                            Rs. ${Number(room.price_per_night).toLocaleString()} / night
                        </p>

                        <a href="/rooms/${room.id}"
                           class="bg-slate-950 text-white px-5 py-3 rounded-xl font-bold inline-block hover:bg-slate-800 transition">
                            View Details
                        </a>
                    </div>
                </div>
            `;
        });
    })
    .catch(() => {
        Swal.fire('Error', 'Failed to load rooms.', 'error');
    });
}

searchInput.addEventListener('keyup', loadRooms);
typeFilter.addEventListener('change', loadRooms);
statusFilter.addEventListener('change', loadRooms);

resetBtn.addEventListener('click', function () {
    searchInput.value = '';
    typeFilter.value = '';
    statusFilter.value = '';
    loadRooms();
});
</script>
@endpush