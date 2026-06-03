<!DOCTYPE html>
<html>
<head>
    <title>Booking Details</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

<div class="max-w-6xl mx-auto py-10 px-6">

    <a href="{{ route('customer.bookings.index') }}" class="text-slate-500 hover:text-slate-900">
        ← Back to My Bookings
    </a>

    <div class="grid md:grid-cols-2 gap-8 mt-6">

        <div class="bg-white rounded-3xl shadow overflow-hidden">
            <img src="{{ $booking->room->image ? asset('storage/' . $booking->room->image) : 'https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=900&q=80' }}"
                 class="h-96 w-full object-cover">

            <div class="p-6">
                <h2 class="text-3xl font-bold">{{ $booking->room->room_type }}</h2>
                <p class="text-slate-500">Room No: {{ $booking->room->room_number }}</p>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow p-8">

            <h1 class="text-3xl font-bold mb-6">Booking Details</h1>

            <div class="space-y-4">
                <p><strong>Booking ID:</strong> #{{ $booking->id }}</p>
                <p><strong>Check-In:</strong> {{ $booking->check_in_date->format('Y-m-d') }}</p>
                <p><strong>Check-Out:</strong> {{ $booking->check_out_date->format('Y-m-d') }}</p>
                <p><strong>Guests:</strong> {{ $booking->guests }}</p>
                <p><strong>Total Amount:</strong> Rs. {{ number_format($booking->total_amount, 2) }}</p>

                <p>
                    <strong>Status:</strong>
                    <span class="px-3 py-1 rounded-full text-sm
                        {{ $booking->status == 'pending' ? 'bg-yellow-100 text-yellow-700' : '' }}
                        {{ $booking->status == 'approved' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $booking->status == 'cancelled' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $booking->status == 'checked_in' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $booking->status == 'checked_out' ? 'bg-indigo-100 text-indigo-700' : '' }}
                        {{ $booking->status == 'completed' ? 'bg-green-100 text-green-700' : '' }}">
                        {{ ucwords(str_replace('_', ' ', $booking->status)) }}
                    </span>
                </p>

                <p>
                    <strong>Special Requests:</strong>
                    {{ $booking->special_requests ?? 'No special requests' }}
                </p>
            </div>

            <div class="mt-8">
                <h2 class="text-xl font-bold mb-4">Booking Status Timeline</h2>

                @php
                    $steps = ['pending', 'approved', 'checked_in', 'checked_out', 'completed'];
                    $currentIndex = array_search($booking->status, $steps);
                @endphp

                @if($booking->status === 'cancelled')
                    <div class="bg-red-100 text-red-700 p-4 rounded-xl">
                        This booking has been cancelled.
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($steps as $index => $step)
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold
                                    {{ $index <= $currentIndex ? 'bg-green-500 text-white' : 'bg-slate-200 text-slate-500' }}">
                                    {{ $index <= $currentIndex ? '✓' : $index + 1 }}
                                </div>

                                <p class="font-semibold
                                    {{ $index <= $currentIndex ? 'text-slate-900' : 'text-slate-400' }}">
                                    {{ ucwords(str_replace('_', ' ', $step)) }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

</body>
</html>