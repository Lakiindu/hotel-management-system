@extends('layouts.customer')

@section('title', 'Book Room')

@section('page-title', 'Book Room')

@section('page-subtitle', 'Choose your dates, guests and submit your booking request.')

@section('content')

<div class="grid lg:grid-cols-2 gap-8">

    <div class="bg-white rounded-[2rem] shadow overflow-hidden">
        <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
             class="h-[430px] w-full object-cover">

        <div class="p-8">
            <h2 class="text-3xl font-extrabold">
                {{ $room->room_type }}
            </h2>

            <p class="text-slate-500 mt-2">
                Room No: {{ $room->room_number }}
            </p>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div class="bg-slate-50 p-5 rounded-2xl">
                    <p class="text-slate-500">Price</p>
                    <p class="text-xl font-extrabold text-amber-500">
                        Rs. {{ number_format($room->price_per_night, 2) }}
                    </p>
                </div>

                <div class="bg-slate-50 p-5 rounded-2xl">
                    <p class="text-slate-500">Capacity</p>
                    <p class="text-xl font-extrabold">
                        {{ $room->capacity }} Guests
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2rem] shadow p-8">

        <h1 class="text-3xl font-extrabold mb-2">
            Complete Your Booking
        </h1>

        <p class="text-slate-500 mb-6">
            Your booking will be sent to admin for approval.
        </p>

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-5">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-5">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('customer.bookings.store', $room->id) }}">
            @csrf

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="font-semibold">Check-In Date</label>
                    <input type="date"
                           name="check_in_date"
                           class="w-full border p-3 rounded-xl mt-2"
                           required>
                </div>

                <div>
                    <label class="font-semibold">Check-Out Date</label>
                    <input type="date"
                           name="check_out_date"
                           class="w-full border p-3 rounded-xl mt-2"
                           required>
                </div>
            </div>

            <div class="mt-5">
                <label class="font-semibold">Guests</label>
                <input type="number"
                       name="guests"
                       min="1"
                       max="{{ $room->capacity }}"
                       class="w-full border p-3 rounded-xl mt-2"
                       required>
            </div>

            <div class="mt-5">
                <label class="font-semibold">Special Requests</label>
                <textarea name="special_requests"
                          rows="4"
                          class="w-full border p-3 rounded-xl mt-2"
                          placeholder="Any special requests?"></textarea>
            </div>

            <div class="flex flex-wrap gap-3 mt-6">
                <button class="bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold">
                    Submit Booking
                </button>

                <a href="{{ route('rooms.details', $room->id) }}"
                   class="bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-bold">
                    Cancel
                </a>
            </div>
        </form>
    </div>

</div>

@endsection