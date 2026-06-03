<!DOCTYPE html>
<html>
<head>
    <title>My Payments</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="max-w-7xl mx-auto py-10 px-6">
    <h1 class="text-4xl font-bold mb-6">My Payments</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-4 text-left">Room</th>
                    <th class="p-4 text-left">Amount</th>
                    <th class="p-4 text-left">Method</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($payments as $payment)
                    <tr class="border-b">
                        <td class="p-4">
                            <p class="font-bold">{{ $payment->booking->room->room_type }}</p>
                            <p class="text-sm text-slate-500">Booking #{{ $payment->booking->id }}</p>
                        </td>

                        <td class="p-4 font-bold">
                            Rs. {{ number_format($payment->amount, 2) }}
                        </td>

                        <td class="p-4">
                            {{ ucfirst($payment->payment_method) }}
                        </td>

                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-sm
                                {{ $payment->status == 'paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>

                        <td class="p-4">
                            @if($payment->status == 'pending')
                                <form method="POST" action="{{ route('customer.payments.pay', $payment->id) }}" class="flex gap-2">
                                    @csrf
                                    @method('PATCH')

                                    <select name="payment_method" class="border rounded-lg px-3 py-2">
                                        <option value="cash">Cash</option>
                                        <option value="card">Card Demo</option>
                                    </select>

                                    <button class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                        Pay
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('customer.payments.invoice', $payment->id) }}"
                               class="inline-block mt-2 bg-slate-950 text-white px-4 py-2 rounded-lg">
                                Invoice
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-slate-500">
                            No payments found. Payment appears after admin approves booking.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $payments->links() }}
    </div>
</div>

</body>
</html>