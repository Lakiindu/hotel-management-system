<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

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

        $totalStays = $user->bookings()
            ->where('status', 'completed')
            ->count();

        return view('customer.profile.edit', compact(
            'profileCompletion',
            'totalStays'
        ));
    }

    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $user->profile_image;

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $imagePath = $request->file('profile_image')
                ->store('profiles', 'public');
        }

        $user->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'profile_image' => $imagePath,
        ]);

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}