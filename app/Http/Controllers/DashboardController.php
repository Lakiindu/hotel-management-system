<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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
    $totalRooms = \App\Models\Room::count();
    $availableRooms = \App\Models\Room::where('status', 'available')->count();
    $occupiedRooms = \App\Models\Room::where('status', 'occupied')->count();

    $totalCustomers = \App\Models\User::where('role', 'customer')->count();
    $totalBookings = \App\Models\Booking::count();
    $pendingBookings = \App\Models\Booking::where('status', 'pending')->count();

    $totalRevenue = \App\Models\Payment::where('status', 'paid')->sum('amount');

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

        return view('customer.dashboard', compact(
            'totalBookings',
            'pendingBookings',
            'upcomingStays',
            'completedStays',
            'latestBooking'
        ));
    }
}