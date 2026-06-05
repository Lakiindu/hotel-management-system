@extends('layouts.admin')

@section('title', 'Payment Management')

@section('page-title', 'Payment Management')

@section('page-subtitle', 'Manage hotel payments and confirm customer transactions.')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<form method="GET"
      class="bg-white p-5 rounded-3xl shadow mb-6 flex flex-col md:flex-row gap-4">

    <select name="status"
            class="border rounded-2xl px-4 py-3">

        <option value="">All Payments</option>

        <option value="pending"
            {{ $status == 'pending' ? 'selected' : '' }}>
            Pending
        </option>

        <option value="paid"
            {{ $status == 'paid' ? 'selected' : '' }}>
            Paid
        </option>

    </select>

    <button class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold">
        Filter
    </button>

</form>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">

    <div class="overflow-x-auto">

        <table class="w-full min-w-[1000px]">

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
                            <p class="font-bold">
                                {{ $payment->booking->user->name }}
                            </p>

                            <p class="text-sm text-slate-500">
                                {{ $payment->booking->user->email }}
                            </p>
                        </td>

                        <td class="p-4">
                            {{ $payment->booking->room->room_type }}
                        </td>

                        <td class="p-4 font-bold text-green-600">
                            Rs. {{ number_format($payment->amount, 2) }}
                        </td>

                        <td class="p-4">
                            {{ ucfirst($payment->payment_method) }}
                        </td>

                        <td class="p-4">

                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($payment->status) }}
                            </span>

                        </td>

                        <td class="p-4">
                            {{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '-' }}
                        </td>

                        <td class="p-4">

                            @if($payment->status == 'pending')

                                <form method="POST"
                                      action="{{ route('admin.payments.confirm', $payment->id) }}">
                                    @csrf
                                    @method('PATCH')

                                    <button class="bg-green-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-green-700">
                                        Confirm
                                    </button>
                                </form>

                            @else

                                <span class="text-green-600 font-bold">
                                    Confirmed
                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="7"
                            class="p-8 text-center text-slate-500">
                            No payments found.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<div class="mt-6">
    {{ $payments->links() }}
</div>

@endsection