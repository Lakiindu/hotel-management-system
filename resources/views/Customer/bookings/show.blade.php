@extends('layouts.customer')

@section('title', 'Booking Details')
@section('page-title', 'Booking Details')
@section('page-subtitle', 'View your booking summary and status timeline.')

@section('content')

<a href="{{ route('customer.bookings.index') }}" class="inline-block text-slate-500 hover:text-slate-950 mb-6">
    ← Back to My Bookings
</a>

<div class="grid lg:grid-cols-2 gap-8">

    <div class="bg-white rounded-[2rem] shadow overflow-hidden">
        <img src="{{ $booking->room->image ? asset('storage/' . $booking->room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
             class="h-[430px] w-full object-cover">

        <div class="p-8">
            <h1 class="text-4xl font-extrabold">{{ $booking->room->room_type }}</h1>
            <p class="text-slate-500 mt-2">Room No: {{ $booking->room->room_number }}</p>

            <p class="text-3xl font-extrabold text-amber-500 mt-6">
                Rs. {{ number_format($booking->total_amount, 2) }}
            </p>
        </div>
    </div>

    <div class="space-y-6">

        <div class="bg-white rounded-[2rem] shadow p-8">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-amber-500 font-bold uppercase tracking-widest">Booking</p>
                    <h2 class="text-3xl font-extrabold">Details #{{ $booking->id }}</h2>
                </div>

                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $booking->status == 'checked_in' ? 'bg-purple-100 text-purple-700' : '' }}
                    {{ $booking->status == 'checked_out' ? 'bg-indigo-100 text-indigo-700' : '' }}
                    {{ $booking->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}">
                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-50 p-5 rounded-2xl">
                    <p class="text-slate-500">Check-In</p>
                    <p class="font-bold">{{ $booking->check_in_date->format('Y-m-d') }}</p>
                </div>

                <div class="bg-slate-50 p-5 rounded-2xl">
                    <p class="text-slate-500">Check-Out</p>
                    <p class="font-bold">{{ $booking->check_out_date->format('Y-m-d') }}</p>
                </div>

                <div class="bg-slate-50 p-5 rounded-2xl">
                    <p class="text-slate-500">Guests</p>
                    <p class="font-bold">{{ $booking->guests }}</p>
                </div>

                <div class="bg-slate-50 p-5 rounded-2xl">
                    <p class="text-slate-500">Amount</p>
                    <p class="font-bold">Rs. {{ number_format($booking->total_amount, 2) }}</p>
                </div>
            </div>

            <div class="bg-slate-50 p-5 rounded-2xl mt-4">
                <p class="text-slate-500">Special Requests</p>
                <p class="font-semibold">{{ $booking->special_requests ?? 'No special requests' }}</p>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow p-8">
            <h2 class="text-2xl font-extrabold mb-6">Booking Timeline</h2>

            @php
                $steps = ['pending', 'approved', 'checked_in', 'checked_out', 'completed'];
                $currentIndex = array_search($booking->status, $steps);
            @endphp

            @if($booking->status === 'cancelled')
                <div class="bg-red-100 text-red-700 p-5 rounded-2xl font-semibold">
                    This booking has been cancelled.
                </div>
            @else
                <div class="space-y-5">
                    @foreach($steps as $index => $step)
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold
                                {{ $index <= $currentIndex ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-500' }}">
                                {{ $index <= $currentIndex ? '✓' : $index + 1 }}
                            </div>

                            <div>
                                <p class="font-bold {{ $index <= $currentIndex ? 'text-slate-900' : 'text-slate-400' }}">
                                    {{ ucwords(str_replace('_', ' ', $step)) }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    {{ $index <= $currentIndex ? 'Step completed' : 'Waiting for update' }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

</div>

@endsection