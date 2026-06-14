<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

// Handles notification-related actions
// such as marking notifications as read.
class NotificationController extends Controller
{
    // Mark a single notification as read
    public function markAsRead(Notification $notification): RedirectResponse
    {
        // Ensure the notification belongs to the logged-in user
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        // Update notification status
        $notification->update([
            'is_read' => true,
        ]);

        // Return to previous page
        return back();
    }

    // Mark all notifications of the logged-in user as read
    public function markAllAsRead(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        // Ensure a user is authenticated
        if (!$user) {
            abort(403);
        }

        // Update all user notifications
        $user->notifications()->update([
            'is_read' => true,
        ]);

        // Return to previous page
        return back();
    }
}