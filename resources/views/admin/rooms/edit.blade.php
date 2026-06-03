<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white p-8 rounded-3xl shadow">

        <h1 class="text-3xl font-bold mb-6">Edit Room</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.rooms.update', $room->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid md:grid-cols-2 gap-5">
                <input name="room_number" value="{{ old('room_number', $room->room_number) }}" class="border p-3 rounded-xl">
                <input name="room_type" value="{{ old('room_type', $room->room_type) }}" class="border p-3 rounded-xl">
                <input name="price_per_night" type="number" step="0.01" value="{{ old('price_per_night', $room->price_per_night) }}" class="border p-3 rounded-xl">
                <input name="capacity" type="number" value="{{ old('capacity', $room->capacity) }}" class="border p-3 rounded-xl">

                <select name="status" class="border p-3 rounded-xl">
                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>

                <input name="image" type="file" class="border p-3 rounded-xl">
            </div>

            @if($room->image)
                <img src="{{ asset('storage/' . $room->image) }}" class="w-40 h-28 object-cover rounded-xl mt-5">
            @endif

            <textarea name="description" rows="4" class="border p-3 rounded-xl w-full mt-5">{{ old('description', $room->description) }}</textarea>

            <input name="facilities"
                   value="{{ old('facilities', is_array($room->facilities) ? implode(', ', $room->facilities) : '') }}"
                   class="border p-3 rounded-xl w-full mt-5">

            <div class="flex gap-3 mt-6">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-xl">
                    Update Room
                </button>

                <a href="{{ route('admin.rooms.index') }}" class="bg-slate-200 px-6 py-3 rounded-xl">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

</body>
</html>