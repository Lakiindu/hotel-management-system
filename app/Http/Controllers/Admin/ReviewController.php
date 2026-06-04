<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user', 'room', 'booking'])
            ->latest()
            ->paginate(10);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function destroy(Review $review)
{
    $review->delete();

    if (request()->expectsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Review deleted successfully.'
        ]);
    }

    return back()->with('success',
     'Review deleted successfully.');
}
}