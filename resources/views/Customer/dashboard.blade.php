<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="min-h-screen">

    <header class="bg-slate-950 text-white px-8 py-5 flex justify-between items-center">
        <h1 class="text-2xl font-bold">Hotel Customer</h1>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 text-white px-5 py-2 rounded-lg hover:bg-red-600">
                Logout
            </button>
        </form>
    </header>

    <main class="p-8">

        <h2 class="text-3xl font-bold text-slate-800 mb-2">
            Welcome, {{ auth()->user()->name }} 👋
        </h2>
        <p class="text-slate-500 mb-8">Book rooms and manage your hotel stays</p>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Total Bookings</p>
                <h3 class="text-3xl font-bold text-blue-600">0</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Pending</p>
                <h3 class="text-3xl font-bold text-yellow-500">0</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Upcoming</p>
                <h3 class="text-3xl font-bold text-green-600">0</h3>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Completed</p>
                <h3 class="text-3xl font-bold text-purple-600">0</h3>
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="#" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold text-slate-800">Browse Rooms</h3>
                <p class="text-slate-500">View available rooms</p>
            </a>

            <a href="#" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold text-slate-800">My Bookings</h3>
                <p class="text-slate-500">Track your bookings</p>
            </a>

            <a href="#" class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <h3 class="text-xl font-bold text-slate-800">Payments</h3>
                <p class="text-slate-500">View payment history</p>
            </a>

        </div>

    </main>
</div>

</body>
</html>