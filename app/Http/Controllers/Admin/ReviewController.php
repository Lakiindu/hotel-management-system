<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    // Display all customer reviews in the admin panel
    public function index()
    {
        // Retrieve reviews with related customer, room and booking details
        $reviews = Review::with(['user', 'room', 'booking'])
            ->latest()
            ->paginate(10);

        // Pass review data to the admin reviews page
        return view('admin.reviews.index', compact('reviews'));
    }

    // Delete a selected review
    public function destroy(Review $review)
    {
        // Remove the review from the database
        $review->delete();

        // Return JSON response if the request came from AJAX
        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully.'
            ]);
        }

        // Redirect back with a success message for normal requests
        return back()->with(
            'success',
            'Review deleted successfully.'
        );
    }
}