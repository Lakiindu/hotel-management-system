<!DOCTYPE html>
<html>
<head>
    <title>Customer Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h1 class="text-2xl font-bold mb-8">Hotel Admin</h1>

        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Dashboard</a>
            <a href="{{ route('admin.customers.index') }}" class="block bg-blue-600 px-4 py-2 rounded-lg">Customers</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">

        <a href="{{ route('admin.customers.index') }}" class="text-slate-500">
            ← Back to Customers
        </a>

        <div class="bg-white p-8 rounded-3xl shadow mt-6 mb-8">
            <div class="flex items-center gap-6">
                <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                     class="w-28 h-28 rounded-full object-cover border-4 border-blue-500">

                <div>
                    <h1 class="text-3xl font-bold">{{ $user->name }}</h1>
                    <p class="text-slate-500">{{ $user->email }}</p>
                    <p class="text-slate-500">{{ $user->phone ?? 'No phone number' }}</p>
                    <p class="text-slate-500">{{ $user->address ?? 'No address' }}</p>

                    <span class="inline-block mt-3 px-4 py-1 rounded-full text-sm
                        {{ $user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $user->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Total Bookings</p>
                <h2 class="text-4xl font-bold">{{ $user->bookings->count() }}</h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Completed</p>
                <h2 class="text-4xl font-bold text-green-600">
                    {{ $user->bookings->where('status', 'completed')->count() }}
                </h2>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <p class="text-slate-500">Pending</p>
                <h2 class="text-4xl font-bold text-yellow-500">
                    {{ $user->bookings->where('status', 'pending')->count() }}
                </h2>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <h2 class="text-2xl font-bold p-6">Booking History</h2>

            <table class="w-full">
                <thead class="bg-slate-950 text-white">
                    <tr>
                        <th class="p-4 text-left">Booking ID</th>
                        <th class="p-4 text-left">Room</th>
                        <th class="p-4 text-left">Dates</th>
                        <th class="p-4 text-left">Amount</th>
                        <th class="p-4 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($user->bookings as $booking)
                        <tr class="border-b">
                            <td class="p-4">#{{ $booking->id }}</td>
                            <td class="p-4">{{ $booking->room->room_type ?? 'Room deleted' }}</td>
                            <td class="p-4">
                                {{ $booking->check_in_date->format('Y-m-d') }}
                                to
                                {{ $booking->check_out_date->format('Y-m-d') }}
                            </td>
                            <td class="p-4">Rs. {{ number_format($booking->total_amount, 2) }}</td>
                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">
                                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-6 text-center text-slate-500">
                                No bookings found for this customer.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </main>
</div>

</body>
</html>