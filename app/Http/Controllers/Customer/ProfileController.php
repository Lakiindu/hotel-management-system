<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

// Handles customer profile view, profile update, and password update
class ProfileController extends Controller
{
    // Show customer profile edit page
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        // Stop access if user is not logged in
        if (!$user) {
            abort(403);
        }

        // Calculate profile completion percentage
        $completedFields = 0;
        $totalFields = 5;

        if ($user->name) {
            $completedFields++;
        }

        if ($user->email) {
            $completedFields++;
        }

        if ($user->phone) {
            $completedFields++;
        }

        if ($user->address) {
            $completedFields++;
        }

        if ($user->profile_image) {
            $completedFields++;
        }

        $profileCompletion = round(($completedFields / $totalFields) * 100);

        // Count completed bookings/stays of the customer
        $totalStays = $user->bookings()
            ->where('status', 'completed')
            ->count();

        // Send profile stats to edit page
        return view('customer.profile.edit', compact(
            'profileCompletion',
            'totalStays'
        ));
    }

    // Update customer profile details
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Stop access if user is not logged in
        if (!$user) {
            abort(403);
        }

        // Validate profile update form
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Keep current profile image unless a new one is uploaded
        $imagePath = $user->profile_image;

        // Replace old profile image with new uploaded image
        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $imagePath = $request->file('profile_image')
                ->store('profiles', 'public');
        }

        // Save updated profile data
        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $imagePath,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    // Update customer password
    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        // Stop access if user is not logged in
        if (!$user) {
            abort(403);
        }

        // Validate password update form
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check whether current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        // Save new encrypted password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}