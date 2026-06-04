<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-100 text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-slate-950 text-white p-6 hidden lg:flex flex-col justify-between">
        <div>
            <h1 class="text-3xl font-extrabold mb-10">
                RoyalStay<span class="text-amber-400">.</span>
            </h1>

            <nav class="space-y-3">
                <a href="{{ route('customer.dashboard') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">Dashboard</a>
                <a href="{{ route('rooms') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">Browse Rooms</a>
                <a href="{{ route('customer.bookings.index') }}" class="block bg-amber-400 text-slate-950 px-5 py-3 rounded-2xl font-bold">My Bookings</a>
                <a href="{{ route('customer.payments.index') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">Payments</a>
                <a href="{{ route('customer.profile.edit') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">Profile</a>
            </nav>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full bg-red-500 text-white px-5 py-3 rounded-2xl font-bold hover:bg-red-600">
                Logout
            </button>
        </form>
    </aside>

    <main class="flex-1 p-6 lg:p-10">

        <div class="flex flex-col lg:flex-row justify-between gap-6 items-start lg:items-center mb-8">
            <div>
                <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">Customer Portal</p>
                <h1 class="text-4xl font-extrabold text-slate-900">My Bookings</h1>
                <p class="text-slate-500 mt-2">Track your reservations, statuses and booking history.</p>
            </div>

            <a href="{{ route('rooms') }}" class="bg-amber-400 text-slate-950 px-6 py-3 rounded-2xl font-bold shadow hover:bg-amber-300">
                + Browse Rooms
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-3xl shadow">
                <p class="text-slate-500">Total Bookings</p>
                <h2 class="text-4xl font-extrabold text-blue-600">{{ $bookings->total() }}</h2>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow">
                <p class="text-slate-500">Current Page</p>
                <h2 class="text-4xl font-extrabold text-amber-500">{{ $bookings->count() }}</h2>
            </div>

            <div class="bg-white p-6 rounded-3xl shadow">
                <p class="text-slate-500">Page</p>
                <h2 class="text-4xl font-extrabold text-purple-600">{{ $bookings->currentPage() }}</h2>
            </div>
        </div>

        <div class="grid lg:grid-cols-2 gap-6">
            @forelse($bookings as $booking)
                <div class="bg-white rounded-3xl shadow overflow-hidden hover:-translate-y-1 transition">
                    <div class="grid md:grid-cols-3">
                        <img src="{{ $booking->room->image ? asset('storage/' . $booking->room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                             class="h-full min-h-[220px] w-full object-cover">

                        <div class="md:col-span-2 p-6">
                            <div class="flex justify-between items-start gap-4 mb-4">
                                <div>
                                    <h2 class="text-2xl font-extrabold">{{ $booking->room->room_type }}</h2>
                                    <p class="text-slate-500">Room No: {{ $booking->room->room_number }}</p>
                                </div>

                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $booking->status == 'checked_in' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $booking->status == 'checked_out' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                    {{ $booking->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}">
                                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-4 text-sm mb-5">
                                <div class="bg-slate-50 p-4 rounded-2xl">
                                    <p class="text-slate-500">Check-In</p>
                                    <p class="font-bold">{{ $booking->check_in_date->format('Y-m-d') }}</p>
                                </div>

                                <div class="bg-slate-50 p-4 rounded-2xl">
                                    <p class="text-slate-500">Check-Out</p>
                                    <p class="font-bold">{{ $booking->check_out_date->format('Y-m-d') }}</p>
                                </div>

                                <div class="bg-slate-50 p-4 rounded-2xl">
                                    <p class="text-slate-500">Guests</p>
                                    <p class="font-bold">{{ $booking->guests }}</p>
                                </div>

                                <div class="bg-slate-50 p-4 rounded-2xl">
                                    <p class="text-slate-500">Amount</p>
                                    <p class="font-bold">Rs. {{ number_format($booking->total_amount, 2) }}</p>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <a href="{{ route('customer.bookings.show', $booking->id) }}"
                                   class="bg-slate-950 text-white px-5 py-3 rounded-xl font-bold">
                                    View Details
                                </a>

                                @if($booking->status === 'completed' && !$booking->review)
                                    <a href="{{ route('customer.reviews.create', $booking->id) }}"
                                       class="bg-green-600 text-white px-5 py-3 rounded-xl font-bold">
                                        Review
                                    </a>
                                @endif

                                @if(in_array($booking->status, ['pending', 'approved']))
                                    <form method="POST"
                                          action="{{ route('customer.bookings.cancel', $booking->id) }}"
                                          class="cancel-form">
                                        @csrf
                                        @method('PATCH')

                                        <button type="button"
                                                class="cancel-btn bg-red-500 text-white px-5 py-3 rounded-xl font-bold">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="lg:col-span-2 bg-white p-10 rounded-3xl shadow text-center">
                    <h2 class="text-2xl font-bold mb-2">No bookings yet</h2>
                    <p class="text-slate-500 mb-6">Start by choosing a room for your next stay.</p>
                    <a href="{{ route('rooms') }}" class="bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold">
                        Browse Rooms
                    </a>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $bookings->links() }}
        </div>

    </main>
</div>

<script>
document.querySelectorAll('.cancel-btn').forEach(button => {
    button.addEventListener('click', function () {
        Swal.fire({
            title: 'Cancel this booking?',
            text: 'This action will mark your booking as cancelled.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, cancel it',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
});
</script>

</body>
</html>