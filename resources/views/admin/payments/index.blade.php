@extends('layouts.admin')

@section('title', 'Payment Management')
@section('page-title', 'Payment Management')
@section('page-subtitle', 'Manage hotel payments and confirm customer transactions.')

@section('content')

@php
    $totalPayments = \App\Models\Payment::count();
    $paidPayments = \App\Models\Payment::where('status', 'paid')->count();
    $pendingPayments = \App\Models\Payment::where('status', 'pending')->count();
    $totalPaidAmount = \App\Models\Payment::where('status', 'paid')->sum('amount');
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">
    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Total Payments</p>
        <h2 class="text-3xl font-extrabold text-blue-600">{{ $totalPayments }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-green-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Paid Payments</p>
        <h2 class="text-3xl font-extrabold text-green-600">{{ $paidPayments }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-yellow-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Pending Payments</p>
        <h2 class="text-3xl font-extrabold text-yellow-500">{{ $pendingPayments }}</h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-purple-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Total Revenue</p>
        <h2 class="text-2xl font-extrabold text-purple-600">
            Rs. {{ number_format($totalPaidAmount, 2) }}
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
           id="paymentSearch"
           placeholder="Search customer, booking ID, room..."
           class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

    <select id="paymentStatus"
            class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
        <option value="">All Payments</option>
        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="paid" {{ $status == 'paid' ? 'selected' : '' }}>Paid</option>
    </select>

    <button type="button" id="paymentReset"
            class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-800 transition">
        Reset
    </button>
</div>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1100px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-5 text-left">Payment</th>
                    <th class="p-5 text-left">Customer</th>
                    <th class="p-5 text-left">Booking</th>
                    <th class="p-5 text-left">Room</th>
                    <th class="p-5 text-left">Amount</th>
                    <th class="p-5 text-left">Method</th>
                    <th class="p-5 text-left">Status</th>
                    <th class="p-5 text-left">Date</th>
                    <th class="p-5 text-left">Action</th>
                </tr>
            </thead>

            <tbody id="paymentsTableBody">
                @forelse($payments as $payment)
                    <tr class="border-b hover:bg-slate-50 transition">
                        <td class="p-5">
                            <p class="font-extrabold text-blue-600">#{{ $payment->id }}</p>
                            <p class="text-sm text-slate-500">Payment ID</p>
                        </td>

                        <td class="p-5">
                            <p class="font-bold">{{ $payment->booking?->user?->name ?? 'Deleted User' }}</p>
                            <p class="text-sm text-slate-500">{{ $payment->booking?->user?->email ?? '-' }}</p>
                        </td>

                        <td class="p-5">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">
                                Booking #{{ $payment->booking->id }}
                            </span>
                        </td>

                        <td class="p-5">
                            <p class="font-semibold">{{ $payment->booking->room->room_type }}</p>
                            <p class="text-sm text-slate-500">{{ $payment->booking->room->room_number }}</p>
                        </td>

                        <td class="p-5 font-extrabold text-purple-600">
                            Rs. {{ number_format($payment->amount, 2) }}
                        </td>

                        <td class="p-5">
                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ ucfirst($payment->payment_method) }}
                            </span>
                        </td>

                        <td class="p-5">
                            <span class="px-4 py-2 rounded-full text-sm font-bold
                                {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>

                        <td class="p-5">
                            {{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '-' }}
                        </td>

                        <td class="p-5">
                            @if($payment->status == 'pending')
                                <form method="POST" action="{{ route('admin.payments.confirm', $payment->id) }}" class="confirm-form">
                                    @csrf
                                    @method('PATCH')

                                    <button type="button" class="confirm-btn bg-green-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-green-700 transition">
                                        Confirm
                                    </button>
                                </form>
                            @else
                                <span class="text-green-600 font-bold">Confirmed</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="p-10 text-center text-slate-500">
                            No payments found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6" id="paymentsPagination">
    {{ $payments->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const paymentSearch = document.getElementById('paymentSearch');
const paymentStatus = document.getElementById('paymentStatus');
const paymentReset = document.getElementById('paymentReset');
const paymentsTableBody = document.getElementById('paymentsTableBody');
const paymentsPagination = document.getElementById('paymentsPagination');

function paymentStatusClass(status) {
    if (status === 'paid') return 'bg-green-100 text-green-700';
    return 'bg-yellow-100 text-yellow-700';
}

function attachConfirmEvents() {
    document.querySelectorAll('.confirm-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Confirm this payment?',
                text: 'This will mark the payment as paid.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, confirm',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
}

function loadAdminPayments() {
    const search = paymentSearch.value;
    const status = paymentStatus.value;

    paymentsTableBody.innerHTML = `
        <tr>
            <td colspan="9" class="p-10 text-center text-slate-500">
                Loading payments...
            </td>
        </tr>
    `;

    fetch(`{{ route('admin.ajax.payments') }}?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        paymentsTableBody.innerHTML = '';
        paymentsPagination.innerHTML = '';

        if (data.payments.length === 0) {
            paymentsTableBody.innerHTML = `
                <tr>
                    <td colspan="9" class="p-10 text-center text-slate-500">
                        No payments found.
                    </td>
                </tr>
            `;
            return;
        }

        data.payments.forEach(payment => {
            let date = payment.payment_date ? payment.payment_date.substring(0, 10) : '-';

            let action = payment.status === 'pending'
                ? `
                    <form method="POST" action="/admin/payments/${payment.id}/confirm" class="confirm-form">
                        @csrf
                        @method('PATCH')

                        <button type="button" class="confirm-btn bg-green-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-green-700 transition">
                            Confirm
                        </button>
                    </form>
                `
                : `<span class="text-green-600 font-bold">Confirmed</span>`;

            paymentsTableBody.innerHTML += `
                <tr class="border-b hover:bg-slate-50 transition">
                    <td class="p-5">
                        <p class="font-extrabold text-blue-600">#${payment.id}</p>
                        <p class="text-sm text-slate-500">Payment ID</p>
                    </td>

                    <td class="p-5">
                        <p class="font-bold">${payment.booking.user.name}</p>
                        <p class="text-sm text-slate-500">${payment.booking.user.email}</p>
                    </td>

                    <td class="p-5">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">
                            Booking #${payment.booking.id}
                        </span>
                    </td>

                    <td class="p-5">
                        <p class="font-semibold">${payment.booking.room.room_type}</p>
                        <p class="text-sm text-slate-500">${payment.booking.room.room_number ?? ''}</p>
                    </td>

                    <td class="p-5 font-extrabold text-purple-600">
                        Rs. ${Number(payment.amount).toLocaleString()}
                    </td>

                    <td class="p-5">
                        <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm font-semibold">
                            ${payment.payment_method.charAt(0).toUpperCase() + payment.payment_method.slice(1)}
                        </span>
                    </td>

                    <td class="p-5">
                        <span class="px-4 py-2 rounded-full text-sm font-bold ${paymentStatusClass(payment.status)}">
                            ${payment.status.charAt(0).toUpperCase() + payment.status.slice(1)}
                        </span>
                    </td>

                    <td class="p-5">
                        ${date}
                    </td>

                    <td class="p-5">
                        ${action}
                    </td>
                </tr>
            `;
        });

        attachConfirmEvents();
    })
    .catch(() => {
        Swal.fire('Error', 'Failed to load payments.', 'error');
    });
}

paymentSearch.addEventListener('keyup', loadAdminPayments);
paymentStatus.addEventListener('change', loadAdminPayments);

paymentReset.addEventListener('click', function () {
    paymentSearch.value = '';
    paymentStatus.value = '';
    loadAdminPayments();
});

attachConfirmEvents();
</script>
@endpush