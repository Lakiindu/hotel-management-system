<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="max-w-4xl mx-auto py-10 px-6">
    <div class="bg-white p-8 rounded-3xl shadow">

        <div class="flex justify-between border-b pb-6 mb-6">
            <div>
                <h1 class="text-3xl font-bold">RoyalStay Invoice</h1>
                <p class="text-slate-500">Hotel Management System</p>
            </div>

            <div class="text-right">
                <p class="font-bold">Invoice #{{ $payment->id }}</p>
                <p class="text-slate-500">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <h2 class="font-bold mb-2">Customer</h2>
                <p>{{ $payment->booking->user->name }}</p>
                <p>{{ $payment->booking->user->email }}</p>
            </div>

            <div>
                <h2 class="font-bold mb-2">Booking</h2>
                <p>Booking ID: #{{ $payment->booking->id }}</p>
                <p>Room: {{ $payment->booking->room->room_type }}</p>
            </div>
        </div>

        <table class="w-full mb-6">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-4 text-left">Description</th>
                    <th class="p-4 text-left">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b">
                    <td class="p-4">
                        Hotel room booking from
                        {{ $payment->booking->check_in_date->format('Y-m-d') }}
                        to
                        {{ $payment->booking->check_out_date->format('Y-m-d') }}
                    </td>
                    <td class="p-4 font-bold">
                        Rs. {{ number_format($payment->amount, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="text-right">
            <p class="text-xl font-bold">
                Total: Rs. {{ number_format($payment->amount, 2) }}
            </p>

            <p class="mt-2">
                Status:
                <span class="px-3 py-1 rounded-full text-sm
                    {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </p>
        </div>

        <div class="mt-8 flex gap-3">
            <button onclick="window.print()" class="bg-blue-600 text-white px-5 py-3 rounded-xl">
                Print Invoice
            </button>

            <a href="{{ route('customer.payments.index') }}" class="bg-slate-200 px-5 py-3 rounded-xl">
                Back
            </a>
        </div>
    </div>
</div>

</body>
</html>