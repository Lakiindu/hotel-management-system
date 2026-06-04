<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

    </nav>

    </aside>

    <main class="flex-1 p-8">

        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">
                    Admin Dashboard
                </h2>
                <p class="text-slate-500">
                    Manage your hotel system easily
                </p>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Total Rooms</p>
                <h3 class="text-3xl font-bold text-blue-600">
                    {{ $totalRooms }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Available Rooms</p>
                <h3 class="text-3xl font-bold text-green-600">
                    {{ $availableRooms }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Occupied Rooms</p>
                <h3 class="text-3xl font-bold text-red-600">
                    {{ $occupiedRooms }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Customers</p>
                <h3 class="text-3xl font-bold text-cyan-600">
                    {{ $totalCustomers }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Total Bookings</p>
                <h3 class="text-3xl font-bold text-purple-600">
                    {{ $totalBookings }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Pending Bookings</p>
                <h3 class="text-3xl font-bold text-yellow-500">
                    {{ $pendingBookings }}
                </h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Revenue</p>
                <h3 class="text-3xl font-bold text-emerald-600">
                    Rs. {{ number_format($totalRevenue, 2) }}
                </h3>
            </div>

        </div>

    </main>

</div>

</body>
</html>