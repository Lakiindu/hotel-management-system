<!DOCTYPE html>
<html>
<head>
    <title>Manage Rooms</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-slate-100">

<div class="flex min-h-screen">
    <aside class="w-64 bg-slate-950 text-white p-6">
        <h1 class="text-2xl font-bold mb-8">Hotel Admin</h1>

        <nav class="space-y-3">
            <a href="{{ route('admin.dashboard') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Dashboard</a>
            <a href="{{ route('admin.rooms.index') }}" class="block bg-blue-600 px-4 py-2 rounded-lg">Rooms</a>
        </nav>
    </aside>

    <main class="flex-1 p-8">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">Room Management</h2>
                <p class="text-slate-500">Add, update, search and manage hotel rooms</p>
            </div>

            <a href="{{ route('admin.rooms.create') }}"
               class="bg-blue-600 text-white px-5 py-3 rounded-xl hover:bg-blue-700">
                + Add Room
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="bg-white p-5 rounded-2xl shadow mb-6 grid md:grid-cols-3 gap-4">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Search room number or type"
                   class="border rounded-xl px-4 py-3">

            <select name="status" class="border rounded-xl px-4 py-3">
                <option value="">All Status</option>
                <option value="available" {{ $status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="occupied" {{ $status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                <option value="maintenance" {{ $status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            </select>

            <button class="bg-slate-950 text-white rounded-xl px-4 py-3">
                Filter
            </button>
        </form>

        <div class="bg-white rounded-2xl shadow overflow-hidden">
            <table class="w-full">
                <thead class="bg-slate-950 text-white">
                    <tr>
                        <th class="p-4 text-left">Image</th>
                        <th class="p-4 text-left">Room</th>
                        <th class="p-4 text-left">Type</th>
                        <th class="p-4 text-left">Price</th>
                        <th class="p-4 text-left">Capacity</th>
                        <th class="p-4 text-left">Status</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($rooms as $room)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="p-4">
                                <img src="{{ $room->image ? asset('storage/' . $room->image) : 'https://via.placeholder.com/100' }}"
                                     class="w-20 h-16 object-cover rounded-xl">
                            </td>

                            <td class="p-4 font-bold">{{ $room->room_number }}</td>
                            <td class="p-4">{{ $room->room_type }}</td>
                            <td class="p-4">Rs. {{ number_format($room->price_per_night, 2) }}</td>
                            <td class="p-4">{{ $room->capacity }}</td>

                            <td class="p-4">
                                <span class="px-3 py-1 rounded-full text-sm
                                    {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                                    {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                                    {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </td>

                            <td class="p-4 flex gap-2">
                                <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                   class="bg-amber-400 text-slate-900 px-4 py-2 rounded-lg">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.rooms.destroy', $room->id) }}"
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
                            <td colspan="7" class="p-6 text-center text-slate-500">
                                No rooms found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $rooms->links() }}
        </div>
    </main>
</div>

<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            Swal.fire({
                title: 'Delete this room?',
                text: 'This action cannot be undone.',
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