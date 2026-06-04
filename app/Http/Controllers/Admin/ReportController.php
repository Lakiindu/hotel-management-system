<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $bookingQuery = Booking::query();
        $paymentQuery = Payment::where('status', 'paid');

        if ($startDate && $endDate) {
            $bookingQuery->whereBetween('created_at', [
                $startDate . ' 00:00:00',
                $endDate . ' 23:59:59'
            ]);

            $paymentQuery->whereBetween('payment_date', [
                $startDate,
                $endDate
            ]);
        }

        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalBookings = (clone $bookingQuery)->count();
        $pendingBookings = (clone $bookingQuery)->where('status', 'pending')->count();
        $completedBookings = (clone $bookingQuery)->where('status', 'completed')->count();

        $totalRevenue = (clone $paymentQuery)->sum('amount');

        $monthlyRevenue = Payment::where('status', 'paid')
            ->selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->whereNotNull('payment_date')
            ->groupBy('month')
            ->pluck('total', 'month');

        $monthlyBookings = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        $months = [];
        $revenueData = [];
        $bookingData = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $revenueData[] = $monthlyRevenue[$i] ?? 0;
            $bookingData[] = $monthlyBookings[$i] ?? 0;
        }

        $recentBookings = (clone $bookingQuery)
            ->with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.reports.index', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'totalCustomers',
            'totalBookings',
            'pendingBookings',
            'completedBookings',
            'totalRevenue',
            'months',
            'revenueData',
            'bookingData',
            'recentBookings',
            'startDate',
            'endDate'
        ));
    }

    public function exportCsv(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $bookings = Booking::with(['user', 'room'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            })
            ->latest()
            ->get();

        $fileName = 'hotel-booking-report.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Booking ID',
                'Customer',
                'Email',
                'Room',
                'Check In',
                'Check Out',
                'Guests',
                'Amount',
                'Status',
                'Created At'
            ]);

            foreach ($bookings as $booking) {
                fputcsv($file, [
                    $booking->id,
                    $booking->user->name,
                    $booking->user->email,
                    $booking->room->room_type,
                    $booking->check_in_date->format('Y-m-d'),
                    $booking->check_out_date->format('Y-m-d'),
                    $booking->guests,
                    $booking->total_amount,
                    $booking->status,
                    $booking->created_at->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $bookings = Booking::with(['user', 'room'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            })
            ->latest()
            ->get();

        $totalRevenue = Payment::where('status', 'paid')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('payment_date', [
                    $startDate,
                    $endDate
                ]);
            })
            ->sum('amount');

        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'bookings',
            'totalRevenue',
            'startDate',
            'endDate'
        ));

        return $pdf->stream('hotel-report.pdf');
    }
}