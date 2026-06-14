@extends('layouts.customer')

{{-- Page title shown in browser --}}
@section('title', 'Card Payment')

{{-- Dashboard page heading --}}
@section('page-title', 'Card Payment')

{{-- Page subtitle --}}
@section('page-subtitle', 'This is a safe demo card payment screen for project testing.')

@section('content')

{{-- Main page split into 2 sections --}}
<div class="grid lg:grid-cols-2 gap-8">

    {{-- Payment summary section --}}   
    <div class="bg-slate-950 text-white p-8 rounded-[2rem] shadow">

        {{-- Payment gateway heading --}}
        <h1 class="text-3xl font-extrabold mb-4">RoyalStay Demo Gateway</h1>
        <p class="text-slate-300 mb-8">Complete your demo card payment securely.</p>

        {{-- Room information --}}
        <div class="bg-white/10 p-6 rounded-3xl mb-6">
            <p class="text-slate-300">Room</p>
            <h2 class="text-2xl font-extrabold">{{ $payment->booking->room->room_type }}</h2>
            <p class="text-slate-300 mt-1">Room No: {{ $payment->booking->room->room_number }}</p>
        </div>

        {{-- Booking and Payment IDs --}}
        <div class="grid md:grid-cols-2 gap-4 mb-6">
            <div class="bg-white/10 p-6 rounded-3xl">
                <p class="text-slate-300">Booking ID</p>
                <h2 class="text-xl font-bold">#{{ $payment->booking->id }}</h2>
            </div>

            <div class="bg-white/10 p-6 rounded-3xl">
                <p class="text-slate-300">Payment ID</p>
                <h2 class="text-xl font-bold">#{{ $payment->id }}</h2>
            </div>
        </div>

        {{-- Amount customer must pay --}}
        <div class="bg-amber-400 text-slate-950 p-6 rounded-3xl">
            <p class="font-semibold">Amount to Pay</p>
            <h2 class="text-4xl font-extrabold">
                Rs. {{ number_format($payment->amount, 2) }}
            </h2>
        </div>
    </div>

    {{-- Card details section --}}
    <div class="bg-white p-8 rounded-[2rem] shadow">

        {{-- Form heading --}}
        <h2 class="text-3xl font-extrabold mb-2">Enter Card Details</h2>
        <p class="text-slate-500 mb-6">Use the demo card details below for testing.</p>

        {{-- Validation errors --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-5">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Demo card details for testing --}}
        <div class="bg-blue-50 text-blue-700 p-4 rounded-2xl mb-6 text-sm">
            <strong>Demo Card:</strong> 4111 1111 1111 1111 <br>
            <strong>Expiry:</strong> 12/28 <br>
            <strong>CVV:</strong> 123
        </div>

        {{-- Card payment form --}}
        <form method="POST" action="{{ route('customer.payments.card.process', $payment->id) }}">
            @csrf

            {{-- Card holder name --}}
            <div class="mb-4">
                <label class="font-semibold">Card Holder Name</label>

                <input
                    type="text"
                    name="card_holder"
                    placeholder="Lakindu Peiris"
                    class="w-full border p-3 rounded-xl mt-2"
                    value="{{ old('card_holder') }}">
            </div>

            {{-- Card number: only numbers allowed, maximum 16 digits --}}
<div class="mb-4">
    <label class="font-semibold">Card Number</label>

    <input
        type="text"
        name="card_number"
        placeholder="4111 1111 1111 1111"
        maxlength="19"
        inputmode="numeric"
        value="{{ old('card_number') }}"
        oninput="
            var value = this.value.replace(/\D/g, '').substring(0, 16);
            value = value.replace(/(.{4})/g, '$1 ').trim();
            this.value = value;
        "
        class="w-full border p-3 rounded-xl mt-2">
</div>

            {{-- Expiry date and CVV section --}}
            <div class="grid grid-cols-2 gap-4">

                {{-- Expiry date: MM/YY format --}}
                <div>
                    <label class="font-semibold">Expiry Date</label>

                    <input
                        type="text"
                        name="expiry_date"
                        placeholder="MM/YY"
                        maxlength="5"
                        value="{{ old('expiry_date') }}"
                        oninput="
                            var value = this.value.replace(/\D/g, '').substring(0, 4);

                            if (value.length > 2) {
                                value = value.substring(0, 2) + '/' + value.substring(2);
                            }

                            this.value = value;
                        "
                        class="w-full border p-3 rounded-xl mt-2">
                </div>

            {{-- CVV: only numbers allowed, maximum 3 digits --}}
            <div>
                <label class="font-semibold">CVV</label>

                <input
                    type="password"
                    name="cvv"
                    placeholder="123"
                    maxlength="3"
                    inputmode="numeric"
                    oninput="this.value = this.value.replace(/\D/g, '').substring(0, 3)"
                    class="w-full border p-3 rounded-xl mt-2">
            </div>
            </div>

            {{-- Payment submit button --}}
            <button class="w-full mt-6 bg-amber-400 text-slate-950 py-3 rounded-xl font-bold hover:bg-amber-300">
                Pay Now
            </button>

            {{-- Cancel payment link --}}
            <a href="{{ route('customer.payments.index') }}" class="block text-center mt-4 text-slate-500">
                Cancel Payment
            </a>
        </form>
    </div>

</div>

@endsection