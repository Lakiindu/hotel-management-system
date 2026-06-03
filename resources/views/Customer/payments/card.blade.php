<!DOCTYPE html>
<html>
<head>
    <title>Demo Card Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

<div class="min-h-screen flex items-center justify-center px-6">

    <div class="max-w-5xl w-full grid md:grid-cols-2 gap-8">

        <div class="bg-slate-950 text-white p-8 rounded-3xl shadow">
            <h1 class="text-3xl font-bold mb-4">RoyalStay Demo Gateway</h1>
            <p class="text-slate-300 mb-8">Secure demo card payment screen</p>

            <div class="bg-white/10 p-6 rounded-2xl mb-6">
                <p class="text-slate-300">Room</p>
                <h2 class="text-2xl font-bold">{{ $payment->booking->room->room_type }}</h2>
            </div>

            <div class="bg-white/10 p-6 rounded-2xl mb-6">
                <p class="text-slate-300">Booking ID</p>
                <h2 class="text-xl font-bold">#{{ $payment->booking->id }}</h2>
            </div>

            <div class="bg-amber-400 text-slate-950 p-6 rounded-2xl">
                <p class="font-semibold">Amount to Pay</p>
                <h2 class="text-4xl font-extrabold">
                    Rs. {{ number_format($payment->amount, 2) }}
                </h2>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl shadow">

            <h2 class="text-3xl font-bold mb-2">Card Payment</h2>
            <p class="text-slate-500 mb-6">Use demo card details for testing.</p>

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
                    <ul class="list-disc ml-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-blue-50 text-blue-700 p-4 rounded-xl mb-6 text-sm">
                Demo Card: 4111 1111 1111 1111 <br>
                Expiry: 12/28 <br>
                CVV: 123
            </div>

            <form method="POST" action="{{ route('customer.payments.card.process', $payment->id) }}">
                @csrf

                <label class="font-semibold">Card Holder Name</label>
                <input type="text" name="card_holder"
                       placeholder="Lakindu Perera"
                       class="w-full border p-3 rounded-xl mb-4"
                       value="{{ old('card_holder') }}">

                <label class="font-semibold">Card Number</label>
                <input type="text" name="card_number"
                       placeholder="4111 1111 1111 1111"
                       class="w-full border p-3 rounded-xl mb-4"
                       value="{{ old('card_number') }}">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold">Expiry Date</label>
                        <input type="text" name="expiry_date"
                               placeholder="12/28"
                               class="w-full border p-3 rounded-xl mb-4"
                               value="{{ old('expiry_date') }}">
                    </div>

                    <div>
                        <label class="font-semibold">CVV</label>
                        <input type="password" name="cvv"
                               placeholder="123"
                               class="w-full border p-3 rounded-xl mb-4">
                    </div>
                </div>

                <button class="w-full bg-amber-400 text-slate-950 py-3 rounded-xl font-bold hover:bg-amber-300">
                    Pay Now
                </button>

                <a href="{{ route('customer.payments.index') }}"
                   class="block text-center mt-4 text-slate-500">
                    Cancel Payment
                </a>
            </form>
        </div>

    </div>
</div>

</body>
</html>