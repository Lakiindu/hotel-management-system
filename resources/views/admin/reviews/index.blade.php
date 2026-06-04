<!DOCTYPE html>
<html>
<head>
    <title>Review Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h1 class="text-2xl font-bold mb-8">Hotel Admin</h1>

        
        <nav class="space-y-3">

    <a href="{{ route('admin.dashboard') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Dashboard</a>

    <a href="{{ route('admin.rooms.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Rooms</a>

    <a href="{{ route('admin.bookings.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Bookings</a>

    <a href="{{ route('admin.customers.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Customers</a>

    <a href="{{ route('admin.payments.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Payments</a>

    <a href="{{ route('admin.reviews.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Reviews</a>

    <a href="{{ route('admin.reports.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Reports</a>
    
    </nav>
    </aside>

    <main class="flex-1 p-8">
        <h1 class="text-3xl font-bold mb-6">Review Management</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full">
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

                            <td class="p-4">{{ $review->room->room_type }}</td>

                            <td class="p-4 text-amber-500">
                                @for($i = 1; $i <= $review->rating; $i++)
                                    ⭐
                                @endfor
                            </td>

                            <td class="p-4">{{ $review->comment ?? 'No comment' }}</td>

                            <td class="p-4">{{ $review->created_at->format('Y-m-d') }}</td>

                            <td class="p-4">
                                <form method="POST"
                                      action="{{ route('admin.reviews.destroy', $review->id) }}"
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="delete-btn bg-red-500 text-white px-4 py-2 rounded-lg">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-500">
                                No reviews found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $reviews->links() }}
        </div>
    </main>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: 'Delete this review?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.closest('form').submit();
                }
            });
        });
    });
</script>

</body>
</html>