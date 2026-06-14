@extends('layouts.customer')

@section('title', $room->room_type)

@section('page-title', $room->room_type)

@section('page-subtitle', 'View room details, facilities and booking options.')

@section('content')

<div class="grid lg:grid-cols-2 gap-8">

    <div class="bg-white rounded-[2rem] shadow overflow-hidden">
        <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
             class="w-full h-[460px] object-cover">

        <div class="p-6">
            <p class="text-slate-500">Room Number</p>
            <h2 class="text-2xl font-extrabold">{{ $room->room_number }}</h2>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2rem] shadow">

        <div class="flex justify-between items-start gap-4 mb-6">
            <div>
                <h1 class="text-4xl font-extrabold mb-2">
                    {{ $room->room_type }}
                </h1>

                <p class="text-slate-500">
                    Perfect stay for up to {{ $room->capacity }} guests.
                </p>
            </div>

            <span class="px-4 py-2 rounded-full text-sm font-semibold
                {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                {{ ucfirst($room->status) }}
            </span>
        </div>

        <p class="text-slate-600 leading-8 mb-6">
            {{ $room->description }}
        </p>

        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="bg-slate-50 p-5 rounded-2xl">
                <p class="text-slate-500">Price Per Night</p>
                <h3 class="text-2xl font-extrabold text-amber-500">
                    Rs. {{ number_format($room->price_per_night, 2) }}
                </h3>
            </div>

            <div class="bg-slate-50 p-5 rounded-2xl">
                <p class="text-slate-500">Capacity</p>
                <h3 class="text-2xl font-extrabold">
                    {{ $room->capacity }} Guests
                </h3>
            </div>
        </div>

        <div class="mb-8">
            <h3 class="text-xl font-extrabold mb-4">Facilities</h3>

            <div class="flex flex-wrap gap-2">
                @if(is_array($room->facilities) && count($room->facilities) > 0)
                    @foreach($room->facilities as $facility)
                        <span class="bg-slate-100 px-4 py-2 rounded-full text-sm font-semibold">
                            {{ $facility }}
                        </span>
                    @endforeach
                @else
                    <p class="text-slate-500">No facilities added.</p>
                @endif
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            @auth
                @if(auth()->user()->role === 'customer')
                    @if($room->status === 'available')
                        <a href="{{ route('customer.bookings.create', $room->id) }}"
                           class="bg-amber-400 text-slate-950 px-7 py-3 rounded-2xl font-bold">
                            Book This Room
                        </a>
                    @else
                        <button disabled
                                class="bg-slate-300 text-slate-500 px-7 py-3 rounded-2xl font-bold cursor-not-allowed">
                            Not Available
                        </button>
                    @endif
                @else
                    <p class="text-slate-500">Admin cannot book rooms.</p>
                @endif
            @else
                <a href="{{ route('login') }}"
                   class="bg-amber-400 text-slate-950 px-7 py-3 rounded-2xl font-bold">
                    Login to Book
                </a>
            @endauth

            <a href="{{ route('home') . '#rooms' }}"
               class="bg-slate-950 text-white px-7 py-3 rounded-2xl font-bold">
                Back to Featured Rooms
            </a>
        </div>

    </div>

</div>

@endsection