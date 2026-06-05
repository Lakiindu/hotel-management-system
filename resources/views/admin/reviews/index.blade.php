@extends('layouts.admin')

@section('title', 'Review Management')

@section('page-title', 'Review Management')

@section('page-subtitle', 'View and manage customer room reviews.')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1000px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Room</th>
                    <th class="p-4 text-left">Rating</th>
                    <th class="p-4 text-left">Comment</th>
                    <th class="p-4 text-left">Date</th>
                    <th class="p-4 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reviews as $review)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-4">
                            <p class="font-bold">{{ $review->user->name }}</p>
                            <p class="text-sm text-slate-500">{{ $review->user->email }}</p>
                        </td>

                        <td class="p-4">
                            {{ $review->room->room_type }}
                        </td>

                        <td class="p-4 text-amber-500">
                            @for($i = 1; $i <= $review->rating; $i++)
                                ⭐
                            @endfor
                        </td>

                        <td class="p-4">
                            {{ $review->comment ?? 'No comment' }}
                        </td>

                        <td class="p-4">
                            {{ $review->created_at->format('Y-m-d') }}
                        </td>

                        <td class="p-4">
                            <form method="POST"
                                  action="{{ route('admin.reviews.destroy', $review->id) }}"
                                  class="delete-form">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="delete-btn bg-red-500 text-white px-4 py-2 rounded-xl font-bold">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500">
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
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete'
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