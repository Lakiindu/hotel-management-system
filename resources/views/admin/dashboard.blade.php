@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('page-title', 'Admin Dashboard')

@section('page-subtitle', 'Monitor hotel rooms, customers, bookings and revenue.')

@section('content')

<div class="bg-slate-950 text-white rounded-[2rem] p-8 mb-8">
    <div class="grid lg:grid-cols-2 gap-6 items-center">
        <div>
            <h2 class="text-3xl font-extrabold mb-3">
                Welcome back, {{ auth()->user()->name }} 👋
            </h2>

            <p class="text-slate-300">
                Manage hotel operations, track room status, monitor revenue and control bookings from one dashboard.
            </p>
        </div>

        <div class="bg-white/10 p-6 rounded-3xl">
            <p class="text-slate-300">Total Revenue</p>

            <h3 class="text-4xl font-extrabold text-purple-400">
                Rs. {{ number_format($totalRevenue, 2) }}
            </h3>

            <p class="text-sm text-slate-400 mt-2">
                Purple indicates revenue-related information.
            </p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border-l-4 border-blue-500">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Total Rooms</p>
            <i data-lucide="bed-double" class="text-blue-600"></i>
        </div>

        <h3 class="text-4xl font-extrabold text-blue-600">
            {{ $totalRooms }}
        </h3>

        <p class="text-sm text-slate-400 mt-2">Information</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border-l-4 border-green-500">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Available Rooms</p>
            <i data-lucide="check-circle" class="text-green-600"></i>
        </div>

        <h3 class="text-4xl font-extrabold text-green-600">
            {{ $availableRooms }}
        </h3>

        <p class="text-sm text-slate-400 mt-2">Success / Available</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border-l-4 border-red-500">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Occupied Rooms</p>
            <i data-lucide="lock" class="text-red-600"></i>
        </div>

        <h3 class="text-4xl font-extrabold text-red-600">
            {{ $occupiedRooms }}
        </h3>

        <p class="text-sm text-slate-400 mt-2">Critical / Occupied</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border-l-4 border-blue-500">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Customers</p>
            <i data-lucide="users" class="text-blue-600"></i>
        </div>

        <h3 class="text-4xl font-extrabold text-blue-600">
            {{ $totalCustomers }}
        </h3>

        <p class="text-sm text-slate-400 mt-2">Information</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border-l-4 border-blue-500">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Total Bookings</p>
            <i data-lucide="calendar-check" class="text-blue-600"></i>
        </div>

        <h3 class="text-4xl font-extrabold text-blue-600">
            {{ $totalBookings }}
        </h3>

        <p class="text-sm text-slate-400 mt-2">Information</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border-l-4 border-yellow-500">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Pending Bookings</p>
            <i data-lucide="clock" class="text-yellow-500"></i>
        </div>

        <h3 class="text-4xl font-extrabold text-yellow-500">
            {{ $pendingBookings }}
        </h3>

        <p class="text-sm text-slate-400 mt-2">Pending</p>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border-l-4 border-purple-500 xl:col-span-2">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Revenue</p>
            <i data-lucide="wallet" class="text-purple-600"></i>
        </div>

        <h3 class="text-4xl font-extrabold text-purple-600">
            Rs. {{ number_format($totalRevenue, 2) }}
        </h3>

        <p class="text-sm text-slate-400 mt-2">Revenue</p>
    </div>

</div>

<div class="grid lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow hover:shadow-xl transition-all duration-300">
        <h2 class="text-2xl font-extrabold mb-4">Quick Management</h2>

        <div class="grid md:grid-cols-3 gap-4">
            <a href="{{ route('admin.rooms.index') }}"
               class="bg-blue-50 p-5 rounded-2xl hover:bg-blue-100 transition">
                <p class="font-bold text-blue-700">Rooms</p>
                <p class="text-sm text-slate-500">Manage room inventory</p>
            </a>

            <a href="{{ route('admin.bookings.index') }}"
               class="bg-yellow-50 p-5 rounded-2xl hover:bg-yellow-100 transition">
                <p class="font-bold text-yellow-700">Bookings</p>
                <p class="text-sm text-slate-500">Approve and update stays</p>
            </a>

            <a href="{{ route('admin.reports.index') }}"
               class="bg-purple-50 p-5 rounded-2xl hover:bg-purple-100 transition">
                <p class="font-bold text-purple-700">Reports</p>
                <p class="text-sm text-slate-500">View analytics</p>
            </a>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2rem] shadow hover:shadow-xl transition-all duration-300">
        <h2 class="text-2xl font-extrabold mb-4">System Status</h2>

        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="text-slate-500">Rooms Active</span>
                <span class="font-bold text-blue-600">{{ $totalRooms }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-500">Pending Tasks</span>
                <span class="font-bold text-yellow-500">{{ $pendingBookings }}</span>
            </div>

            <div class="flex justify-between">
                <span class="text-slate-500">Revenue Status</span>
                <span class="font-bold text-green-600">Tracking</span>
            </div>
        </div>
    </div>

</div>

@endsection