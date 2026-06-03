<!DOCTYPE html>
<html>
<head>
    <title>Add Room</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100">

<div class="max-w-4xl mx-auto py-10">
    <div class="bg-white p-8 rounded-3xl shadow">

        <h1 class="text-3xl font-bold mb-6">Add New Room</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="grid md:grid-cols-2 gap-5">
                <input name="room_number" placeholder="Room Number" class="border p-3 rounded-xl" value="{{ old('room_number') }}">
                <input name="room_type" placeholder="Room Type" class="border p-3 rounded-xl" value="{{ old('room_type') }}">
                <input name="price_per_night" type="number" step="0.01" placeholder="Price Per Night" class="border p-3 rounded-xl" value="{{ old('price_per_night') }}">
                <input name="capacity" type="number" placeholder="Capacity" class="border p-3 rounded-xl" value="{{ old('capacity') }}">

                <select name="status" class="border p-3 rounded-xl">
                    <option value="available">Available</option>
                    <option value="occupied">Occupied</option>
                    <option value="maintenance">Maintenance</option>
                </select>

                <input name="image" type="file" class="border p-3 rounded-xl">
            </div>

            <textarea name="description" placeholder="Description" rows="4" class="border p-3 rounded-xl w-full mt-5">{{ old('description') }}</textarea>

            <input name="facilities" placeholder="Facilities: WiFi, AC, TV, Mini Bar" class="border p-3 rounded-xl w-full mt-5" value="{{ old('facilities') }}">

            <div class="flex gap-3 mt-6">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-xl">
                    Save Room
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