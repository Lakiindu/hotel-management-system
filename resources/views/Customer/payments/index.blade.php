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

@php
    $totalPaid = $payments->where('status', 'paid')->sum('amount');
    $pendingAmount = $payments->where('status', 'pending')->sum('amount');
    $paidCount = $payments->where('status', 'paid')->count();
@endphp

<div class="grid md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Paid Amount</p>
        <h2 class="text-3xl font-extrabold text-green-600">
            Rs. {{ number_format($totalPaid, 2) }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Pending Amount</p>
        <h2 class="text-3xl font-extrabold text-yellow-500">
            Rs. {{ number_format($pendingAmount, 2) }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Paid Invoices</p>
        <h2 class="text-3xl font-extrabold text-blue-600">
            {{ $paidCount }}
        </h2>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    @forelse($payments as $payment)

        <div class="bg-white rounded-3xl shadow p-6 hover:-translate-y-1 transition">

            <div class="flex justify-between items-start mb-5">
                <div>
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
                    <p class="font-bold">
                        Rs. {{ number_format($payment->amount, 2) }}
                    </p>
                </div>

                <div class="bg-slate-50 p-4 rounded-2xl">
                    <p class="text-slate-500">Method</p>
                    <p class="font-bold">
                        {{ ucfirst($payment->payment_method) }}
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

                        <button class="bg-amber-400 text-slate-950 px-5 py-3 rounded-xl font-bold">
                            Pay Now
                        </button>
                    </form>
                @endif

                <a href="{{ route('customer.payments.invoice', $payment->id) }}"
                   class="bg-slate-950 text-white px-5 py-3 rounded-xl font-bold">
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