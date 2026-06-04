<!DOCTYPE html>
<html>
<head>
    <title>Demo Card Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100 text-slate-900">

<div class="flex min-h-screen">

    <aside class="w-72 bg-slate-950 text-white p-6 hidden lg:flex flex-col justify-between">
        <div>
            <h1 class="text-3xl font-extrabold mb-10">
                RoyalStay<span class="text-amber-400">.</span>
            </h1>

            <nav class="space-y-3">
                <a href="{{ route('customer.dashboard') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">Dashboard</a>
                <a href="{{ route('rooms') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">Browse Rooms</a>
                <a href="{{ route('customer.bookings.index') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">My Bookings</a>
                <a href="{{ route('customer.payments.index') }}" class="block bg-amber-400 text-slate-950 px-5 py-3 rounded-2xl font-bold">Payments</a>
                <a href="{{ route('customer.profile.edit') }}" class="block hover:bg-slate-800 px-5 py-3 rounded-2xl">Profile</a>
            </nav>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full bg-red-500 text-white px-5 py-3 rounded-2xl font-bold hover:bg-red-600">
                Logout
            </button>
        </form>
    </aside>

    <main class="flex-1 p-6 lg:p-10">

        <div class="mb-8">
            <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
                Demo Gateway
            </p>

            <h1 class="text-4xl font-extrabold">
                Card Payment
            </h1>

            <p class="text-slate-500 mt-2">
                This is a safe demo card payment screen for project testing.
            </p>
        </div>

        <div class="grid lg:grid-cols-2 gap-8">

            <div class="bg-slate-950 text-white p-8 rounded-[2rem] shadow">
                <h1 class="text-3xl font-extrabold mb-4">
                    RoyalStay Demo Gateway
                </h1>

                <p class="text-slate-300 mb-8">
                    Complete your demo card payment securely.
                </p>

                <div class="bg-white/10 p-6 rounded-3xl mb-6">
                    <p class="text-slate-300">Room</p>

                    <h2 class="text-2xl font-extrabold">
                        {{ $payment->booking->room->room_type }}
                    </h2>

                    <p class="text-slate-300 mt-1">
                        Room No: {{ $payment->booking->room->room_number }}
                    </p>
                </div>

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

                <div class="bg-amber-400 text-slate-950 p-6 rounded-3xl">
                    <p class="font-semibold">Amount to Pay</p>

                    <h2 class="text-4xl font-extrabold">
                        Rs. {{ number_format($payment->amount, 2) }}
                    </h2>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2rem] shadow">

                <h2 class="text-3xl font-extrabold mb-2">
                    Enter Card Details
                </h2>

                <p class="text-slate-500 mb-6">
                    Use the demo card details below for testing.
                </p>

                @if($errors->any())
                    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-5">
                        <ul class="list-disc ml-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="bg-blue-50 text-blue-700 p-4 rounded-2xl mb-6 text-sm">
                    <strong>Demo Card:</strong> 4111 1111 1111 1111 <br>
                    <strong>Expiry:</strong> 12/28 <br>
                    <strong>CVV:</strong> 123
                </div>

                <form method="POST" action="{{ route('customer.payments.card.process', $payment->id) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="font-semibold">Card Holder Name</label>
                        <input type="text" name="card_holder"
                               placeholder="Lakindu Perera"
                               class="w-full border p-3 rounded-xl mt-2"
                               value="{{ old('card_holder') }}">
                    </div>

                    <div class="mb-4">
                        <label class="font-semibold">Card Number</label>
                        <input type="text" name="card_number"
                               placeholder="4111 1111 1111 1111"
                               class="w-full border p-3 rounded-xl mt-2"
                               value="{{ old('card_number') }}">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="font-semibold">Expiry Date</label>
                            <input type="text" name="expiry_date"
                                   placeholder="12/28"
                                   class="w-full border p-3 rounded-xl mt-2"
                                   value="{{ old('expiry_date') }}">
                        </div>

                        <div>
                            <label class="font-semibold">CVV</label>
                            <input type="password" name="cvv"
                                   placeholder="123"
                                   class="w-full border p-3 rounded-xl mt-2">
                        </div>
                    </div>

                    <button class="w-full mt-6 bg-amber-400 text-slate-950 py-3 rounded-xl font-bold hover:bg-amber-300">
                        Pay Now
                    </button>

                    <a href="{{ route('customer.payments.index') }}"
                       class="block text-center mt-4 text-slate-500">
                        Cancel Payment
                    </a>
                </form>
            </div>

        </div>

    </main>

</div>

</body>
</html>