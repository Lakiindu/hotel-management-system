@extends('layouts.admin')

@section('title', 'Reports & Analytics')

@section('page-title', 'Reports & Analytics')

@section('page-subtitle', 'Track hotel performance, bookings, revenue and occupancy.')

@section('content')

<form method="GET" class="bg-white p-5 rounded-3xl shadow mb-8 grid md:grid-cols-4 gap-4">
    <input type="date"
           name="start_date"
           value="{{ request('start_date') }}"
           class="border rounded-2xl px-4 py-3">

    <input type="date"
           name="end_date"
           value="{{ request('end_date') }}"
           class="border rounded-2xl px-4 py-3">

    <button class="bg-slate-950 text-white rounded-2xl px-4 py-3 font-bold">
        Filter
    </button>

    <div class="flex gap-2">
        <a href="{{ route('admin.reports.export.csv', request()->query()) }}"
           class="bg-green-600 text-white px-4 py-3 rounded-2xl font-bold">
            CSV
        </a>

        <a href="{{ route('admin.reports.export.pdf', request()->query()) }}"
           target="_blank"
           class="bg-red-600 text-white px-4 py-3 rounded-2xl font-bold">
            PDF
        </a>
    </div>
</form>

<div class="grid md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Total Revenue</p>
        <h2 class="text-3xl font-extrabold text-green-600">
            Rs. {{ number_format($totalRevenue, 2) }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Total Bookings</p>
        <h2 class="text-3xl font-extrabold text-blue-600">{{ $totalBookings }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Customers</p>
        <h2 class="text-3xl font-extrabold text-purple-600">{{ $totalCustomers }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Total Rooms</p>
        <h2 class="text-3xl font-extrabold text-amber-500">{{ $totalRooms }}</h2>
    </div>
</div>

<div class="grid md:grid-cols-4 gap-6 mb-8">
    <div class="bg-green-100 p-6 rounded-3xl">
        <p class="text-green-700">Available Rooms</p>
        <h2 class="text-3xl font-extrabold text-green-800">{{ $availableRooms }}</h2>
    </div>

    <div class="bg-red-100 p-6 rounded-3xl">
        <p class="text-red-700">Occupied Rooms</p>
        <h2 class="text-3xl font-extrabold text-red-800">{{ $occupiedRooms }}</h2>
    </div>

    <div class="bg-yellow-100 p-6 rounded-3xl">
        <p class="text-yellow-700">Maintenance Rooms</p>
        <h2 class="text-3xl font-extrabold text-yellow-800">{{ $maintenanceRooms }}</h2>
    </div>

    <div class="bg-blue-100 p-6 rounded-3xl">
        <p class="text-blue-700">Pending Bookings</p>
        <h2 class="text-3xl font-extrabold text-blue-800">{{ $pendingBookings }}</h2>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-8 mb-8">
    <div class="bg-white p-6 rounded-[2rem] shadow">
        <h2 class="text-xl font-extrabold mb-4">Monthly Revenue</h2>
        <canvas id="revenueChart"></canvas>
    </div>

    <div class="bg-white p-6 rounded-[2rem] shadow">
        <h2 class="text-xl font-extrabold mb-4">Monthly Bookings</h2>
        <canvas id="bookingChart"></canvas>
    </div>
</div>

<div class="bg-white p-6 rounded-[2rem] shadow mb-8">
    <h2 class="text-xl font-extrabold mb-4">Room Occupancy</h2>
    <canvas id="occupancyChart"></canvas>
</div>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <h2 class="text-xl font-extrabold p-6">Recent Bookings</h2>

    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Room</th>
                    <th class="p-4 text-left">Amount</th>
                    <th class="p-4 text-left">Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($recentBookings as $booking)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-4">{{ $booking->user->name }}</td>
                        <td class="p-4">{{ $booking->room->room_type }}</td>
                        <td class="p-4 font-bold">Rs. {{ number_format($booking->total_amount, 2) }}</td>
                        <td class="p-4">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500">
                            No bookings found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<input type="hidden" id="months-data" value='@json($months)'>
<input type="hidden" id="revenue-data" value='@json($revenueData)'>
<input type="hidden" id="booking-data" value='@json($bookingData)'>

<input type="hidden" id="available-rooms" value="{{ $availableRooms }}">
<input type="hidden" id="occupied-rooms" value="{{ $occupiedRooms }}">
<input type="hidden" id="maintenance-rooms" value="{{ $maintenanceRooms }}">

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const months = JSON.parse(document.getElementById('months-data').value);
const revenueData = JSON.parse(document.getElementById('revenue-data').value);
const bookingData = JSON.parse(document.getElementById('booking-data').value);

const availableRooms = Number(document.getElementById('available-rooms').value);
const occupiedRooms = Number(document.getElementById('occupied-rooms').value);
const maintenanceRooms = Number(document.getElementById('maintenance-rooms').value);

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Revenue',
            data: revenueData,
            borderWidth: 3,
            tension: 0.4
        }]
    }
});

new Chart(document.getElementById('bookingChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Bookings',
            data: bookingData,
            borderWidth: 1
        }]
    }
});

new Chart(document.getElementById('occupancyChart'), {
    type: 'doughnut',
    data: {
        labels: ['Available', 'Occupied', 'Maintenance'],
        datasets: [{
            data: [
                availableRooms,
                occupiedRooms,
                maintenanceRooms
            ]
        }]
    }
});
</script>
@endpush