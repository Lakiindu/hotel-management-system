@extends('layouts.admin')

@section('title', 'Review Management')

@section('page-title', 'Review Management')

@section('page-subtitle', 'View and manage customer room reviews.')

@section('content')

@php
    $totalReviews = \App\Models\Review::count();
    $averageRating = \App\Models\Review::avg('rating');
    $fiveStarReviews = \App\Models\Review::where('rating', 5)->count();
    $latestReviews = \App\Models\Review::whereDate('created_at', today())->count();
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-5 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Total Reviews</p>
        <h2 class="text-3xl font-extrabold text-blue-600">
            {{ $totalReviews }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-yellow-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Average Rating</p>
        <h2 class="text-3xl font-extrabold text-yellow-500">
            {{ number_format($averageRating ?? 0, 1) }} / 5
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-green-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">5-Star Reviews</p>
        <h2 class="text-3xl font-extrabold text-green-600">
            {{ $fiveStarReviews }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-purple-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <p class="text-slate-500">Today Reviews</p>
        <h2 class="text-3xl font-extrabold text-purple-600">
            {{ $latestReviews }}
        </h2>
    </div>

</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1100px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-5 text-left">Customer</th>
                    <th class="p-5 text-left">Room</th>
                    <th class="p-5 text-left">Booking</th>
                    <th class="p-5 text-left">Rating</th>
                    <th class="p-5 text-left">Comment</th>
                    <th class="p-5 text-left">Date</th>
                    <th class="p-5 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reviews as $review)
                    <tr class="border-b hover:bg-slate-50 transition">

                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-extrabold">
                                    {{ strtoupper(substr($review->user?->name ?? 'D', 0, 1)) }}
                                </div>
 
                                <div>
                                    <p class="font-extrabold text-slate-900">
                                        {{ $review->user?->name ?? 'Deleted User' }}
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        {{ $review->user?->email ?? '-' }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        Customer ID #{{ $review->user?->id ?? '-' }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="p-5">
                            <p class="font-bold">
                                {{ $review->room->room_type }}
                            </p>

                            <p class="text-sm text-slate-500">
                                Room No: {{ $review->room->room_number ?? '-' }}
                            </p>
                        </td>

                        <td class="p-5">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">
                                Booking #{{ $review->booking_id ?? '-' }}
                            </span>
                        </td>

                        <td class="p-5">
                            <div class="flex items-center gap-2">
                                <div class="text-amber-400 text-lg">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            ★
                                        @else
                                            <span class="text-slate-300">★</span>
                                        @endif
                                    @endfor
                                </div>

                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-bold">
                                    {{ $review->rating }}/5
                                </span>
                            </div>
                        </td>

                        <td class="p-5">
                            <div class="bg-slate-50 px-4 py-3 rounded-2xl text-slate-700 max-w-md">
                                {{ $review->comment ?? 'No comment provided.' }}
                            </div>
                        </td>

                        <td class="p-5">
                            <p class="font-semibold">
                                {{ $review->created_at->format('Y-m-d') }}
                            </p>

                            <p class="text-sm text-slate-500">
                                {{ $review->created_at->diffForHumans() }}
                            </p>
                        </td>

                        <td class="p-5">
                            <form method="POST"
                                  action="{{ route('admin.reviews.destroy', $review->id) }}"
                                  class="delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="delete-btn bg-red-500 text-white px-4 py-2 rounded-xl font-bold hover:bg-red-600 transition">
                                    Delete
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-10 text-center text-slate-500">
                            No reviews found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $reviews->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        let form = this.closest('form');

        Swal.fire({
            title: 'Delete this review?',
            text: 'This review will be permanently removed.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then(result => {
            if (result.isConfirmed) {
                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: new FormData(form)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', data.message, 'success')
                            .then(() => location.reload());
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Something went wrong.', 'error');
                });
            }
        });
    });
});
</script>
@endpush