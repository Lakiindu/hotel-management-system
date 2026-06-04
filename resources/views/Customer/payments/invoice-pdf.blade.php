<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invoice PDF</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #111827;
        }

        .header {
            background: #020617;
            color: white;
            padding: 20px;
            margin-bottom: 20px;
        }

        .brand {
            font-size: 28px;
            font-weight: bold;
        }

        .muted {
            color: #6b7280;
        }

        .box {
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-bottom: 15px;
        }

        .grid {
            width: 100%;
            margin-bottom: 20px;
        }

        .grid td {
            width: 50%;
            vertical-align: top;
            padding: 10px;
        }

        table.invoice {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table.invoice th {
            background: #020617;
            color: white;
            padding: 10px;
            text-align: left;
        }

        table.invoice td {
            border-bottom: 1px solid #e5e7eb;
            padding: 10px;
        }

        .total {
            text-align: right;
            margin-top: 25px;
            font-size: 18px;
            font-weight: bold;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 20px;
            background: #dcfce7;
            color: #166534;
            font-weight: bold;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="header">
    <div class="brand">RoyalStay Hotel</div>
    <p>Hotel Management System Invoice</p>
</div>

<table class="grid">
    <tr>
        <td>
            <div class="box">
                <h3>Invoice Details</h3>
                <p><strong>Invoice No:</strong> INV-{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Invoice Date:</strong> {{ now()->format('Y-m-d') }}</p>
                <p><strong>Payment Status:</strong> {{ ucfirst($payment->status) }}</p>
                <p><strong>Payment Method:</strong> {{ ucfirst($payment->payment_method) }}</p>
            </div>
        </td>

        <td>
            <div class="box">
                <h3>Customer Details</h3>
                <p><strong>Name:</strong> {{ $payment->booking->user->name }}</p>
                <p><strong>Email:</strong> {{ $payment->booking->user->email }}</p>
                <p><strong>Phone:</strong> {{ $payment->booking->user->phone ?? 'N/A' }}</p>
            </div>
        </td>
    </tr>
</table>

<div class="box">
    <h3>Booking Information</h3>
    <p><strong>Booking ID:</strong> #{{ $payment->booking->id }}</p>
    <p><strong>Room:</strong> {{ $payment->booking->room->room_type }}</p>
    <p><strong>Room Number:</strong> {{ $payment->booking->room->room_number }}</p>
    <p><strong>Check-In:</strong> {{ $payment->booking->check_in_date->format('Y-m-d') }}</p>
    <p><strong>Check-Out:</strong> {{ $payment->booking->check_out_date->format('Y-m-d') }}</p>
</div>

<table class="invoice">
    <thead>
        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>
                Hotel room booking for {{ $payment->booking->room->room_type }}
                from {{ $payment->booking->check_in_date->format('Y-m-d') }}
                to {{ $payment->booking->check_out_date->format('Y-m-d') }}
            </td>

            <td>
                Rs. {{ number_format($payment->amount, 2) }}
            </td>
        </tr>
    </tbody>
</table>

<div class="total">
    Total Amount: Rs. {{ number_format($payment->amount, 2) }}
</div>

<p>
    Status:
    <span class="status">
        {{ ucfirst($payment->status) }}
    </span>
</p>

<div class="footer">
    This is a system generated invoice from RoyalStay Hotel Management System.
</div>

</body>
</html>