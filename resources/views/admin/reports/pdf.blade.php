<!DOCTYPE html>
<html>

<head>

    {{-- PDF Report Title --}}
    <title>Hotel Report</title>

    <style>

        /* Overall PDF styling */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        /* Main report heading */
        h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }

        /* Report period text */
        .subtitle {
            color: #6b7280;
            margin-bottom: 20px;
        }

        /* Summary box styling */
        .summary {
            margin-bottom: 20px;
            padding: 12px;
            background: #f3f4f6;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /* Table headers */
        th {
            background: #020617;
            color: white;
            padding: 8px;
            text-align: left;
        }

        /* Table rows */
        td {
            border-bottom: 1px solid #e5e7eb;
            padding: 8px;
        }

    </style>

</head>

<body>

{{-- Main report title --}}
<h1>RoyalStay Hotel Report</h1>

{{-- Display report period if dates are selected --}}
<p class="subtitle">

    @if($startDate && $endDate)

        Report Period: {{ $startDate }} to {{ $endDate }}

    @else

        Full Report

    @endif

</p>

{{-- Report summary section --}}
<div class="summary">

    {{-- Total number of bookings --}}
    <strong>Total Bookings:</strong>
    {{ $bookings->count() }}

    <br>

    {{-- Total revenue generated --}}
    <strong>Total Revenue:</strong>
    Rs. {{ number_format($totalRevenue, 2) }}

</div>

{{-- Booking details table --}}
<table>

    <thead>

        <tr>

            {{-- Booking ID --}}
            <th>ID</th>

            {{-- Customer Name --}}
            <th>Customer</th>

            {{-- Room Type --}}
            <th>Room</th>

            {{-- Stay Dates --}}
            <th>Dates</th>

            {{-- Booking Amount --}}
            <th>Amount</th>

            {{-- Booking Status --}}
            <th>Status</th>

        </tr>

    </thead>

    <tbody>

        {{-- Loop through all bookings --}}
        @foreach($bookings as $booking)

            <tr>

                {{-- Booking Number --}}
                <td>
                    #{{ $booking->id }}
                </td>

                {{-- Customer Name --}}
                <td>
                    {{ $booking->user->name }}
                </td>

                {{-- Room Type --}}
                <td>
                    {{ $booking->room->room_type }}
                </td>

                {{-- Check-In and Check-Out Dates --}}
                <td>

                    {{ $booking->check_in_date->format('Y-m-d') }}

                    to

                    {{ $booking->check_out_date->format('Y-m-d') }}

                </td>

                {{-- Total Booking Amount --}}
                <td>
                    Rs. {{ number_format($booking->total_amount, 2) }}
                </td>

                {{-- Booking Status --}}
                <td>

                    {{ ucwords(str_replace('_', ' ', $booking->status)) }}

                </td>

            </tr>

        @endforeach

    </tbody>

</table>

</body>
</html>