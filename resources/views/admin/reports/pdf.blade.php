<!DOCTYPE html>
<html>
<head>
    <title>Hotel Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        .subtitle {
            color: #6b7280;
            margin-bottom: 20px;
        }

        .summary {
            margin-bottom: 20px;
            padding: 12px;
            background: #f3f4f6;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #020617;
            color: white;
            padding: 8px;
            text-align: left;
        }

        td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px;
        }
    </style>
</head>
<body>

<h1>RoyalStay Hotel Report</h1>

<p class="subtitle">
    @if($startDate && $endDate)
        Report Period: {{ $startDate }} to {{ $endDate }}
    @else
        Full Report
    @endif
</p>

<div class="summary">
    <strong>Total Bookings:</strong> {{ $bookings->count() }} <br>
    <strong>Total Revenue:</strong> Rs. {{ number_format($totalRevenue, 2) }}
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Customer</th>
            <th>Room</th>
            <th>Dates</th>
            <th>Amount</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>#{{ $booking->id }}</td>
                <td>{{ $booking->user->name }}</td>
                <td>{{ $booking->room->room_type }}</td>
                <td>
                    {{ $booking->check_in_date->format('Y-m-d') }}
                    to
                    {{ $booking->check_out_date->format('Y-m-d') }}
                </td>
                <td>Rs. {{ number_format($booking->total_amount, 2) }}</td>
                <td>{{ ucwords(str_replace('_', ' ', $booking->status)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>