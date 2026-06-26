@extends('layouts.customer')

@section('title', 'PayHere Payment')
@section('page-title', 'PayHere Payment')
@section('page-subtitle', 'Redirecting you to PayHere Sandbox for secure payment.')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-8 rounded-[2rem] shadow text-center">

    <div class="mb-6">
        <h1 class="text-3xl font-extrabold text-slate-900 mb-2">
            Redirecting to PayHere...
        </h1>
        <p class="text-slate-500">
            Please wait. You will be redirected to the secure PayHere Sandbox payment page.
        </p>
    </div>

    <div class="bg-slate-950 text-white p-6 rounded-3xl mb-6 text-left">
        <p class="text-slate-300">Room</p>
        <h2 class="text-2xl font-extrabold">
            {{ $payment->booking->room->room_type }}
        </h2>

        <div class="grid md:grid-cols-2 gap-4 mt-6">
            <div>
                <p class="text-slate-300">Booking ID</p>
                <h3 class="font-bold">#{{ $payment->booking->id }}</h3>
            </div>

            <div>
                <p class="text-slate-300">Payment ID</p>
                <h3 class="font-bold">#{{ $payment->id }}</h3>
            </div>
        </div>

        <div class="bg-amber-400 text-slate-950 p-5 rounded-2xl mt-6">
            <p class="font-semibold">Amount to Pay</p>
            <h2 class="text-3xl font-extrabold">
                Rs. {{ number_format($payment->amount, 2) }}
            </h2>
        </div>
    </div>

    <form method="POST" action="{{ config('payhere.checkout_url') }}" id="payhere-form">
        <input type="hidden" name="merchant_id" value="{{ $merchantId }}">
        <input type="hidden" name="return_url" value="{{ route('customer.payments.success', $payment->id) }}">
        <input type="hidden" name="cancel_url" value="{{ route('customer.payments.cancelPayhere', $payment->id) }}">
        <input type="hidden" name="notify_url" value="{{ config('app.url') . route('payhere.notify', [], false) }}">

        <input type="hidden" name="order_id" value="{{ $orderId }}">
        <input type="hidden" name="items" value="RoyalStay Hotel Booking #{{ $payment->booking->id }}">
        <input type="hidden" name="currency" value="{{ $currency }}">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="hash" value="{{ $hash }}">

        <input type="hidden" name="first_name" value="{{ $payment->booking->user->name }}">
        <input type="hidden" name="last_name" value="Customer">
        <input type="hidden" name="email" value="{{ $payment->booking->user->email }}">
        <input type="hidden" name="phone" value="0771234567">
        <input type="hidden" name="address" value="RoyalStay Hotel Customer">
        <input type="hidden" name="city" value="Colombo">
        <input type="hidden" name="country" value="Sri Lanka">

        <button type="submit"
            class="bg-amber-400 text-slate-950 px-8 py-3 rounded-xl font-bold hover:bg-amber-300">
            Continue to PayHere
        </button>
    </form>

    <a href="{{ route('customer.payments.index') }}" class="block mt-5 text-slate-500">
        Cancel Payment
    </a>
</div>

<script>
    setTimeout(function () {
        document.getElementById('payhere-form').submit();
    }, 2000);
</script>

@endsection