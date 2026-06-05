@extends('layouts.admin')

@section('title', 'Manage Bookings')

@section('page-title', 'Booking Management')

@section('page-subtitle', 'Approve, cancel, check-in and complete bookings.')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<form method="GET" class="bg-white p-5 rounded-3xl shadow mb-6 flex flex-col md:flex-row gap-4">
    <select name="status" class="border rounded-2xl px-4 py-3">
        <option value="">All Bookings</option>
        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved</option>
        <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        <option value="checked_in" {{ $status == 'checked_in' ? 'selected' : '' }}>Checked In</option>
        <option value="checked_out" {{ $status == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
        <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Completed</option>
    </select>

    <button class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold">
        Filter
    </button>
</form>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1100px]">
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
                            <span class="text-slate-400">to</span>
                            <br>
                            {{ $booking->check_out_date->format('Y-m-d') }}
                        </td>

                        <td class="p-4">{{ $booking->guests }}</td>

                        <td class="p-4 font-bold">
                            Rs. {{ number_format($booking->total_amount, 2) }}
                        </td>

                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
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

                                <select name="status" class="border rounded-xl px-3 py-2">
                                    <option value="approved">Approve</option>
                                    <option value="cancelled">Cancel</option>
                                    <option value="checked_in">Check In</option>
                                    <option value="checked_out">Check Out</option>
                                    <option value="completed">Complete</option>
                                </select>

                                <button type="button"
                                        class="update-btn bg-blue-600 text-white px-4 py-2 rounded-xl font-bold">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-8 text-center text-slate-500">
                            No bookings found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $bookings->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
@endpush