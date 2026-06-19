<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Display customer list with search, status filter, and summary counts
    public function index(Request $request)
    {
        // Get search keyword and selected status from request
        $search = $request->search;
        $status = $request->status;

        // Retrieve only users who have the customer role
        $customers = User::where('role', 'customer')

            // Search customers by name, email, or phone
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })

            // Filter customers by active/inactive status
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', $status);
            })

            // Show newest customers first
            ->latest()
            ->paginate(10);

        // Count all customers
        $totalCustomers = User::where('role', 'customer')->count();

        // Count active customers
        $activeCustomers = User::where('role', 'customer')
            ->where('is_active', 1)
            ->count();

        // Count inactive customers
        $inactiveCustomers = User::where('role', 'customer')
            ->where('is_active', 0)
            ->count();

        // Send customers and summary data to the admin customer page
        return view('admin.customers.index', compact(
            'customers',
            'search',
            'status',
            'totalCustomers',
            'activeCustomers',
            'inactiveCustomers'
        ));
    }

    // Return customer data using AJAX for live search/filter
    public function ajaxCustomers(Request $request)
    {
        // Get search keyword and selected status
        $search = $request->search;
        $status = $request->status;

        // Retrieve filtered customer records
        $customers = User::where('role', 'customer')

            // Search by name, email, or phone
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })

            // Filter by account status
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', $status);
            })

            ->latest()
            ->get();

        // Return matching customers as JSON
        return response()->json([
            'success' => true,
            'customers' => $customers,
        ]);
    }

    // Display full profile details of a selected customer
    public function show(User $user)
    {
        // Load customer's bookings and related room details
        $user->load('bookings.room');

        // Show customer profile page
        return view('admin.customers.show', compact('user'));
    }

    // Activate or deactivate customer account
    public function toggleStatus(User $user)
    {
        // Reverse the current account status
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        // Prepare message based on the new account status
        $message = $user->is_active
            ? 'Customer activated successfully.'
            : 'Customer deactivated successfully.';

        // Return JSON response if request came from AJAX
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_active' => $user->is_active,
            ]);
        }

        // Redirect back with success message for normal form requests
        return back()->with('success', $message);
    }
}