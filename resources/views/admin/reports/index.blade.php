<!DOCTYPE html>
<html>
<head>
    <title>Reports & Analytics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h1 class="text-2xl font-bold mb-8">Hotel Admin</h1>

        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Dashboard</a>
            <a href="{{ route('admin.rooms.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Rooms</a>
            <a href="{{ route('admin.bookings.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Bookings</a>
            <a href="{{ route('admin.customers.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Customers</a>
            <a href="{{ route('admin.payments.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Payments</a>
            <a href="{{ route('admin.reviews.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Reviews</a>
            <a href="{{ route('admin.reports.index') }}" class="block bg-blue-600 px-4 py-2 rounded-lg">Reports</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">

        <h1 class="text-3xl font-bold text-slate-800 mb-2">Reports & Analytics</h1>
        <p class="text-slate-500 mb-8">Track hotel performance, bookings, revenue and occupancy.</p>

        <form method="GET" class="bg-white p-5 rounded-2xl shadow mb-8 grid md:grid-cols-4 gap-4">
            <input type="date"
                   name="start_date"
                   value="{{ request('start_date') }}"
                   class="border rounded-xl px-4 py-3">

            <input type="date"
                   name="end_date"
                   value="{{ request('end_date') }}"
                   class="border rounded-xl px-4 py-3">

            <button class="bg-slate-950 text-white rounded-xl px-4 py-3">
                Filter
            </button>

            <div class="flex gap-2">
                <a href="{{ route('admin.reports.export.csv', request()->query()) }}"
                   class="bg-green-600 text-white px-4 py-3 rounded-xl">
                    CSV
                </a>

                <a href="{{ route('admin.reports.export.pdf', request()->query()) }}"
                   target="_blank"
                   class="bg-red-600 text-white px-4 py-3 rounded-xl">
                    PDF
                </a>
            </div>
        </form>

        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Total Revenue</p>
                <h2 class="text-3xl font-bold text-green-600">Rs. {{ number_format($totalRevenue, 2) }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Total Bookings</p>
                <h2 class="text-3xl font-bold text-blue-600">{{ $totalBookings }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Customers</p>
                <h2 class="text-3xl font-bold text-purple-600">{{ $totalCustomers }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Total Rooms</p>
                <h2 class="text-3xl font-bold text-amber-500">{{ $totalRooms }}</h2>
            </div>
        </div>

        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-green-100 p-6 rounded-2xl">
                <p class="text-green-700">Available Rooms</p>
                <h2 class="text-3xl font-bold text-green-800">{{ $availableRooms }}</h2>
            </div>

            <div class="bg-red-100 p-6 rounded-2xl">
                <p class="text-red-700">Occupied Rooms</p>
                <h2 class="text-3xl font-bold text-red-800">{{ $occupiedRooms }}</h2>
            </div>

            <div class="bg-yellow-100 p-6 rounded-2xl">
                <p class="text-yellow-700">Maintenance Rooms</p>
                <h2 class="text-3xl font-bold text-yellow-800">{{ $maintenanceRooms }}</h2>
            </div>

            <div class="bg-blue-100 p-6 rounded-2xl">
                <p class="text-blue-700">Pending Bookings</p>
                <h2 class="text-3xl font-bold text-blue-800">{{ $pendingBookings }}</h2>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-8 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-xl font-bold mb-4">Monthly Revenue</h2>
                <canvas id="revenueChart"></canvas>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <h2 class="text-xl font-bold mb-4">Monthly Bookings</h2>
                <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow mb-8">
            <h2 class="text-xl font-bold mb-4">Room Occupancy</h2>
            <canvas id="occupancyChart"></canvas>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <h2 class="text-xl font-bold p-6">Recent Bookings</h2>

            <table class="w-full">
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
                        <tr class="border-b">
                            <td class="p-4">{{ $booking->user->name }}</td>
                            <td class="p-4">{{ $booking->room->room_type }}</td>
                            <td class="p-4">Rs. {{ number_format($booking->total_amount, 2) }}</td>
                            <td class="p-4">{{ ucwords(str_replace('_', ' ', $booking->status)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-6 text-center text-slate-500">No bookings found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>
</div>

<input type="hidden" id="months-data" value='@json($months)'>
<input type="hidden" id="revenue-data" value='@json($revenueData)'>
<input type="hidden" id="booking-data" value='@json($bookingData)'>

<input type="hidden" id="available-rooms" value="{{ $availableRooms }}">
<input type="hidden" id="occupied-rooms" value="{{ $occupiedRooms }}">
<input type="hidden" id="maintenance-rooms" value="{{ $maintenanceRooms }}">

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

</body>
</html>