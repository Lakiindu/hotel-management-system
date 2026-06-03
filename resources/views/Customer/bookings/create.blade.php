<!DOCTYPE html>
<html>
<head>
    <title>Book Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="max-w-5xl mx-auto py-10 px-6">
    <div class="grid md:grid-cols-2 gap-8">

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                 class="h-80 w-full object-cover">

            <div class="p-6">
                <h2 class="text-3xl font-bold">{{ $room->room_type }}</h2>
                <p class="text-slate-500">Room No: {{ $room->room_number }}</p>
                <p class="text-amber-500 text-2xl font-bold mt-4">
                    Rs. {{ number_format($room->price_per_night, 2) }} / night
                </p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">
            <h1 class="text-3xl font-bold mb-6">Book This Room</h1>

            @if(session('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('customer.bookings.store', $room->id) }}">
                @csrf

                <label class="font-semibold">Check-In Date</label>
                <input type="date" name="check_in_date" class="w-full border p-3 rounded-xl mb-4" required>

                <label class="font-semibold">Check-Out Date</label>
                <input type="date" name="check_out_date" class="w-full border p-3 rounded-xl mb-4" required>

                <label class="font-semibold">Guests</label>
                <input type="number" name="guests" min="1" max="{{ $room->capacity }}"
                       class="w-full border p-3 rounded-xl mb-4" required>

                <label class="font-semibold">Special Requests</label>
                <textarea name="special_requests" rows="4"
                          class="w-full border p-3 rounded-xl mb-5"
                          placeholder="Any special requests?"></textarea>

                <button class="bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold">
                    Submit Booking
                </button>

                <a href="{{ route('rooms.details', $room->id) }}" class="ml-3 text-slate-500">
                    Cancel
                </a>
            </form>
        </div>

    </div>
</div>

</body>
</html>