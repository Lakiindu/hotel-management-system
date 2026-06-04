<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\Room;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function redirect()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('customer.dashboard');
    }

    public function adminDashboard()
    {
        $totalRooms = Room::count();

        $availableRooms = Room::where('status', 'available')->count();

        $occupiedRooms = Room::where('status', 'occupied')->count();

        $totalCustomers = User::where('role', 'customer')->count();

        $totalBookings = Booking::count();

        $pendingBookings = Booking::where('status', 'pending')->count();

        $totalRevenue = Payment::where('status', 'paid')->sum('amount');

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

    public function customerDashboard()
{
    $userId = Auth::id();

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

    $latestBooking = Booking::with('room')
        ->where('user_id', $userId)
        ->latest()
        ->first();

    $nextStay = Booking::with('room')
        ->where('user_id', $userId)
        ->whereIn('status', ['approved', 'checked_in'])
        ->orderBy('check_in_date', 'asc')
        ->first();

    $recentBookings = Booking::with('room')
        ->where('user_id', $userId)
        ->latest()
        ->take(3)
        ->get();

    $recentPayments = Payment::with('booking.room')
        ->whereHas('booking', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->latest()
        ->take(3)
        ->get();

    $pendingPaymentAmount = Payment::where('status', 'pending')
        ->whereHas('booking', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->sum('amount');

    return view('customer.dashboard', compact(
        'totalBookings',
        'pendingBookings',
        'upcomingStays',
        'completedStays',
        'latestBooking',
        'nextStay',
        'recentBookings',
        'recentPayments',
        'pendingPaymentAmount'
    ));
}
}