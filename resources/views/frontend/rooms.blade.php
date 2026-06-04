<!DOCTYPE html>
<html>
<head>
    <title>Rooms</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-100 text-slate-900">

<div class="flex min-h-screen">

    @auth
        @if(auth()->user()->role === 'customer')
            <aside class="w-72 bg-slate-950 text-white p-6 hidden lg:flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-extrabold mb-10">
                        RoyalStay<span class="text-amber-400">.</span>
                    </h1>

                    <nav class="space-y-3">
                        <a href="{{ route('customer.dashboard') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">
                            Dashboard
                        </a>

                        <a href="{{ route('rooms') }}" class="block bg-amber-400 text-slate-950 px-5 py-3 rounded-2xl font-bold">
                            Browse Rooms
                        </a>

                        <a href="{{ route('customer.bookings.index') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">
                            My Bookings
                        </a>

                        <a href="{{ route('customer.payments.index') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">
                            Payments
                        </a>

                        <a href="{{ route('customer.profile.edit') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">
                            Profile
                        </a>
                    </nav>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-red-500 text-white px-5 py-3 rounded-2xl font-bold hover:bg-red-600">
                        Logout
                    </button>
                </form>
            </aside>
        @endif
    @else
        <div class="hidden"></div>
    @endauth

    <main class="flex-1">

        @guest
            <header class="bg-slate-950 text-white px-8 py-5 flex justify-between">
                <a href="{{ route('home') }}" class="text-2xl font-bold">
                    RoyalStay<span class="text-amber-400">.</span>
                </a>

                <nav class="space-x-5">
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('rooms') }}" class="text-amber-400">Rooms</a>
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}" class="bg-amber-400 text-slate-950 px-4 py-2 rounded-full">Register</a>
                </nav>
            </header>
        @endguest

        <section class="p-6 lg:p-10">

            <div class="flex flex-col lg:flex-row justify-between gap-6 items-start lg:items-center mb-8">
                <div>
                    <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
                        {{ auth()->check() && auth()->user()->role === 'customer' ? 'Customer Portal' : 'Luxury Rooms' }}
                    </p>

                    <h1 class="text-4xl font-extrabold text-slate-900">
                        Explore Our Rooms
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Search, filter and choose your perfect stay.
                    </p>
                </div>

                @auth
                    @if(auth()->user()->role === 'customer')
                        <div class="flex items-center gap-4 bg-white p-4 rounded-3xl shadow">
                            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                                 class="w-14 h-14 rounded-full object-cover border-2 border-amber-400">

                            <div>
                                <p class="font-bold">{{ auth()->user()->name }}</p>
                                <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>

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
                        <p class="text-slate-300">Available room types</p>
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

                <select id="typeFilter"
                        name="type"
                        class="border rounded-2xl px-4 py-3">
                    <option value="">All Types</option>
                    @foreach($roomTypes as $type)
                        <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>

                <select id="statusFilter"
                        name="status"
                        class="border rounded-2xl px-4 py-3">
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
                    <div class="bg-white rounded-[2rem] shadow overflow-hidden hover:-translate-y-1 transition">
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
                            <h3 class="text-2xl font-extrabold mb-2">{{ $room->room_type }}</h3>

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
                                <a href="{{ route('rooms.details', $room->id) }}"
                                   class="bg-slate-950 text-white px-5 py-3 rounded-xl font-bold">
                                    View Details
                                </a>
                            </div>
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

        </section>

    </main>

</div>

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
                <div class="bg-white rounded-[2rem] shadow overflow-hidden hover:-translate-y-1 transition">
                    <div class="relative">
                        <img src="${image}" class="h-64 w-full object-cover">

                        <span class="absolute top-4 right-4 px-4 py-2 rounded-full text-sm font-semibold ${statusClass}">
                            ${room.status.charAt(0).toUpperCase() + room.status.slice(1)}
                        </span>
                    </div>

                    <div class="p-6">
                        <h3 class="text-2xl font-extrabold mb-2">${room.room_type}</h3>

                        <p class="text-slate-500 mb-4">
                            Room No: ${room.room_number}
                        </p>

                        <p class="text-slate-600 mb-4">
                            ${room.description ? room.description.substring(0, 90) : ''}
                        </p>

                        <p class="text-amber-500 font-extrabold text-xl mb-5">
                            Rs. ${Number(room.price_per_night).toLocaleString()} / night
                        </p>

                        <a href="/rooms/${room.id}"
                           class="bg-slate-950 text-white px-5 py-3 rounded-xl font-bold inline-block">
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

</body>
</html>