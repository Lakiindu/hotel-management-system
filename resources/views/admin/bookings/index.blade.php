@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('page-title', 'Booking Management')

@section('page-subtitle', 'Approve, cancel, check-in and complete bookings.')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Total Bookings</p>
        <h2 class="text-3xl font-extrabold text-blue-600">
            {{ $bookings->total() }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-yellow-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Pending</p>
        <h2 class="text-3xl font-extrabold text-yellow-500">
            {{ \App\Models\Booking::where('status', 'pending')->count() }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-green-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Completed</p>
        <h2 class="text-3xl font-extrabold text-green-600">
            {{ \App\Models\Booking::where('status', 'completed')->count() }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-purple-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Booking Revenue</p>
        <h2 class="text-2xl font-extrabold text-purple-600">
            Rs. {{ number_format(\App\Models\Booking::sum('total_amount'), 2) }}
        </h2>
    </div>

</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-5 rounded-3xl shadow mb-6 grid md:grid-cols-3 gap-4">
    <input type="text"
           id="bookingSearch"
           placeholder="Search customer, email, room..."
           class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

    <select id="bookingStatus"
            class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
        <option value="">All Bookings</option>
        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        <option value="checked_in" {{ $status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
        <option value="checked_out" {{ $status == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>

    <button type="button"
            id="bookingReset"
            class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-800 transition">
        Reset
    </button>
</div>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1200px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-5 text-left">Booking</th>
                    <th class="p-5 text-left">Customer</th>
                    <th class="p-5 text-left">Room</th>
                    <th class="p-5 text-left">Dates</th>
                    <th class="p-5 text-left">Guests</th>
                    <th class="p-5 text-left">Amount</th>
                    <th class="p-5 text-left">Status</th>
                    <th class="p-5 text-left">Action</th>
                </tr>
            </thead>

            <tbody id="bookingsTableBody">
                @forelse($bookings as $booking)
                    <tr class="border-b hover:bg-slate-50 transition">
                        <td class="p-5">
                            <p class="font-extrabold text-blue-600">
                                #{{ $booking->id }}
                            </p>
                            <p class="text-sm text-slate-500">
                                {{ $booking->created_at->format('Y-m-d') }}
                            </p>
                        </td>

                        <td class="p-5">
                            <p class="font-bold">{{ $booking->user?->name ?? 'Deleted User' }}</p>
                            <p class="text-sm text-slate-500">{{ $booking->user?->email ?? '-' }}</p>
                        </td>

                        <td class="p-5">
                            <p class="font-bold">{{ $booking->room->room_type }}</p>
                            <p class="text-sm text-slate-500">Room No: {{ $booking->room->room_number }}</p>
                        </td>

                        <td class="p-5 text-sm">
                            <div class="bg-slate-50 rounded-2xl p-3">
                                <p><span class="text-slate-500">In:</span> <strong>{{ $booking->check_in_date->format('Y-m-d') }}</strong></p>
                                <p><span class="text-slate-500">Out:</span> <strong>{{ $booking->check_out_date->format('Y-m-d') }}</strong></p>
                            </div>
                        </td>

                        <td class="p-5">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $booking->guests }} Guests
                            </span>
                        </td>

                        <td class="p-5 font-bold text-purple-600">
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

                        <td class="p-5">
                            <form method="POST"
                                  action="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                  class="status-form flex gap-2">
                                @csrf
                                @method('PATCH')

                                <select name="status" class="border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                    <option value="approved">Approve</option>
                                    <option value="cancelled">Cancel</option>
                                    <option value="checked_in">Check In</option>
                                    <option value="checked_out">Check Out</option>
                                    <option value="completed">Complete</option>
                                </select>

                                <button type="button"
                                        class="update-btn bg-blue-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-blue-700 transition">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="p-10 text-center text-slate-500">
                            No bookings found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6" id="bookingsPagination">
    {{ $bookings->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const bookingSearch = document.getElementById('bookingSearch');
const bookingStatus = document.getElementById('bookingStatus');
const bookingReset = document.getElementById('bookingReset');
const bookingsTableBody = document.getElementById('bookingsTableBody');
const bookingsPagination = document.getElementById('bookingsPagination');

function statusClass(status) {
    if (status === 'pending') return 'bg-yellow-100 text-yellow-700';
    if (status === 'approved') return 'bg-blue-100 text-blue-700';
    if (status === 'cancelled') return 'bg-red-100 text-red-700';
    if (status === 'checked_in') return 'bg-purple-100 text-purple-700';
    if (status === 'checked_out') return 'bg-indigo-100 text-indigo-700';
    if (status === 'completed') return 'bg-green-100 text-green-700';
    return 'bg-slate-100 text-slate-700';
}

function formatStatus(status) {
    return status ? status.replace('_', ' ').replace(/\b\w/g, char => char.toUpperCase()) : '-';
}

function formatDate(dateValue) {
    return dateValue ? dateValue.substring(0, 10) : '-';
}

function attachBookingUpdateEvents() {
    document.querySelectorAll('.update-btn').forEach(button => {
        button.onclick = function () {
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
            .then(async response => {
                const data = await response.json();

                if (!response.ok) {
                    console.log(data);

                    let errorMessage = data.message || 'Could not update booking status.';

                    if (data.errors) {
                        errorMessage = Object.values(data.errors).flat().join('\n');
                    }

                    Swal.fire('Error', errorMessage, 'error');
                    return;
                }

                if (data.success) {
                    Swal.fire('Success', data.message, 'success')
                        .then(() => window.location.reload());
                } else {
                    Swal.fire('Error', 'Could not update booking status.', 'error');
                }
            })
            .catch(error => {
                console.log(error);
                Swal.fire('Error', 'Something went wrong. Check console/logs.', 'error');
            });
                            }
                        });
                    };
                });
            }

function loadAdminBookings() {
    const search = bookingSearch.value;
    const status = bookingStatus.value;

    bookingsTableBody.innerHTML = `
        <tr>
            <td colspan="8" class="p-10 text-center text-slate-500">
                Loading bookings...
            </td>
        </tr>
    `;

    fetch(`{{ route('admin.ajax.bookings') }}?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`, {
        headers: { 'Accept': 'application/json' }
    })
    .then(response => response.json())
    .then(data => {
        bookingsTableBody.innerHTML = '';
        bookingsPagination.innerHTML = '';

        if (!data.success || data.bookings.length === 0) {
            bookingsTableBody.innerHTML = `
                <tr>
                    <td colspan="8" class="p-10 text-center text-slate-500">
                        No bookings found.
                    </td>
                </tr>
            `;
            return;
        }

        data.bookings.forEach(booking => {
            const userName = booking.user ? booking.user.name : 'Deleted User';
            const userEmail = booking.user ? booking.user.email : '-';
            const roomType = booking.room ? booking.room.room_type : 'Deleted Room';
            const roomNumber = booking.room ? booking.room.room_number : '-';

            bookingsTableBody.innerHTML += `
                <tr class="border-b hover:bg-slate-50 transition">
                    <td class="p-5">
                        <p class="font-extrabold text-blue-600">#${booking.id}</p>
                        <p class="text-sm text-slate-500">${formatDate(booking.created_at)}</p>
                    </td>

                    <td class="p-5">
                        <p class="font-bold">${userName}</p>
                        <p class="text-sm text-slate-500">${userEmail}</p>
                    </td>

                    <td class="p-5">
                        <p class="font-bold">${roomType}</p>
                        <p class="text-sm text-slate-500">Room No: ${roomNumber}</p>
                    </td>

                    <td class="p-5 text-sm">
                        <div class="bg-slate-50 rounded-2xl p-3">
                            <p><span class="text-slate-500">In:</span> <strong>${formatDate(booking.check_in_date)}</strong></p>
                            <p><span class="text-slate-500">Out:</span> <strong>${formatDate(booking.check_out_date)}</strong></p>
                        </div>
                    </td>

                    <td class="p-5">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                            ${booking.guests} Guests
                        </span>
                    </td>

                    <td class="p-5 font-bold text-purple-600">
                        Rs. ${Number(booking.total_amount).toLocaleString()}
                    </td>

                    <td class="p-5">
                        <span class="px-4 py-2 rounded-full text-sm font-bold ${statusClass(booking.status)}">
                            ${formatStatus(booking.status)}
                        </span>
                    </td>

                    <td class="p-5">
                        <form method="POST"
                              action="/admin/bookings/${booking.id}/status"
                              class="status-form flex gap-2">
                            @csrf
                            @method('PATCH')

                            <select name="status" class="border border-slate-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                                <option value="approved">Approve</option>
                                <option value="cancelled">Cancel</option>
                                <option value="checked_in">Check In</option>
                                <option value="checked_out">Check Out</option>
                                <option value="completed">Complete</option>
                            </select>

                            <button type="button"
                                    class="update-btn bg-blue-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-blue-700 transition">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
            `;
        });

        attachBookingUpdateEvents();
    })
    .catch(() => {
        Swal.fire('Error', 'Failed to load bookings.', 'error');
    });
}

bookingSearch.addEventListener('keyup', loadAdminBookings);
bookingStatus.addEventListener('change', loadAdminBookings);

bookingReset.addEventListener('click', function () {
    bookingSearch.value = '';
    bookingStatus.value = '';
    loadAdminBookings();
});

attachBookingUpdateEvents();
</script>
@endpush