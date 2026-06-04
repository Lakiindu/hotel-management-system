<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $customers = User::where('role', 'customer')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->when($status !== null && $status !== '', function ($query) use ($status) {
                $query->where('is_active', $status);
            })
            ->latest()
            ->paginate(10);

        $totalCustomers = User::where('role', 'customer')->count();

        $activeCustomers = User::where('role', 'customer')
            ->where('is_active', 1)
            ->count();

        $inactiveCustomers = User::where('role', 'customer')
            ->where('is_active', 0)
            ->count();

        return view('admin.customers.index', compact(
            'customers',
            'search',
            'status',
            'totalCustomers',
            'activeCustomers',
            'inactiveCustomers'
        ));
    }

    public function show(User $user)
    {
        $user->load('bookings.room');

        return view('admin.customers.show', compact('user'));
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $message = $user->is_active
            ? 'Customer activated successfully.'
            : 'Customer deactivated successfully.';

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'is_active' => $user->is_active,
            ]);
        }

        return back()->with('success', $message);
    }
}