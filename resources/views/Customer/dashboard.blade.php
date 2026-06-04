<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .glass {
            background: rgba(255, 255, 255, 0.82);
            backdrop-filter: blur(18px);
        }
    </style>
</head>

<body class="bg-slate-100 text-slate-900">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-72 bg-slate-950 text-white p-6 hidden lg:flex flex-col justify-between">

        <div>
            <h1 class="text-3xl font-extrabold mb-10">
                RoyalStay<span class="text-amber-400">.</span>
            </h1>

            <nav class="space-y-3">
                <a href="{{ route('customer.dashboard') }}"
                   class="block bg-amber-400 text-slate-950 px-5 py-3 rounded-2xl font-bold">
                    Dashboard
                </a>

                <a href="{{ route('rooms') }}"
                   class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">
                    Browse Rooms
                </a>

                <a href="{{ route('customer.bookings.index') }}"
                   class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">
                    My Bookings
                </a>

                <a href="{{ route('customer.payments.index') }}"
                   class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">
                    Payments
                </a>

                <a href="{{ route('customer.profile.edit') }}"
                   class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">
                    Profile
                </a>
            </nav>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full bg-red-500 text-white px-5 py-3 rounded-2xl font-bold hover:bg-red-600">
                Logout
            </button>
        </form>
    </aside>

    <!-- Main -->
    <main class="flex-1 p-6 lg:p-10">

        <!-- Top Header -->
        <div class="flex flex-col lg:flex-row justify-between gap-6 items-start lg:items-center mb-8">

            <div>
                <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
                    Customer Portal
                </p>

                <h2 class="text-4xl font-extrabold text-slate-900">
                    Welcome back, {{ auth()->user()->name }} 👋
                </h2>

                <p class="text-slate-500 mt-2">
                    Manage your bookings, payments, stays and profile from one place.
                </p>
            </div>

            <div class="flex items-center gap-4 bg-white p-4 rounded-3xl shadow">
                <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                     class="w-14 h-14 rounded-full object-cover border-2 border-amber-400">

                <div>
                    <p class="font-bold">{{ auth()->user()->name }}</p>
                    <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Hero Summary -->
        <section class="bg-slate-950 text-white rounded-[2rem] p-8 mb-8 relative overflow-hidden">

            <div class="relative z-10 grid lg:grid-cols-2 gap-6 items-center">
                <div>
                    <h3 class="text-3xl font-extrabold mb-3">
                        Your stay, simplified.
                    </h3>

                    <p class="text-slate-300 mb-6">
                        Browse luxury rooms, track booking progress, manage payments and view invoices easily.
                    </p>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('rooms') }}"
                           class="bg-amber-400 text-slate-950 px-6 py-3 rounded-full font-bold">
                            Book a Room
                        </a>

                        <a href="{{ route('customer.bookings.index') }}"
                           class="bg-white/10 px-6 py-3 rounded-full font-bold">
                            View Bookings
                        </a>
                    </div>
                </div>

                <div class="glass text-slate-900 p-6 rounded-3xl">
                    <p class="text-slate-500">Pending Payment</p>
                    <h3 class="text-4xl font-extrabold text-red-500">
                        Rs. {{ number_format($pendingPaymentAmount, 2) }}
                    </h3>

                    <a href="{{ route('customer.payments.index') }}"
                       class="inline-block mt-4 bg-slate-950 text-white px-5 py-3 rounded-xl">
                        Manage Payments
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

            <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
                <p class="text-slate-500">Total Bookings</p>
                <h3 class="text-4xl font-extrabold text-blue-600">{{ $totalBookings }}</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
                <p class="text-slate-500">Pending</p>
                <h3 class="text-4xl font-extrabold text-yellow-500">{{ $pendingBookings }}</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
                <p class="text-slate-500">Upcoming</p>
                <h3 class="text-4xl font-extrabold text-green-600">{{ $upcomingStays }}</h3>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow hover:-translate-y-1 transition">
                <p class="text-slate-500">Completed</p>
                <h3 class="text-4xl font-extrabold text-purple-600">{{ $completedStays }}</h3>
            </div>

        </div>

        <!-- Main Widgets -->
        <div class="grid lg:grid-cols-3 gap-8">

            <!-- Recent Bookings -->
            <div class="lg:col-span-2 bg-white rounded-3xl shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold">Recent Bookings</h3>
                    <a href="{{ route('customer.bookings.index') }}" class="text-amber-500 font-bold">
                        View All
                    </a>
                </div>

                <div class="space-y-4">
                    @forelse($recentBookings as $booking)
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 rounded-2xl bg-slate-50">
                            <div>
                                <h4 class="font-bold text-lg">{{ $booking->room->room_type }}</h4>
                                <p class="text-sm text-slate-500">
                                    {{ $booking->check_in_date->format('Y-m-d') }}
                                    to
                                    {{ $booking->check_out_date->format('Y-m-d') }}
                                </p>
                            </div>

                            <span class="px-4 py-2 rounded-full text-sm font-semibold
                                {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $booking->status == 'checked_in' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $booking->status == 'checked_out' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                {{ $booking->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}">
                                {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                            </span>
                        </div>
                    @empty
                        <p class="text-slate-500">No bookings yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Next Stay -->
            <div class="bg-white rounded-3xl shadow p-6">
                <h3 class="text-2xl font-bold mb-6">Next Stay</h3>

                @if($nextStay)
                    <div class="bg-amber-100 rounded-3xl p-6">
                        <p class="text-slate-500 mb-2">Room</p>
                        <h4 class="text-2xl font-extrabold mb-4">
                            {{ $nextStay->room->room_type }}
                        </h4>

                        <p class="text-sm text-slate-600">Check-In</p>
                        <p class="font-bold mb-3">
                            {{ $nextStay->check_in_date->format('Y-m-d') }}
                        </p>

                        <p class="text-sm text-slate-600">Guests</p>
                        <p class="font-bold">{{ $nextStay->guests }}</p>
                    </div>
                @else
                    <div class="bg-slate-100 rounded-3xl p-6 text-center">
                        <p class="text-slate-500 mb-4">No upcoming stay yet.</p>

                        <a href="{{ route('rooms') }}"
                           class="bg-slate-950 text-white px-5 py-3 rounded-xl inline-block">
                            Browse Rooms
                        </a>
                    </div>
                @endif
            </div>

        </div>

        <!-- Payments -->
        <div class="bg-white rounded-3xl shadow p-6 mt-8">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold">Recent Payments</h3>
                <a href="{{ route('customer.payments.index') }}" class="text-amber-500 font-bold">
                    View All
                </a>
            </div>

            <div class="grid md:grid-cols-3 gap-4">
                @forelse($recentPayments as $payment)
                    <div class="bg-slate-50 p-5 rounded-2xl">
                        <p class="font-bold">
                            {{ $payment->booking->room->room_type }}
                        </p>

                        <p class="text-2xl font-extrabold mt-2">
                            Rs. {{ number_format($payment->amount, 2) }}
                        </p>

                        <span class="inline-block mt-3 px-3 py-1 rounded-full text-sm
                            {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-slate-500">No payments yet.</p>
                @endforelse
            </div>
        </div>

    </main>

</div>

</body>
</html>