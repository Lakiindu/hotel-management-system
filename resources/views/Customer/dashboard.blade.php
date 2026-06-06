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
    .glass {
        background: rgba(255,255,255,0.86);
        backdrop-filter: blur(18px);
    }
</style>

<section class="bg-slate-950 text-white rounded-[2rem] p-8 mb-8 relative overflow-hidden">
    <div class="relative z-10 grid lg:grid-cols-2 gap-8 items-center">

        <div>
            <h3 class="text-3xl font-extrabold mb-3">
                Your stay, simplified.
            </h3>

            <p class="text-slate-300 mb-6">
                Browse luxury rooms, track booking progress, manage payments and view invoices easily.
            </p>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('rooms') }}"
                   class="bg-amber-400 text-slate-950 px-6 py-3 rounded-full font-bold hover:bg-amber-300 transition">
                    Book a Room
                </a>

                <a href="{{ route('customer.bookings.index') }}"
                   class="bg-white/10 px-6 py-3 rounded-full font-bold hover:bg-white/20 transition">
                    View Bookings
                </a>
            </div>
        </div>

        <div class="glass text-slate-900 p-6 rounded-3xl shadow">
            @if($nextStay)
                <p class="text-slate-500 font-semibold">Upcoming Stay</p>

                <h3 class="text-3xl font-extrabold mt-2">
                    {{ $nextStay->room->room_type }}
                </h3>

                <div class="grid grid-cols-2 gap-4 mt-5">
                    <div class="bg-white/70 p-4 rounded-2xl">
                        <p class="text-slate-500 text-sm">Check-In</p>
                        <p class="font-bold">{{ $nextStay->check_in_date->format('Y-m-d') }}</p>
                    </div>

                    <div class="bg-white/70 p-4 rounded-2xl">
                        <p class="text-slate-500 text-sm">Nights</p>
                        <p class="font-bold">{{ $nextStayNights }}</p>
                    </div>

                    <div class="bg-white/70 p-4 rounded-2xl">
                        <p class="text-slate-500 text-sm">Guests</p>
                        <p class="font-bold">{{ $nextStay->guests }}</p>
                    </div>

                    <div class="bg-white/70 p-4 rounded-2xl">
                        <p class="text-slate-500 text-sm">Status</p>
                        <p class="font-bold text-green-600">
                            {{ ucwords(str_replace('_', ' ', $nextStay->status)) }}
                        </p>
                    </div>
                </div>

                @if($nextStayDaysLeft !== null && $nextStayDaysLeft >= 0)
                    <p class="mt-5 text-sm text-slate-600">
                        Your stay starts in
                        <span class="font-extrabold text-slate-950">
                            {{ $nextStayDaysLeft }} day{{ $nextStayDaysLeft == 1 ? '' : 's' }}
                        </span>.
                    </p>
                @endif
            @else
                <p class="text-slate-500 font-semibold">No upcoming stay</p>

                <h3 class="text-3xl font-extrabold mt-2">
                    Book your next luxury experience.
                </h3>

                <p class="text-slate-600 mt-3">
                    Explore available rooms and submit a booking request in a few clicks.
                </p>

                <a href="{{ route('rooms') }}"
                   class="inline-block mt-5 bg-slate-950 text-white px-5 py-3 rounded-xl font-bold hover:bg-slate-800 transition">
                    Browse Rooms
                </a>
            @endif
        </div>

    </div>
</section>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Total Bookings</p>
            <i data-lucide="calendar-days" class="text-blue-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-blue-600">{{ $totalBookings }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Pending</p>
            <i data-lucide="clock" class="text-yellow-500"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-yellow-500">{{ $pendingBookings }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Upcoming</p>
            <i data-lucide="bed-double" class="text-green-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-green-600">{{ $upcomingStays }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Completed</p>
            <i data-lucide="badge-check" class="text-purple-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-purple-600">{{ $completedStays }}</h3>
    </div>

</div>

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
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50 hover:bg-slate-100 transition">

                    <div class="flex items-center gap-4">
                        <img src="{{ $booking->room->image ? asset('storage/' . $booking->room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                             class="w-16 h-16 rounded-2xl object-cover">

                        <div>
                            <h4 class="font-bold text-lg">
                                {{ $booking->room->room_type }}
                            </h4>

                            <p class="text-sm text-slate-500">
                                Booking #{{ $booking->id }}
                            </p>

                            <p class="text-sm text-slate-500">
                                {{ $booking->check_in_date->format('Y-m-d') }}
                                to
                                {{ $booking->check_out_date->format('Y-m-d') }}
                            </p>
                        </div>
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
                <div class="bg-slate-50 p-8 rounded-3xl text-center">
                    <p class="text-slate-500 mb-4">
                        No bookings yet.
                    </p>

                    <a href="{{ route('rooms') }}"
                       class="bg-slate-950 text-white px-5 py-3 rounded-xl inline-block">
                        Browse Rooms
                    </a>
                </div>
            @endforelse
        </div>
    </div>

    <div class="space-y-8">

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

                    <p class="text-sm text-slate-600">Nights</p>
                    <p class="font-bold mb-3">
                        {{ $nextStayNights }}
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

        <div class="bg-white rounded-3xl shadow p-6">
            <h3 class="text-2xl font-bold mb-4">
                Payment Summary
            </h3>

            <div class="bg-slate-50 p-5 rounded-2xl">
                <p class="text-slate-500">Pending Payment</p>

                <p class="text-3xl font-extrabold {{ $pendingPaymentAmount > 0 ? 'text-red-500' : 'text-green-600' }}">
                    Rs. {{ number_format($pendingPaymentAmount, 2) }}
                </p>

                <a href="{{ route('customer.payments.index') }}"
                   class="inline-block mt-4 bg-slate-950 text-white px-5 py-3 rounded-xl">
                    Manage Payments
                </a>
            </div>
        </div>

    </div>

</div>

@endsection