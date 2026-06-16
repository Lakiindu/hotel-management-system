@extends('layouts.admin')

@section('title', 'Customer Details')

@section('page-title', 'Customer Details')

@section('page-subtitle', 'View customer profile, account status and booking history.')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}"
           class="inline-flex items-center gap-2 bg-white px-5 py-3 rounded-2xl shadow font-bold text-slate-700 hover:bg-amber-400 hover:text-slate-950 transition">
            <i data-lucide="arrow-left" class="w-5"></i>
            Back to Customers
        </a>
    </div>

    {{-- Customer Profile Card --}}
    <div class="bg-white rounded-[2rem] shadow p-8 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">

            <div class="flex items-center gap-6">
                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                     class="w-32 h-32 rounded-3xl object-cover border-4 border-amber-400 shadow"
                     alt="{{ $user->name }}">

                <div>
                    <h2 class="text-4xl font-extrabold text-slate-900">
                        {{ $user->name }}
                    </h2>

                    <div class="space-y-2 mt-4 text-slate-500">
                        <p>
                            <i data-lucide="mail" class="inline w-5 mr-2 text-amber-500"></i>
                            {{ $user->email }}
                        </p>

                        <p>
                            <i data-lucide="phone" class="inline w-5 mr-2 text-amber-500"></i>
                            {{ $user->phone ?? 'No phone number' }}
                        </p>

                        <p>
                            <i data-lucide="map-pin" class="inline w-5 mr-2 text-amber-500"></i>
                            {{ $user->address ?? 'No address added' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-left lg:text-right">
                <p class="text-slate-500 mb-3">Account Status</p>

                @if($user->is_active)
                    <span class="inline-block bg-green-100 text-green-700 px-5 py-2 rounded-full font-bold">
                        Active
                    </span>
                @else
                    <span class="inline-block bg-red-100 text-red-700 px-5 py-2 rounded-full font-bold">
                        Inactive
                    </span>
                @endif

                <p class="text-sm text-slate-400 mt-4">
                    Joined {{ $user->created_at ? $user->created_at->format('Y-m-d') : '-' }}
                </p>
            </div>

        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid md:grid-cols-3 gap-6 mb-8">

        <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-blue-500">
            <p class="text-slate-500">Total Bookings</p>
            <h2 class="text-4xl font-extrabold text-blue-600">
                {{ $user->bookings->count() }}
            </h2>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-green-500">
            <p class="text-slate-500">Completed</p>
            <h2 class="text-4xl font-extrabold text-green-600">
                {{ $user->bookings->where('status', 'completed')->count() }}
            </h2>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-yellow-500">
            <p class="text-slate-500">Pending</p>
            <h2 class="text-4xl font-extrabold text-yellow-500">
                {{ $user->bookings->where('status', 'pending')->count() }}
            </h2>
        </div>

    </div>

    {{-- Booking History --}}
    <div class="bg-white rounded-[2rem] shadow overflow-hidden">

        <div class="p-6 border-b border-slate-100">
            <h2 class="text-2xl font-extrabold">
                Booking History
            </h2>

            <p class="text-slate-500 mt-1">
                All bookings made by this customer.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">

                <thead class="bg-slate-950 text-white">
                    <tr>
                        <th class="p-5 text-left">Booking ID</th>
                        <th class="p-5 text-left">Room</th>
                        <th class="p-5 text-left">Dates</th>
                        <th class="p-5 text-left">Amount</th>
                        <th class="p-5 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($user->bookings as $booking)

                        <tr class="border-b hover:bg-slate-50 transition">

                            <td class="p-5 font-bold">
                                #{{ $booking->id }}
                            </td>

                            <td class="p-5">
                                <p class="font-bold text-slate-900">
                                    {{ $booking->room->room_type ?? 'Room deleted' }}
                                </p>

                                <p class="text-sm text-slate-500">
                                    Room No: {{ $booking->room->room_number ?? '-' }}
                                </p>
                            </td>

                            <td class="p-5 text-slate-600">
                                {{ $booking->check_in_date->format('Y-m-d') }}
                                to
                                {{ $booking->check_out_date->format('Y-m-d') }}
                            </td>

                            <td class="p-5 font-bold text-amber-500">
                                Rs. {{ number_format($booking->total_amount, 2) }}
                            </td>

                            <td class="p-5">
                                <span class="px-4 py-2 rounded-full text-sm font-bold
                                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $booking->status == 'confirmed' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $booking->status == 'checked_in' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $booking->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}">
                                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="p-10 text-center text-slate-500">
                                No bookings found for this customer.
                            </td>
                        </tr>

                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection