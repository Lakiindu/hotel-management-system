<!DOCTYPE html>
<html>
<head>
    <title>Manage Bookings</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Booking Management</h2>
                <p class="text-slate-500">Approve, cancel, check-in and complete bookings</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="bg-white p-5 rounded-2xl shadow mb-6 flex gap-4">
            <select name="status" class="border rounded-xl px-4 py-3">
                <option value="">All Bookings</option>
                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="checked_in" {{ $status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                <option value="checked_out" {{ $status == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
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
                        <th class="p-4 text-left">Dates</th>
                        <th class="p-4 text-left">Guests</th>
                        <th class="p-4 text-left">Amount</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($bookings as $booking)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="p-4">
                                <p class="font-bold">{{ $booking->user->name }}</p>
                                <p class="text-sm text-slate-500">{{ $booking->user->email }}</p>
                            </td>

                            <td class="p-4">
                                <p class="font-bold">{{ $booking->room->room_type }}</p>
                                <p class="text-sm text-slate-500">{{ $booking->room->room_number }}</p>
                            </td>

                            <td class="p-4 text-sm">
                                {{ $booking->check_in_date->format('Y-m-d') }}
                                <br>
                                to
                                <br>
                                {{ $booking->check_out_date->format('Y-m-d') }}
                            </td>

                            <td class="p-4">{{ $booking->guests }}</td>

                            <td class="p-4 font-bold">
                                Rs. {{ number_format($booking->total_amount, 2) }}
                            </td>

                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                    {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $booking->status == 'checked_in' ? 'bg-purple-100 text-purple-700' : '' }}
                                    {{ $booking->status == 'checked_out' ? 'bg-indigo-100 text-indigo-700' : '' }}
                                    {{ $booking->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}">
                                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>

                            <td class="p-4">
                                <form method="POST"
                                      action="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                      class="status-form flex gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <select name="status" class="border rounded-lg px-3 py-2">
                                        <option value="approved">Approve</option>
                                        <option value="cancelled">Cancel</option>
                                        <option value="checked_in">Check In</option>
                                        <option value="checked_out">Check Out</option>
                                        <option value="completed">Complete</option>
                                    </select>

                                    <button type="button"
                                            class="update-btn bg-blue-600 text-white px-4 py-2 rounded-lg">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-slate-500">
                                No bookings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>

    </main>
</div>

<script>
    document.querySelectorAll('.update-btn').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: 'Update booking status?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = this.closest('form');
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success', data.message, 'success')
                                .then(() => location.reload());
                        } else {
                            Swal.fire('Error', 'Could not update booking status.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    });
                }
            });
        });
    });
</script>

</body>
</html>