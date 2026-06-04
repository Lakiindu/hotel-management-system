<!DOCTYPE html>
<html>
<head>
    <title>Rooms</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100">

<header class="bg-slate-950 text-white px-8 py-5 flex justify-between">
    <a href="{{ route('home') }}" class="text-2xl font-bold">RoyalStay.</a>

    <nav class="space-x-5">
        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('rooms') }}" class="text-amber-400">Rooms</a>
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}" class="bg-amber-400 text-slate-950 px-4 py-2 rounded-full">Register</a>
    </nav>
</header>

<section class="py-16">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl font-extrabold mb-3">Explore Our Rooms</h1>
        <p class="text-slate-500 mb-8">Search, filter and choose your perfect stay.</p>

        <form method="GET" class="bg-white p-5 rounded-2xl shadow mb-8 grid md:grid-cols-4 gap-4">
            <input type="text"
                   id="searchInput"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search room..."
                   class="border rounded-xl px-4 py-3">

            <select id="typeFilter"
                    name="type"
                    class="border rounded-xl px-4 py-3">
                <option value="">All Types</option>
                @foreach($roomTypes as $type)
                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ $type }}
                    </option>
                @endforeach
            </select>

            <select id="statusFilter"
                    name="status"
                    class="border rounded-xl px-4 py-3">
                <option value="">All Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>

            <button type="button"
                    id="resetBtn"
                    class="bg-slate-950 text-white rounded-xl">
                Reset
            </button>
        </form>

        <div id="roomsGrid" class="grid md:grid-cols-3 gap-8">
            @forelse($rooms as $room)
                <div class="bg-white rounded-3xl shadow overflow-hidden hover:shadow-2xl transition">
                    <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                         class="h-60 w-full object-cover">

                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2">{{ $room->room_type }}</h3>

                        <p class="text-slate-500 mb-4">
                            Room No: {{ $room->room_number }}
                        </p>

                        <p class="text-slate-600 mb-4">
                            {{ Str::limit($room->description, 90) }}
                        </p>

                        <p class="text-amber-500 font-extrabold text-xl mb-5">
                            Rs. {{ number_format($room->price_per_night, 2) }} / night
                        </p>

                        <div class="flex justify-between items-center">
                            <span class="px-3 py-1 rounded-full text-sm
                                {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                {{ ucfirst($room->status) }}
                            </span>

                            <a href="{{ route('rooms.details', $room->id) }}"
                               class="bg-slate-950 text-white px-4 py-2 rounded-full">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-slate-500">No rooms found.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $rooms->links() }}
        </div>

    </div>
</section>

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
        <div class="col-span-3 text-center py-10 text-slate-500">
            Loading rooms...
        </div>
    `;

    fetch(`{{ route('ajax.rooms') }}?search=${search}&type=${type}&status=${status}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        roomsGrid.innerHTML = '';

        if (data.rooms.length === 0) {
            roomsGrid.innerHTML = `
                <p class="col-span-3 text-center text-slate-500">
                    No rooms found.
                </p>
            `;
            return;
        }

        data.rooms.forEach(room => {
            let image = room.image
                ? `/storage/${room.image}`
                : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80';

            let statusClass = '';

            if (room.status === 'available') {
                statusClass = 'bg-green-100 text-green-700';
            }

            if (room.status === 'occupied') {
                statusClass = 'bg-red-100 text-red-700';
            }

            if (room.status === 'maintenance') {
                statusClass = 'bg-yellow-100 text-yellow-700';
            }

            roomsGrid.innerHTML += `
                <div class="bg-white rounded-3xl shadow overflow-hidden hover:shadow-2xl transition">
                    <img src="${image}" class="h-60 w-full object-cover">

                    <div class="p-6">
                        <h3 class="text-2xl font-bold mb-2">${room.room_type}</h3>

                        <p class="text-slate-500 mb-4">
                            Room No: ${room.room_number}
                        </p>

                        <p class="text-slate-600 mb-4">
                            ${room.description ? room.description.substring(0, 90) : ''}
                        </p>

                        <p class="text-amber-500 font-extrabold text-xl mb-5">
                            Rs. ${Number(room.price_per_night).toLocaleString()} / night
                        </p>

                        <div class="flex justify-between items-center">
                            <span class="px-3 py-1 rounded-full text-sm ${statusClass}">
                                ${room.status.charAt(0).toUpperCase() + room.status.slice(1)}
                            </span>

                            <a href="/rooms/${room.id}"
                               class="bg-slate-950 text-white px-4 py-2 rounded-full">
                                View Details
                            </a>
                        </div>
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

</body>
</html>