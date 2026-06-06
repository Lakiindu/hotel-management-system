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
                Manage your hotel operations, track room status, monitor revenue and control bookings from one dashboard.
            </p>
        </div>

        <div class="bg-white/10 p-6 rounded-3xl">
            <p class="text-slate-300">Total Revenue</p>
            <h3 class="text-4xl font-extrabold text-amber-400">
                Rs. {{ number_format($totalRevenue, 2) }}
            </h3>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Total Rooms</p>
            <i data-lucide="bed-double" class="text-blue-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-blue-600">{{ $totalRooms }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Available Rooms</p>
            <i data-lucide="check-circle" class="text-green-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-green-600">{{ $availableRooms }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Occupied Rooms</p>
            <i data-lucide="lock" class="text-red-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-red-600">{{ $occupiedRooms }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Customers</p>
            <i data-lucide="users" class="text-cyan-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-cyan-600">{{ $totalCustomers }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Total Bookings</p>
            <i data-lucide="calendar-check" class="text-purple-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-purple-600">{{ $totalBookings }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Pending Bookings</p>
            <i data-lucide="clock" class="text-yellow-500"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-yellow-500">{{ $pendingBookings }}</h3>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition xl:col-span-2">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Revenue</p>
            <i data-lucide="wallet" class="text-emerald-600"></i>
        </div>
        <h3 class="text-4xl font-extrabold text-emerald-600">
            Rs. {{ number_format($totalRevenue, 2) }}
        </h3>
    </div>

</div>

<div class="grid lg:grid-cols-3 gap-8">

    <div class="lg:col-span-2 bg-white p-8 rounded-[2rem] shadow">
        <h2 class="text-2xl font-extrabold mb-4">Quick Management</h2>

        <div class="grid md:grid-cols-3 gap-4">
            <a href="{{ route('admin.rooms.index') }}" class="bg-slate-100 p-5 rounded-2xl hover:bg-slate-200">
                <p class="font-bold">Rooms</p>
                <p class="text-sm text-slate-500">Manage room inventory</p>
            </a>

            <a href="{{ route('admin.bookings.index') }}" class="bg-slate-100 p-5 rounded-2xl hover:bg-slate-200">
                <p class="font-bold">Bookings</p>
                <p class="text-sm text-slate-500">Approve and update stays</p>
            </a>

            <a href="{{ route('admin.reports.index') }}" class="bg-slate-100 p-5 rounded-2xl hover:bg-slate-200">
                <p class="font-bold">Reports</p>
                <p class="text-sm text-slate-500">View analytics</p>
            </a>
        </div>
    </div>

    <div class="bg-white p-8 rounded-[2rem] shadow">
        <h2 class="text-2xl font-extrabold mb-4">System Status</h2>

        <div class="space-y-4">
            <div class="flex justify-between">
                <span class="text-slate-500">Rooms Active</span>
                <span class="font-bold">{{ $totalRooms }}</span>
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
