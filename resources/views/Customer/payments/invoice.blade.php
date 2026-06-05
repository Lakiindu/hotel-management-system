@extends('layouts.customer')

@section('title', 'Invoice')
@section('page-title', 'Invoice Details')
@section('page-subtitle', 'View your hotel payment invoice and booking summary.')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="flex justify-end mb-6">
    <a href="{{ route('customer.payments.index') }}"
       class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold">
        ← Back to Payments
    </a>
</div>

<div class="bg-white rounded-[2rem] shadow overflow-hidden max-w-5xl mx-auto">

    <div class="bg-slate-950 text-white p-8 flex flex-col md:flex-row justify-between gap-6">
        <div>
            <h1 class="text-4xl font-extrabold">
                RoyalStay<span class="text-amber-400">.</span>
            </h1>
            <p class="text-slate-300 mt-2">Hotel Management System Invoice</p>
        </div>

        <div class="md:text-right">
            <p class="text-slate-300">Invoice Number</p>
            <h2 class="text-2xl font-bold">#INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</h2>

            <p class="text-slate-300 mt-3">Invoice Date</p>
            <p class="font-semibold">{{ now()->format('Y-m-d') }}</p>
        </div>
    </div>

    <div class="p-8">
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <div class="bg-slate-50 p-6 rounded-3xl">
                <p class="text-slate-500 mb-2">Billed To</p>
                <h2 class="text-xl font-extrabold">{{ $payment->booking->user->name }}</h2>
                <p class="text-slate-600">{{ $payment->booking->user->email }}</p>
                <p class="text-slate-600">{{ $payment->booking->user->phone ?? 'No phone number' }}</p>
            </div>

            <div class="bg-slate-50 p-6 rounded-3xl">
                <p class="text-slate-500 mb-2">Booking Information</p>
                <h2 class="text-xl font-extrabold">Booking #{{ $payment->booking->id }}</h2>
                <p class="text-slate-600">Room: {{ $payment->booking->room->room_type }}</p>
                <p class="text-slate-600">Room No: {{ $payment->booking->room->room_number }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-3xl border border-slate-200 mb-8">
            <table class="w-full">
                <thead class="bg-slate-950 text-white">
                    <tr>
                        <th class="p-4 text-left">Description</th>
                        <th class="p-4 text-left">Check-In</th>
                        <th class="p-4 text-left">Check-Out</th>
                        <th class="p-4 text-left">Amount</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="border-b">
                        <td class="p-4">Hotel room booking - {{ $payment->booking->room->room_type }}</td>
                        <td class="p-4">{{ $payment->booking->check_in_date->format('Y-m-d') }}</td>
                        <td class="p-4">{{ $payment->booking->check_out_date->format('Y-m-d') }}</td>
                        <td class="p-4 font-bold">Rs. {{ number_format($payment->amount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="grid md:grid-cols-2 gap-6 items-start">
            <div class="bg-slate-50 p-6 rounded-3xl">
                <p class="text-slate-500 mb-2">Payment Method</p>
                <h3 class="text-xl font-extrabold">{{ ucfirst($payment->payment_method) }}</h3>

                <p class="text-slate-500 mt-3">Payment Date</p>
                <p class="font-semibold">
                    {{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : 'Not confirmed yet' }}
                </p>
            </div>

            <div class="bg-amber-400 text-slate-950 p-6 rounded-3xl md:text-right">
                <p class="font-semibold">Total Amount</p>
                <h2 class="text-4xl font-extrabold">Rs. {{ number_format($payment->amount, 2) }}</h2>

                <span class="inline-block mt-4 px-4 py-2 rounded-full text-sm font-bold
                    {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap gap-3">
            <a href="{{ route('customer.payments.invoice.pdf', $payment->id) }}"
               class="bg-red-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-red-700">
                Download PDF
            </a>

            <a href="{{ route('customer.payments.invoice.csv', $payment->id) }}"
               class="bg-green-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-green-700">
                Download CSV
            </a>

            <a href="{{ route('customer.payments.index') }}"
               class="bg-slate-200 px-6 py-3 rounded-2xl font-bold hover:bg-slate-300">
                Back
            </a>
        </div>
    </div>
</div>

@endsection