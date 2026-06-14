<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    {{-- PDF page title --}}
    <title>Invoice PDF</title>

    <style>
        /* Overall PDF body styling */
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        /* Top invoice header */
        .header {
            background: #020617;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }

        /* Hotel brand name */
        .brand {
            font-size: 28px;
            font-weight: bold;
        }

        /* Light gray text */
        .muted {
            color: #6b7280;
        }

         /* Box design for details sections */
        .box {
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-bottom: 15px;
        }

         /* Two-column layout table */
        .grid {
            width: 100%;
            margin-bottom: 20px;
        }

        /* Two-column cell styling */
        .grid td {
            width: 50%;
            vertical-align: top;
            padding: 10px;
        }

        /* Invoice item table */
        table.invoice {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Invoice table header */
        table.invoice th {
            background: #020617;
            color: white;
            padding: 10px;
            text-align: left;
        }

         /* Invoice table rows */
        table.invoice td {
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
        }

        /* Total amount section */
        .total {
            text-align: right;
            margin-top: 25px;
            font-size: 18px;
            font-weight: bold;
        }

        /* Payment status badge */
        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-weight: bold;
        }

        /* Invoice footer text */
        .footer {
            margin-top: 40px;
            font-size: 11px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>

<body>

{{-- Invoice header --}}
<div class="header">
    <div class="brand">RoyalStay Hotel</div>
    <p>Hotel Management System Invoice</p>
</div>

{{-- Invoice and customer details section --}}
<table class="grid">
    <tr>
        <td>
            {{-- Invoice details box --}}
            <div class="box">
                <h3>Invoice Details</h3>

                {{-- Invoice number generated from payment ID --}}
                <p><strong>Invoice No:</strong> INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>

                {{-- Current invoice date --}}
                <p><strong>Invoice Date:</strong> {{ now()->format('Y-m-d') }}</p>

                {{-- Payment status --}}
                <p><strong>Payment Status:</strong> {{ ucfirst($payment->status) }}</p>

                {{-- Payment method --}}
                <p><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
            </div>
        </td>

        <td>
            {{-- Customer details box --}}
            <div class="box">
                <h3>Customer Details</h3>

                {{-- Customer name --}}
                <p><strong>Name:</strong> {{ $payment->booking->user->name }}</p>

                {{-- Customer email --}}
                <p><strong>Email:</strong> {{ $payment->booking->user->email }}</p>

                {{-- Customer phone --}}
                <p><strong>Phone:</strong> {{ $payment->booking->user->phone ?? 'N/A' }}</p>
            </div>
        </td>
    </tr>
</table>

{{-- Booking details section --}}
<div class="box">
    <h3>Booking Information</h3>

    {{-- Booking ID --}}
    <p><strong>Booking ID:</strong> #{{ $payment->booking->id }}</p>

    {{-- Room type --}}
    <p><strong>Room:</strong> {{ $payment->booking->room->room_type }}</p>

    {{-- Room number --}}
    <p><strong>Room Number:</strong> {{ $payment->booking->room->room_number }}</p>

    {{-- Check-in date --}}
    <p><strong>Check-In:</strong> {{ $payment->booking->check_in_date->format('Y-m-d') }}</p>

    {{-- Check-out date --}}
    <p><strong>Check-Out:</strong> {{ $payment->booking->check_out_date->format('Y-m-d') }}</p>
</div>

{{-- Invoice amount table --}}
<table class="invoice">
    <thead>
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            {{-- Booking charge description --}}
            <td>
                Hotel room booking for {{ $payment->booking->room->room_type }}
                from {{ $payment->booking->check_in_date->format('Y-m-d') }}
                to {{ $payment->booking->check_out_date->format('Y-m-d') }}
            </td>

            {{-- Payment amount --}}
            <td>
                Rs. {{ number_format($payment->amount, 2) }}
            </td>
        </tr>
    </tbody>
</table>

{{-- Total payment amount --}}
<div class="total">
    Total Amount: Rs. {{ number_format($payment->amount, 2) }}
</div>

{{-- Payment status --}}
<p>
    Status:
    <span class="status">
        {{ ucfirst($payment->status) }}
    </span>
</p>

{{-- Footer note --}}
<div class="footer">
    This is a system generated invoice from RoyalStay Hotel Management System.
</div>

</body>
</html>