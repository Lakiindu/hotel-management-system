@extends('layouts.customer')

@section('title', 'My Bookings')

@section('page-title', 'My Bookings')

@section('page-subtitle', 'Track your reservations, statuses and booking history.')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('rooms') }}"
       class="bg-amber-400 text-slate-950 px-6 py-3 rounded-2xl font-bold shadow hover:bg-amber-300 transition">
        + Browse Rooms
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
        {{ session('error') }}
    </div>
@endif

<div class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Total Bookings</p>
            <i data-lucide="calendar-days" class="text-blue-600"></i>
        </div>
        <h2 class="text-4xl font-extrabold text-blue-600">{{ $totalBookings }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Active Bookings</p>
            <i data-lucide="clock" class="text-amber-500"></i>
        </div>
        <h2 class="text-4xl font-extrabold text-amber-500">{{ $activeBookings }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Completed Stays</p>
            <i data-lucide="badge-check" class="text-green-600"></i>
        </div>
        <h2 class="text-4xl font-extrabold text-green-600">{{ $completedBookings }}</h2>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    @forelse($bookings as $booking)
        <div class="bg-white rounded-3xl shadow overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="grid md:grid-cols-3">

                <img src="{{ $booking->room->image ? asset('storage/' . $booking->room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                     class="h-full min-h-[240px] w-full object-cover">

                <div class="md:col-span-2 p-6">

                    <div class="flex justify-between items-start gap-4 mb-4">
                        <div>
                            <p class="text-sm text-amber-500 font-bold mb-1">
                                Booking #{{ $booking->id }}
                            </p>

                            <h2 class="text-2xl font-extrabold">
                                {{ $booking->room->room_type }}
                            </h2>

                            <p class="text-slate-500">
                                Room No: {{ $booking->room->room_number }}
                            </p>
                        </div>

                        <span class="px-3 py-1 rounded-full text-sm font-semibold
                            {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $booking->status == 'checked_in' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $booking->status == 'checked_out' ? 'bg-indigo-100 text-indigo-700' : '' }}
                            {{ $booking->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}">
                            {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-4 text-sm mb-5">
                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-slate-500">Check-In</p>
                            <p class="font-bold">{{ $booking->check_in_date->format('Y-m-d') }}</p>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-slate-500">Check-Out</p>
                            <p class="font-bold">{{ $booking->check_out_date->format('Y-m-d') }}</p>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-slate-500">Guests</p>
                            <p class="font-bold">{{ $booking->guests }}</p>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-2xl">
                            <p class="text-slate-500">Amount</p>
                            <p class="font-bold">Rs. {{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('customer.bookings.show', $booking->id) }}"
                           class="bg-slate-950 text-white px-5 py-3 rounded-xl font-bold hover:bg-slate-800 transition">
                            View Details
                        </a>

                        @if($booking->status === 'completed' && !$booking->review)
                            <a href="{{ route('customer.reviews.create', $booking->id) }}"
                               class="bg-green-600 text-white px-5 py-3 rounded-xl font-bold hover:bg-green-700 transition">
                                Review
                            </a>
                        @endif

                        @if(in_array($booking->status, ['pending', 'approved']))
                            <form method="POST"
                                  action="{{ route('customer.bookings.cancel', $booking->id) }}"
                                  class="cancel-form">
                                @csrf
                                @method('PATCH')

                                <button type="button"
                                        class="cancel-btn bg-red-500 text-white px-5 py-3 rounded-xl font-bold hover:bg-red-600 transition">
                                    Cancel
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    @empty
        <div class="lg:col-span-2 bg-white p-10 rounded-3xl shadow text-center">
            <h2 class="text-2xl font-bold mb-2">No bookings yet</h2>
            <p class="text-slate-500 mb-6">Start by choosing a room for your next stay.</p>

            <a href="{{ route('rooms') }}" class="bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold">
                Browse Rooms
            </a>
        </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $bookings->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function () {
        Swal.fire({
            title: 'Cancel this booking?',
            text: 'This action will mark your booking as cancelled.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
});
</script>
@endpush