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
        return view('admin.dashboard');
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