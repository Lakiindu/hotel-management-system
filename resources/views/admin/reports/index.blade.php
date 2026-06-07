@extends('layouts.admin')

@section('title', 'Reports & Analytics')
@section('page-title', 'Reports & Analytics')
@section('page-subtitle', 'Track hotel performance, bookings, revenue and occupancy.')

@section('content')

<form method="GET" class="bg-white p-5 rounded-3xl shadow mb-8 grid lg:grid-cols-5 gap-4">
    <input type="date" name="start_date" value="{{ request('start_date') }}"
           class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

    <input type="date" name="end_date" value="{{ request('end_date') }}"
           class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

    <button class="bg-slate-950 text-white rounded-2xl px-4 py-3 font-bold hover:bg-slate-800 transition">
        Filter Report
    </button>

    <a href="{{ route('admin.reports.export.csv', request()->query()) }}"
       class="bg-green-600 text-white px-4 py-3 rounded-2xl font-bold text-center hover:bg-green-700 transition">
        Export CSV
    </a>

    <a href="{{ route('admin.reports.export.pdf', request()->query()) }}"
       target="_blank"
       class="bg-red-600 text-white px-4 py-3 rounded-2xl font-bold text-center hover:bg-red-700 transition">
        Export PDF
    </a>
</form>

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-purple-500 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 ">
        <p class="text-slate-500">Total Revenue</p>
        <h2 class="text-3xl font-extrabold text-purple-600">
            Rs. {{ number_format($totalRevenue, 2) }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-blue-500 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 ">
        <p class="text-slate-500">Total Bookings</p>
        <h2 class="text-3xl font-extrabold text-blue-600">{{ $totalBookings }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-green-500 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 ">
        <p class="text-slate-500">Customers</p>
        <h2 class="text-3xl font-extrabold text-green-600">{{ $totalCustomers }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-yellow-500 hover:-translate-y-2 hover:shadow-2xl transition-all duration-300 ">
        <p class="text-slate-500">Total Rooms</p>
        <h2 class="text-3xl font-extrabold text-yellow-500">{{ $totalRooms }}</h2>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-green-100 p-6 rounded-3xl">
        <p class="text-green-700 font-semibold">Available Rooms</p>
        <h2 class="text-3xl font-extrabold text-green-800">{{ $availableRooms }}</h2>
    </div>

    <div class="bg-red-100 p-6 rounded-3xl">
        <p class="text-red-700 font-semibold">Occupied Rooms</p>
        <h2 class="text-3xl font-extrabold text-red-800">{{ $occupiedRooms }}</h2>
    </div>

    <div class="bg-yellow-100 p-6 rounded-3xl">
        <p class="text-yellow-700 font-semibold">Maintenance Rooms</p>
        <h2 class="text-3xl font-extrabold text-yellow-800">{{ $maintenanceRooms }}</h2>
    </div>

    <div class="bg-blue-100 p-6 rounded-3xl">
        <p class="text-blue-700 font-semibold">Pending Bookings</p>
        <h2 class="text-3xl font-extrabold text-blue-800">{{ $pendingBookings }}</h2>
    </div>
</div>

<div class="grid xl:grid-cols-2 gap-8 mb-8">
    <div class="bg-white p-6 rounded-[2rem] shadow">
        <h2 class="text-xl font-extrabold mb-1">Monthly Revenue</h2>
        <p class="text-sm text-slate-500 mb-6">Paid payment revenue by month.</p>
        <div class="h-[360px]">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="bg-white p-6 rounded-[2rem] shadow">
        <h2 class="text-xl font-extrabold mb-1">Monthly Bookings</h2>
        <p class="text-sm text-slate-500 mb-6">Booking volume by month.</p>
        <div class="h-[360px]">
            <canvas id="bookingChart"></canvas>
        </div>
    </div>
</div>

<div class="grid xl:grid-cols-3 gap-8 mb-8">
    <div class="xl:col-span-1 bg-white p-6 rounded-[2rem] shadow">
        <h2 class="text-xl font-extrabold mb-1">Room Occupancy</h2>
        <p class="text-sm text-slate-500 mb-6">Current room availability status.</p>
        <div class="h-[320px]">
            <canvas id="occupancyChart"></canvas>
        </div>
    </div>

    <div class="xl:col-span-2 bg-white rounded-[2rem] shadow overflow-hidden">
        <div class="p-6 border-b">
            <h2 class="text-xl font-extrabold">Recent Bookings</h2>
            <p class="text-sm text-slate-500">Latest booking activities in the system.</p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px]">
                <thead class="bg-slate-950 text-white">
                    <tr>
                        <th class="p-5 text-left">Booking</th>
                        <th class="p-5 text-left">Customer</th>
                        <th class="p-5 text-left">Room</th>
                        <th class="p-5 text-left">Amount</th>
                        <th class="p-5 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr class="border-b hover:bg-slate-50 transition">
                            <td class="p-5 font-extrabold text-blue-600">
                                #{{ $booking->id }}
                            </td>

                            <td class="p-5">
                                <p class="font-bold">{{ $booking->user->name }}</p>
                                <p class="text-sm text-slate-500">{{ $booking->user->email }}</p>
                            </td>

                            <td class="p-5">
                                <p class="font-bold">{{ $booking->room->room_type }}</p>
                                <p class="text-sm text-slate-500">{{ $booking->room->room_number }}</p>
                            </td>

                            <td class="p-5 font-extrabold text-purple-600">
                                Rs. {{ number_format($booking->total_amount, 2) }}
                            </td>

                            <td class="p-5">
                                <span class="px-4 py-2 rounded-full text-sm font-bold
                                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $booking->status == 'checked_in' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $booking->status == 'checked_out' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                    {{ $booking->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}">
                                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-10 text-center text-slate-500">
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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

Chart.defaults.font.family = 'Inter, system-ui, sans-serif';
Chart.defaults.color = '#64748b';

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Revenue',
            data: revenueData,
            borderColor: '#9333ea',
            backgroundColor: 'rgba(147, 51, 234, 0.15)',
            fill: true,
            borderWidth: 4,
            tension: 0.45,
            pointRadius: 5,
            pointBackgroundColor: '#9333ea'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true },
            x: { grid: { display: false } }
        }
    }
});

new Chart(document.getElementById('bookingChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{
            label: 'Bookings',
            data: bookingData,
            backgroundColor: '#2563eb',
            borderRadius: 12,
            barThickness: 35
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: { beginAtZero: true },
            x: { grid: { display: false } }
        }
    }
});

new Chart(document.getElementById('occupancyChart'), {
    type: 'doughnut',
    data: {
        labels: ['Available', 'Occupied', 'Maintenance'],
        datasets: [{
            data: [availableRooms, occupiedRooms, maintenanceRooms],
            backgroundColor: ['#16a34a', '#dc2626', '#eab308'],
            borderWidth: 6,
            borderColor: '#ffffff',
            hoverOffset: 12
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    usePointStyle: true,
                    padding: 20
                }
            }
        }
    }
});
</script>
@endpush