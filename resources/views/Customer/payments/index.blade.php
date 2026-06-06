@extends('layouts.customer')

@section('title', 'My Payments')

@section('page-title', 'My Payments')

@section('page-subtitle', 'Manage your hotel payments and invoices.')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="grid md:grid-cols-4 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Total Paid</p>
            <i data-lucide="wallet" class="text-green-600"></i>
        </div>

        <h2 class="text-3xl font-extrabold text-green-600">
            Rs. {{ number_format($totalPaid, 2) }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Pending Amount</p>
            <i data-lucide="clock" class="text-yellow-500"></i>
        </div>

        <h2 class="text-3xl font-extrabold text-yellow-500">
            Rs. {{ number_format($pendingAmount, 2) }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Paid Invoices</p>
            <i data-lucide="file-text" class="text-blue-600"></i>
        </div>

        <h2 class="text-3xl font-extrabold text-blue-600">
            {{ $paidCount }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center mb-4">
            <p class="text-slate-500">Last Payment</p>
            <i data-lucide="calendar-check" class="text-purple-600"></i>
        </div>

        <h2 class="text-xl font-extrabold text-slate-800">
            {{ $lastPayment && $lastPayment->payment_date ? $lastPayment->payment_date->format('Y-m-d') : 'N/A' }}
        </h2>
    </div>

</div>

<div class="grid lg:grid-cols-2 gap-6">
    @forelse($payments as $payment)

        <div class="bg-white rounded-3xl shadow p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">

            <div class="flex justify-between items-start mb-5">
                <div>
                    <p class="text-sm text-amber-500 font-bold mb-1">
                        Payment #{{ $payment->id }}
                    </p>

                    <h2 class="text-2xl font-extrabold">
                        {{ $payment->booking->room->room_type }}
                    </h2>

                    <p class="text-slate-500">
                        Booking #{{ $payment->booking->id }}
                    </p>
                </div>

                <span class="px-4 py-2 rounded-full text-sm font-semibold
                    {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div class="bg-slate-50 p-4 rounded-2xl">
                    <p class="text-slate-500">Amount</p>
                    <p class="font-bold text-green-600">
                        Rs. {{ number_format($payment->amount, 2) }}
                    </p>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl">
                    <p class="text-slate-500">Method</p>
                    <p class="font-bold">
                        {{ ucfirst($payment->payment_method) }}
                    </p>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl">
                    <p class="text-slate-500">Payment Date</p>
                    <p class="font-bold">
                        {{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : 'Not confirmed' }}
                    </p>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl">
                    <p class="text-slate-500">Invoice</p>
                    <p class="font-bold">
                        {{ $payment->status == 'paid' ? 'Available' : 'Pending' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                @if($payment->status == 'pending')
                    <form method="POST"
                          action="{{ route('customer.payments.pay', $payment->id) }}"
                          class="flex flex-wrap gap-2">
                        @csrf
                        @method('PATCH')

                        <select name="payment_method" class="border rounded-xl px-4 py-3">
                            <option value="cash">Cash</option>
                            <option value="card">Card Demo</option>
                        </select>

                        <button class="bg-amber-400 text-slate-950 px-5 py-3 rounded-xl font-bold hover:bg-amber-300 transition">
                            Pay Now
                        </button>
                    </form>
                @endif

                <a href="{{ route('customer.payments.invoice', $payment->id) }}"
                   class="bg-slate-950 text-white px-5 py-3 rounded-xl font-bold hover:bg-slate-800 transition">
                    Invoice
                </a>
            </div>

        </div>

    @empty

        <div class="lg:col-span-2 bg-white p-10 rounded-3xl shadow text-center">
            <h2 class="text-2xl font-bold mb-2">No payments yet</h2>
            <p class="text-slate-500">
                Payments appear after admin approves your booking.
            </p>
        </div>

    @endforelse
</div>

<div class="mt-8">
    {{ $payments->links() }}
</div>

@endsection