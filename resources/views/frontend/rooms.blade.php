@extends('layouts.customer')

@section('title', 'Browse Rooms')

@section('page-title', 'Explore Our Rooms')

@section('page-subtitle', 'Search, filter and choose your perfect stay.')

@section('content')

<div class="relative overflow-hidden rounded-[2rem] bg-slate-950 text-white p-8 md:p-12 mb-8 shadow-2xl">
    <div class="absolute inset-0 opacity-30 bg-cover bg-center"
         style="background-image: url('https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=1600&q=80');">
    </div>

    <div class="absolute inset-0 bg-gradient-to-r from-slate-950 via-slate-950/90 to-slate-950/40"></div>

    <div class="relative grid lg:grid-cols-2 gap-8 items-center">
        <div>
            <p class="text-amber-400 font-bold uppercase tracking-widest mb-3">
                RoyalStay Rooms
            </p>

            <h2 class="text-4xl md:text-5xl font-black mb-4">
                Find your perfect stay.
            </h2>

            <p class="text-slate-200 leading-8 max-w-xl">
                Browse luxury rooms, check availability, compare prices, and continue your booking journey easily.
            </p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white/10 backdrop-blur p-6 rounded-3xl border border-white/10">
                <p class="text-slate-300 text-sm">Room Types</p>
                <h3 class="text-4xl font-black text-amber-400">
                    {{ $roomTypes->count() }}
                </h3>
            </div>

            <div class="bg-white/10 backdrop-blur p-6 rounded-3xl border border-white/10">
                <p class="text-slate-300 text-sm">Available Rooms</p>
                <h3 class="text-4xl font-black text-green-400">
                    {{ $availableRooms ?? 0 }}
                </h3>
            </div>
        </div>
    </div>
</div>

<form method="GET"
      class="bg-white/90 backdrop-blur p-5 rounded-[2rem] shadow-lg mb-10 grid md:grid-cols-5 gap-4 border border-slate-100">

    <input type="text"
           id="searchInput"
           name="search"
           value="{{ request('search') }}"
           placeholder="Search room..."
           class="border border-slate-200 rounded-2xl px-4 py-4 outline-none focus:border-amber-400">

    <select id="typeFilter"
            name="type"
            class="border border-slate-200 rounded-2xl px-4 py-4 outline-none focus:border-amber-400">
        <option value="">All Types</option>
        @foreach($roomTypes as $type)
            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                {{ $type }}
            </option>
        @endforeach
    </select>

    <select id="statusFilter"
            name="status"
            class="border border-slate-200 rounded-2xl px-4 py-4 outline-none focus:border-amber-400">
        <option value="">All Status</option>
        <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
        <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
        <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
    </select>

    <select id="sortFilter"
            name="sort"
            class="border border-slate-200 rounded-2xl px-4 py-4 outline-none focus:border-amber-400">
        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price Low → High</option>
        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price High → Low</option>
        <option value="type" {{ request('sort') == 'type' ? 'selected' : '' }}>Room Type</option>
    </select>

    <button type="button"
            id="resetBtn"
            class="bg-slate-950 text-white rounded-2xl font-bold hover:bg-amber-400 hover:text-slate-950 transition">
        Reset
    </button>
</form>

