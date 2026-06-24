<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Review;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewSubmittedMail;
use App\Mail\ReviewThankYouMail;

class ReviewController extends Controller
{
    // Display the review submission page
    public function create(Booking $booking)
    {
        // Ensure the booking belongs to the logged-in customer
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Allow reviews only after the stay has been completed
        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can review only after completed stay.');
        }

        // Prevent customers from submitting multiple reviews for the same booking
        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        // Open the review submission form
        return view('customer.reviews.create', compact('booking'));
    }

    // Save a new customer review
    public function store(Request $request, Booking $booking)
    {
        // Ensure the booking belongs to the logged-in customer
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Allow reviews only after the stay has been completed
        if ($booking->status !== 'completed') {
            return back()->with('error', 'You can review only after completed stay.');
        }

        // Prevent duplicate reviews for the same booking
        if ($booking->review) {
            return back()->with('error', 'You have already reviewed this booking.');
        }

        // Validate review form inputs
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Store the review in the database
        $review = Review::create([
            'user_id' => Auth::id(),
            'room_id' => $booking->room_id,
            'booking_id' => $booking->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Load review relationships for email
        $review->load('user', 'room', 'booking');

        // Send thank-you email to the customer
        Mail::to($review->user->email)->send(new ReviewThankYouMail($review));

        // Retrieve all admin accounts
        $admins = User::where('role', 'admin')->get();

        // Notify each admin about the newly submitted review
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'New Review',
                'message' => 'A new review has been submitted.',
                'is_read' => false,
            ]);

            // Send real review email to each admin
            Mail::to($admin->email)->send(new ReviewSubmittedMail($review));
        }

        // Redirect back to the customer's bookings page with a success message
        return redirect()->route('customer.bookings.index')
            ->with('success', 'Review submitted successfully.');
    }
}