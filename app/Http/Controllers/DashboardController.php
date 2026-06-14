<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

// Handles dashboard views for both admins and customers
class DashboardController extends Controller
{
    // Redirect users to their respective dashboards based on role
    public function redirect()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    }

    // Admin dashboard with key metrics and stats
    public function adminDashboard()
    {
        $totalRooms = Room::count();
        $availableRooms = Room::where('status', 'available')->count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

        // Pass all metrics to the admin dashboard view
        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'totalCustomers',
            'totalBookings',
            'pendingBookings',
            'totalRevenue'
        ));
    }

    // Customer dashboard with personalized booking and payment info
    public function customerDashboard()
    {
        $userId = Auth::id();

        //booking stats
        $totalBookings = Booking::where('user_id', $userId)->count();

        $pendingBookings = Booking::where('user_id', $userId)
            ->where('status', 'pending')
            ->count();

        $upcomingStays = Booking::where('user_id', $userId)
            ->whereIn('status', ['approved', 'checked_in'])
            ->count();

        $completedStays = Booking::where('user_id', $userId)
            ->where('status', 'completed')
            ->count();

        // Next upcoming stay details
        $nextStay = Booking::with('room')
            ->where('user_id', $userId)
            ->whereIn('status', ['approved', 'checked_in'])
            ->orderBy('check_in_date', 'asc')
            ->first();

        // Recent bookings and payments
        $recentBookings = Booking::with('room')
            ->where('user_id', $userId)
            ->latest()
            ->take(3)
            ->get();

        // Recent payments with booking and room details
        $recentPayments = Payment::with('booking.room')
            ->whereHas('booking', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->latest()
            ->take(3)
            ->get();

        // Calculate total pending payment amount for the customer
        $pendingPaymentAmount = Payment::where('status', 'pending')
            ->whereHas('booking', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->sum('amount');

            // Calculate nights and days left for the next stay if it exists
        $nextStayNights = 0;
        $nextStayDaysLeft = null;

        if ($nextStay) {
            $nextStayNights = Carbon::parse($nextStay->check_in_date)
                ->diffInDays(Carbon::parse($nextStay->check_out_date));

            $nextStayDaysLeft = now()->startOfDay()
                ->diffInDays(Carbon::parse($nextStay->check_in_date)->startOfDay(), false);
        }

        // Pass all customer-specific data to the dashboard view
        return view('customer.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'upcomingStays',
            'completedStays',
            'nextStay',
            'recentBookings',
            'recentPayments',
            'pendingPaymentAmount',
            'nextStayNights',
            'nextStayDaysLeft'
        ));
    }
}