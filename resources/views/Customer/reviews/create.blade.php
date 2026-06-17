@extends('layouts.customer')

@section('title', 'Submit Review')

@section('page-title', 'Submit Review')

@section('page-subtitle', 'Share your experience about your completed stay.')

@section('content')

<div class="max-w-6xl mx-auto">

    <a href="{{ route('customer.bookings.index') }}"
       class="inline-flex items-center gap-2 bg-white px-5 py-3 rounded-2xl shadow font-bold text-slate-700 hover:bg-amber-400 hover:text-slate-950 transition mb-6">
        <i data-lucide="arrow-left" class="w-5"></i>
        Back to Bookings
    </a>

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-5 rounded-3xl mb-6 shadow">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-8">

        {{-- Room / Booking Summary --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2rem] shadow overflow-hidden">

                <img src="{{ $booking->room->image ? asset('storage/' . $booking->room->image) : 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?auto=format&fit=crop&w=900&q=80' }}"
                     class="w-full h-72 object-cover"
                     alt="{{ $booking->room->room_type }}">

                <div class="p-6">
                    <p class="text-amber-500 font-bold mb-2">
                        Booking #{{ $booking->id }}
                    </p>

                    <h2 class="text-2xl font-extrabold text-slate-950">
                        {{ $booking->room->room_type }}
                    </h2>

                    <p class="text-slate-500 mt-1">
                        Room No: {{ $booking->room->room_number }}
                    </p>

                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="bg-slate-100 p-4 rounded-2xl">
                            <p class="text-slate-500 text-sm">Check-In</p>
                            <p class="font-bold">{{ $booking->check_in_date->format('Y-m-d') }}</p>
                        </div>

                        <div class="bg-slate-100 p-4 rounded-2xl">
                            <p class="text-slate-500 text-sm">Check-Out</p>
                            <p class="font-bold">{{ $booking->check_out_date->format('Y-m-d') }}</p>
                        </div>

                        <div class="bg-slate-100 p-4 rounded-2xl">
                            <p class="text-slate-500 text-sm">Guests</p>
                            <p class="font-bold">{{ $booking->guests }}</p>
                        </div>

                        <div class="bg-slate-100 p-4 rounded-2xl">
                            <p class="text-slate-500 text-sm">Amount</p>
                            <p class="font-bold">Rs. {{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Review Form --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow p-8">

                <div class="mb-8">
                    <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
                        Rate Your Stay
                    </p>

                    <h1 class="text-4xl font-extrabold text-slate-950">
                        How was your experience?
                    </h1>

                    <p class="text-slate-500 mt-2">
                        Your review helps other customers choose the right room.
                    </p>
                </div>

                <form method="POST" action="{{ route('customer.reviews.store', $booking->id) }}">
                    @csrf

                    {{-- Rating --}}
                    <div class="mb-6">
                        <label class="font-bold text-slate-700">
                            Rating
                        </label>

                        <select name="rating"
                                class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none">
                            <option value="">Select Rating</option>
                            <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                            <option value="4">⭐⭐⭐⭐ Good</option>
                            <option value="3">⭐⭐⭐ Average</option>
                            <option value="2">⭐⭐ Poor</option>
                            <option value="1">⭐ Very Poor</option>
                        </select>
                    </div>

                    {{-- Comment --}}
                    <div class="mb-6">
                        <label class="font-bold text-slate-700">
                            Comment
                        </label>

                        <textarea name="comment"
                                  rows="7"
                                  class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none"
                                  placeholder="Write your experience...">{{ old('comment') }}</textarea>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex flex-col sm:flex-row justify-end gap-4 pt-6 border-t border-slate-100">

                        <a href="{{ route('customer.bookings.index') }}"
                           class="bg-slate-200 text-slate-800 px-8 py-4 rounded-2xl font-bold hover:bg-slate-300 transition text-center">
                            Cancel
                        </a>

                        <button type="submit"
                                class="bg-amber-400 text-slate-950 px-8 py-4 rounded-2xl font-extrabold hover:bg-amber-300 transition">
                            Submit Review
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

@endsection