<!DOCTYPE html>
<html>
<head>
    <title>{{ $room->room_type }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10">

        <div>
            <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                 class="w-full h-[450px] object-cover rounded-3xl shadow">
        </div>

        <div class="bg-white p-8 rounded-3xl shadow">
            <h1 class="text-4xl font-extrabold mb-3">{{ $room->room_type }}</h1>

            <p class="text-slate-500 mb-3">
                Room Number: {{ $room->room_number }}
            </p>

            <p class="text-slate-600 leading-8 mb-6">
                {{ $room->description }}
            </p>

            <p class="text-amber-500 text-3xl font-extrabold mb-6">
                Rs. {{ number_format($room->price_per_night, 2) }}
                <span class="text-base text-slate-500 font-normal">/ night</span>
            </p>

            <p class="mb-4">
                <strong>Capacity:</strong> {{ $room->capacity }} Guests
            </p>

            <p class="mb-6">
                <strong>Status:</strong>
                <span class="px-3 py-1 rounded-full text-sm
                    {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                    {{ ucfirst($room->status) }}
                </span>
            </p>

            <div class="mb-8">
                <h3 class="font-bold mb-3">Facilities</h3>

                <div class="flex flex-wrap gap-2">
                    @if(is_array($room->facilities))
                        @foreach($room->facilities as $facility)
                            <span class="bg-slate-100 px-4 py-2 rounded-full text-sm">
                                {{ $facility }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>

            @auth
                @if(auth()->user()->role === 'customer')
                    <a href="{{ route('customer.bookings.create', $room->id) }}"
                     class="bg-amber-400 text-slate-950 px-7 py-3 rounded-full font-bold">
                     Book This Room
                    </a>
                @else
                    <p class="text-slate-500">Admin cannot book rooms.</p>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="bg-amber-400 text-slate-950 px-7 py-3 rounded-full font-bold">
                    Login to Book
                </a>
            @endauth
        </div>

    </div>
</section>

</body>
</html>