<div id="roomsGrid" class="grid md:grid-cols-2 xl:grid-cols-3 gap-10">
    @forelse($rooms as $room)

        <div class="group bg-white rounded-[2rem] shadow-lg overflow-hidden hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 border border-slate-100">

            <div class="relative overflow-hidden">
                <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                     class="h-72 w-full object-cover group-hover:scale-110 transition duration-700"
                     alt="{{ $room->room_type }}">

                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-500"></div>

                @if($room->price_per_night >= 30000)
                    <div class="absolute top-5 left-5 bg-red-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                        Featured
                    </div>
                @endif

                <span class="absolute top-5 right-5 px-4 py-2 rounded-full text-sm font-bold shadow
                    {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                    {{ ucfirst($room->status) }}
                </span>

                <div class="absolute bottom-5 left-5 bg-amber-400 text-slate-950 px-5 py-3 rounded-full font-black shadow-lg">
                    Rs. {{ number_format($room->price_per_night, 0) }}
                </div>
            </div>

            <div class="p-7">
                <div class="flex justify-between items-start gap-4 mb-4">
                    <div>
                        <h3 class="text-3xl font-black text-slate-900">
                            {{ $room->room_type }}
                        </h3>

                        <p class="text-slate-500 mt-1">
                            Room No: {{ $room->room_number }}
                        </p>
                    </div>

                    <div class="text-right shrink-0">
                        <p class="text-amber-500 font-bold">★★★★★</p>
                        <p class="text-xs text-slate-500">4.8 Rating</p>
                    </div>
                </div>

                <p class="text-slate-600 leading-7 mb-5">
                    {{ Str::limit($room->description ?? 'Luxury room with premium comfort and facilities.', 120) }}
                </p>

                <div class="flex flex-wrap gap-2 mb-6">
                    <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                        <i class="fa-solid fa-user-group text-amber-500"></i>
                        {{ $room->capacity }} Guests
                    </span>

                    <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                        <i class="fa-solid fa-wifi text-amber-500"></i>
                        Free WiFi
                    </span>

                    <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                        <i class="fa-solid fa-mug-hot text-amber-500"></i>
                        Breakfast
                    </span>
                </div>

                <div class="flex items-center justify-between gap-4">
                    <div>
                        <p class="text-2xl text-amber-500 font-black">
                            Rs. {{ number_format($room->price_per_night, 2) }}
                        </p>
                        <p class="text-slate-500">/ night</p>
                    </div>

                    <a href="{{ route('rooms.details', $room->id) }}"
                       class="bg-amber-400 text-slate-950 px-6 py-3 rounded-full font-black inline-block hover:bg-amber-500 hover:scale-105 transition">
                        View Details
                    </a>
                </div>
            </div>
        </div>

    @empty

        <div class="md:col-span-2 xl:col-span-3 bg-white p-12 rounded-[2rem] shadow text-center">
            <h3 class="text-3xl font-black mb-3">No rooms found</h3>
            <p class="text-slate-500">Try changing your search or filter options.</p>
        </div>

    @endforelse
</div>

<div class="mt-12">
    {{ $rooms->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const searchInput = document.getElementById('searchInput');
const typeFilter = document.getElementById('typeFilter');
const statusFilter = document.getElementById('statusFilter');
const sortFilter = document.getElementById('sortFilter');
const roomsGrid = document.getElementById('roomsGrid');
const resetBtn = document.getElementById('resetBtn');

function limitText(text, limit = 120) {
    if (!text) return 'Luxury room with premium comfort and facilities.';
    return text.length > limit ? text.substring(0, limit) + '...' : text;
}

function formatPrice(price) {
    return Number(price).toLocaleString(undefined, {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    });
}

function statusClass(status) {
    if (status === 'available') return 'bg-green-100 text-green-700';
    if (status === 'occupied') return 'bg-red-100 text-red-700';
    if (status === 'maintenance') return 'bg-yellow-100 text-yellow-700';
    return 'bg-slate-100 text-slate-700';
}

function capitalize(text) {
    if (!text) return '';
    return text.charAt(0).toUpperCase() + text.slice(1);
}

function featuredRibbon(price) {
    return Number(price) >= 30000
        ? `<div class="absolute top-5 left-5 bg-red-500 text-white px-4 py-2 rounded-full text-xs font-bold shadow-lg">
                Featured
           </div>`
        : '';
}

function loadRooms() {
    const search = searchInput.value;
    const type = typeFilter.value;
    const status = statusFilter.value;
    const sort = sortFilter.value;

    roomsGrid.innerHTML = `
        <div class="md:col-span-2 xl:col-span-3 text-center py-12 text-slate-500 bg-white rounded-[2rem] shadow">
            Loading rooms...
        </div>
    `;

    fetch(`{{ route('ajax.rooms') }}?search=${encodeURIComponent(search)}&type=${encodeURIComponent(type)}&status=${encodeURIComponent(status)}&sort=${encodeURIComponent(sort)}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        roomsGrid.innerHTML = '';

        if (data.rooms.length === 0) {
            roomsGrid.innerHTML = `
                <div class="md:col-span-2 xl:col-span-3 bg-white p-12 rounded-[2rem] shadow text-center">
                    <h3 class="text-3xl font-black mb-3">No rooms found</h3>
                    <p class="text-slate-500">Try changing your search or filter options.</p>
                </div>
            `;
            return;
        }

        data.rooms.forEach(room => {
            let image = room.image
                ? `/storage/${room.image}`
                : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80';

            roomsGrid.innerHTML += `
                <div class="group bg-white rounded-[2rem] shadow-lg overflow-hidden hover:-translate-y-2 hover:shadow-2xl transition-all duration-500 border border-slate-100">

                    <div class="relative overflow-hidden">
                        <img src="${image}"
                             class="h-72 w-full object-cover group-hover:scale-110 transition duration-700"
                             alt="${room.room_type}">

                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-500"></div>

                        ${featuredRibbon(room.price_per_night)}

                        <span class="absolute top-5 right-5 px-4 py-2 rounded-full text-sm font-bold shadow ${statusClass(room.status)}">
                            ${capitalize(room.status)}
                        </span>

                        <div class="absolute bottom-5 left-5 bg-amber-400 text-slate-950 px-5 py-3 rounded-full font-black shadow-lg">
                            Rs. ${Number(room.price_per_night).toLocaleString()}
                        </div>
                    </div>

                    <div class="p-7">
                        <div class="flex justify-between items-start gap-4 mb-4">
                            <div>
                                <h3 class="text-3xl font-black text-slate-900">
                                    ${room.room_type}
                                </h3>

                                <p class="text-slate-500 mt-1">
                                    Room No: ${room.room_number}
                                </p>
                            </div>

                            <div class="text-right shrink-0">
                                <p class="text-amber-500 font-bold">★★★★★</p>
                                <p class="text-xs text-slate-500">4.8 Rating</p>
                            </div>
                        </div>

                        <p class="text-slate-600 leading-7 mb-5">
                            ${limitText(room.description)}
                        </p>

                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                                <i class="fa-solid fa-user-group text-amber-500"></i>
                                ${room.capacity} Guests
                            </span>

                            <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                                <i class="fa-solid fa-wifi text-amber-500"></i>
                                Free WiFi
                            </span>

                            <span class="bg-slate-100 text-slate-700 px-4 py-2 rounded-full text-sm flex items-center gap-2">
                                <i class="fa-solid fa-mug-hot text-amber-500"></i>
                                Breakfast
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <p class="text-2xl text-amber-500 font-black">
                                    Rs. ${formatPrice(room.price_per_night)}
                                </p>
                                <p class="text-slate-500">/ night</p>
                            </div>

                            <a href="/rooms/${room.id}"
                               class="bg-amber-400 text-slate-950 px-6 py-3 rounded-full font-black inline-block hover:bg-amber-500 hover:scale-105 transition">
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
sortFilter.addEventListener('change', loadRooms);

resetBtn.addEventListener('click', function () {
    searchInput.value = '';
    typeFilter.value = '';
    statusFilter.value = '';
    sortFilter.value = 'newest';
    window.location.href = "{{ route('rooms') }}";
});
</script>
@endpush