<!DOCTYPE html>
<html>
<head>
    <!-- Page Title -->
    <title>Submit Review</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<!-- Main Container -->
<div class="max-w-3xl mx-auto py-10 px-6">
    <!-- Review Card -->
    <div class="bg-white p-8 rounded-3xl shadow">

    <!-- Page Heading -->
        <h1 class="text-3xl font-bold mb-2">Submit Review</h1>
         <!-- Display Room Type -->
        <p class="text-slate-500 mb-6">
            Room: {{ $booking->room->room_type }}
        </p>

        <!-- Validation Errors -->
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Review Submission Form -->
        <form method="POST" action="{{ route('customer.reviews.store', $booking->id) }}">
            @csrf

            <!-- Rating Field -->
            <label class="font-semibold">Rating</label>
             <!-- Rating Dropdown -->
            <select name="rating" class="w-full border p-3 rounded-xl mb-4">
                <option value="">Select Rating</option>
                <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
                <option value="4">⭐⭐⭐⭐ Good</option>
                <option value="3">⭐⭐⭐ Average</option>
                <option value="2">⭐⭐ Poor</option>
                <option value="1">⭐ Very Poor</option>
            </select>

            <!-- Comment Field -->
            <label class="font-semibold">Comment</label>

            <!-- Customer Review Message -->
            <textarea name="comment" rows="5"
                      class="w-full border p-3 rounded-xl mb-5"
                      placeholder="Write your experience..."></textarea>

             <!-- Submit Review Button -->
            <button class="bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold">
                Submit Review
            </button>

             <!-- Cancel and Return to Booking List -->
            <a href="{{ route('customer.bookings.index') }}" class="ml-3 text-slate-500">
                Cancel
            </a>
        </form>

    </div>
</div>

</body>
</html>