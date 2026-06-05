@extends('layouts.customer')

@section('title', 'Dashboard')

@section('page-title')
Welcome back, {{ auth()->user()->name }} 👋
@endsection

@section('page-subtitle')
Manage your bookings, payments, stays and profile from one place.
@endsection

@section('content')

<style>
    .glass{
        background: rgba(255,255,255,0.82);
        backdrop-filter: blur(18px);
    }
</style>

<!-- Hero Summary -->
<section class="bg-slate-950 text-white rounded-[2rem] p-8 mb-8 relative overflow-hidden">

    <div class="relative z-10 grid lg:grid-cols-2 gap-6 items-center">
        <div>
            <h3 class="text-3xl font-extrabold mb-3">
                Your stay, simplified.
            </h3>

            <p class="text-slate-300 mb-6">
                Browse luxury rooms, track booking progress, manage payments and view invoices easily.
            </p>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('rooms') }}"
                   class="bg-amber-400 text-slate-950 px-6 py-3 rounded-full font-bold">
                    Book a Room
                </a>

                <a href="{{ route('customer.bookings.index') }}"
                   class="bg-white/10 px-6 py-3 rounded-full font-bold">
                    View Bookings
                </a>
            </div>
        </div>

        <div class="glass text-slate-900 p-6 rounded-3xl">
            <p class="text-slate-500">Pending Payment</p>

            <h3 class="text-4xl font-extrabold text-red-500">
                Rs. {{ number_format($pendingPaymentAmount, 2) }}
            </h3>

            <a href="{{ route('customer.payments.index') }}"
               class="inline-block mt-4 bg-slate-950 text-white px-5 py-3 rounded-xl">
                Manage Payments
            </a>
        </div>
    </div>

</section>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <p class="text-slate-500">Total Bookings</p>
        <h3 class="text-4xl font-extrabold text-blue-600">{{ $totalBookings }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <p class="text-slate-500">Pending</p>
        <h3 class="text-4xl font-extrabold text-yellow-500">{{ $pendingBookings }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <p class="text-slate-500">Upcoming</p>
        <h3 class="text-4xl font-extrabold text-green-600">{{ $upcomingStays }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <p class="text-slate-500">Completed</p>
        <h3 class="text-4xl font-extrabold text-purple-600">{{ $completedStays }}</h3>
    </div>

</div>

<!-- Main Widgets -->
<div class="grid lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 bg-white rounded-3xl shadow p-6">

        <div class="flex justify-between items-center mb-6">
            <h3 class="text-2xl font-bold">Recent Bookings</h3>

            <a href="{{ route('customer.bookings.index') }}"
               class="text-amber-500 font-bold">
                View All
            </a>
        </div>

        <div class="space-y-4">

            @forelse($recentBookings as $booking)

                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50">

                    <div>
                        <h4 class="font-bold text-lg">
                            {{ $booking->room->room_type }}
                        </h4>

                        <p class="text-sm text-slate-500">
                            {{ $booking->check_in_date->format('Y-m-d') }}
                            to
                            {{ $booking->check_out_date->format('Y-m-d') }}
                        </p>
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

            @empty

                <p class="text-slate-500">
                    No bookings yet.
                </p>

            @endforelse

        </div>

    </div>

    <div class="bg-white rounded-3xl shadow p-6">

        <h3 class="text-2xl font-bold mb-6">
            Next Stay
        </h3>

        @if($nextStay)

            <div class="bg-amber-100 rounded-3xl p-6">

                <p class="text-slate-500 mb-2">Room</p>

                <h4 class="text-2xl font-extrabold mb-4">
                    {{ $nextStay->room->room_type }}
                </h4>

                <p class="text-sm text-slate-600">Check-In</p>

                <p class="font-bold mb-3">
                    {{ $nextStay->check_in_date->format('Y-m-d') }}
                </p>

                <p class="text-sm text-slate-600">Guests</p>

                <p class="font-bold">
                    {{ $nextStay->guests }}
                </p>

            </div>

        @else

            <div class="bg-slate-100 rounded-3xl p-6 text-center">

                <p class="text-slate-500 mb-4">
                    No upcoming stay yet.
                </p>

                <a href="{{ route('rooms') }}"
                   class="bg-slate-950 text-white px-5 py-3 rounded-xl inline-block">
                    Browse Rooms
                </a>

            </div>

        @endif

    </div>

</div>

@endsection