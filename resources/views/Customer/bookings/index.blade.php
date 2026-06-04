<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-100">

<div class="max-w-7xl mx-auto py-10 px-6">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-4xl font-bold text-slate-800">My Bookings</h1>
            <p class="text-slate-500">View and manage your hotel bookings</p>
        </div>

        <a href="{{ route('rooms') }}" class="bg-amber-400 text-slate-950 px-5 py-3 rounded-xl font-bold">
            Browse Rooms
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-4 text-left">Room</th>
                    <th class="p-4 text-left">Check-In</th>
                    <th class="p-4 text-left">Check-Out</th>
                    <th class="p-4 text-left">Guests</th>
                    <th class="p-4 text-left">Amount</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($bookings as $booking)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-4">
                            <p class="font-bold">{{ $booking->room->room_type }}</p>
                            <p class="text-sm text-slate-500">{{ $booking->room->room_number }}</p>
                        </td>

                        <td class="p-4">{{ $booking->check_in_date->format('Y-m-d') }}</td>
                        <td class="p-4">{{ $booking->check_out_date->format('Y-m-d') }}</td>
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

                        <td class="p-4 flex gap-2">

                            <a href="{{ route('customer.bookings.show', $booking->id) }}"
                               class="bg-slate-950 text-white px-4 py-2 rounded-lg">
                                View
                            </a>

                            @if($booking->status === 'completed' && !$booking->review)
                                <a href="{{ route('customer.reviews.create', $booking->id) }}"
                                   class="bg-green-600 text-white px-4 py-2 rounded-lg">
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
                                            class="cancel-btn bg-red-500 text-white px-4 py-2 rounded-lg">
                                        Cancel
                                    </button>
                                </form>
                            @endif

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-6 text-center text-slate-500">
                            No bookings yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
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