<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Notification $notification): RedirectResponse
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
        ]);

        return back();
    }

    public function markAllAsRead(): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403);
        }

        $user->notifications()->update([
            'is_read' => true,
        ]);

        return back();
    }
}