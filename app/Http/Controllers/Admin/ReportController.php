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
    // Display the admin reports dashboard
    public function index(Request $request)
    {
        // Get selected date range from request
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Base query for bookings
        $bookingQuery = Booking::query();

        // Base query for paid payments only
        $paymentQuery = Payment::where('status', 'paid');

        // Apply date filter if start and end dates are selected
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

        // Room summary counts
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $maintenanceRooms = Room::where('status', 'maintenance')->count();

        // Count registered customers
        $totalCustomers = User::where('role', 'customer')->count();

        // Booking summary counts
        $totalBookings = (clone $bookingQuery)->count();
        $pendingBookings = (clone $bookingQuery)->where('status', 'pending')->count();
        $completedBookings = (clone $bookingQuery)->where('status', 'completed')->count();

        // Calculate total revenue from paid payments
        $totalRevenue = (clone $paymentQuery)->sum('amount');

        // Get monthly revenue totals for chart
        $monthlyRevenue = Payment::where('status', 'paid')
            ->selectRaw('MONTH(payment_date) as month, SUM(amount) as total')
            ->whereNotNull('payment_date')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Get monthly booking counts for chart
        $monthlyBookings = Booking::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month');

        // Prepare chart labels and values for all 12 months
        $months = [];
        $revenueData = [];
        $bookingData = [];

        for ($i = 1; $i <= 12; $i++) {
            $months[] = date('M', mktime(0, 0, 0, $i, 1));
            $revenueData[] = $monthlyRevenue[$i] ?? 0;
            $bookingData[] = $monthlyBookings[$i] ?? 0;
        }

        // Get latest 5 bookings for recent activity section
        $recentBookings = (clone $bookingQuery)
            ->with(['user', 'room'])
            ->latest()
            ->take(5)
            ->get();

        // Send all report data to the reports dashboard
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

    // Export booking report as CSV file
    public function exportCsv(Request $request)
    {
        // Get selected date range
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Retrieve bookings with customer and room details
        $bookings = Booking::with(['user', 'room'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            })
            ->latest()
            ->get();

        // CSV file name
        $fileName = 'hotel-booking-report.csv';

        // CSV download headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=$fileName",
        ];

        // Create CSV file content
        $callback = function () use ($bookings) {
            $file = fopen('php://output', 'w');

            // Add CSV table headings
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

            // Add booking data rows
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

        // Return the CSV as a downloadable response
        return response()->stream($callback, 200, $headers);
    }

    // Export booking report as PDF file
    public function exportPdf(Request $request)
    {
        // Get selected date range
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Retrieve bookings with customer and room details
        $bookings = Booking::with(['user', 'room'])
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [
                    $startDate . ' 00:00:00',
                    $endDate . ' 23:59:59'
                ]);
            })
            ->latest()
            ->get();

        // Calculate paid revenue for the selected date range
        $totalRevenue = Payment::where('status', 'paid')
            ->when($startDate && $endDate, function ($query) use ($startDate, $endDate) {
                $query->whereBetween('payment_date', [
                    $startDate,
                    $endDate
                ]);
            })
            ->sum('amount');

        // Generate PDF using the report PDF blade view
        $pdf = Pdf::loadView('admin.reports.pdf', compact(
            'bookings',
            'totalRevenue',
            'startDate',
            'endDate'
        ));

        // Display PDF in the browser
        return $pdf->stream('hotel-report.pdf');
    }
}