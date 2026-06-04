<!DOCTYPE html>
<html>
<head>
    <title>Payment Management</title>
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

    <a href="{{ route('admin.reports.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Reports</a>
    
    </nav>
    </aside>

    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6">Payment Management</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="bg-white p-5 rounded-2xl shadow mb-6 flex gap-4">
            <select name="status" class="border rounded-xl px-4 py-3">
                <option value="">All Payments</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Paid</option>
            </select>

            <button class="bg-slate-950 text-white px-6 py-3 rounded-xl">
                Filter
            </button>
        </form>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-950 text-white">
                    <tr>
                        <th class="p-4 text-left">Customer</th>
                        <th class="p-4 text-left">Room</th>
                        <th class="p-4 text-left">Amount</th>
                        <th class="p-4 text-left">Method</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Date</th>
                        <th class="p-4 text-left">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="p-4">
                                <p class="font-bold">{{ $payment->booking->user->name }}</p>
                                <p class="text-sm text-slate-500">{{ $payment->booking->user->email }}</p>
                            </td>

                            <td class="p-4">
                                {{ $payment->booking->room->room_type }}
                            </td>

                            <td class="p-4 font-bold">
                                Rs. {{ number_format($payment->amount, 2) }}
                            </td>

                            <td class="p-4">
                                {{ ucfirst($payment->payment_method) }}
                            </td>

                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>

                            <td class="p-4">
                                {{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '-' }}
                            </td>

                            <td class="p-4">
                                @if($payment->status == 'pending')
                                    <form method="POST" action="{{ route('admin.payments.confirm', $payment->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button class="bg-green-600 text-white px-4 py-2 rounded-lg">
                                            Confirm
                                        </button>
                                    </form>
                                @else
                                    <span class="text-green-600 font-semibold">Confirmed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-500">
                                No payments found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    </main>
</div>

</body>
</html>