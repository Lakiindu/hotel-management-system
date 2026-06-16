@extends('layouts.admin')

@section('title', 'Edit Room')

@section('page-title', 'Edit Room')

@section('page-subtitle', 'Update room details, pricing, facilities and availability.')

@section('content')

<div class="max-w-7xl mx-auto">

    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('admin.rooms.index') }}"
           class="inline-flex items-center gap-2 bg-white px-5 py-3 rounded-2xl shadow font-bold text-slate-700 hover:bg-amber-400 hover:text-slate-950 transition">
            <i data-lucide="arrow-left" class="w-5"></i>
            Back to Rooms
        </a>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-5 rounded-3xl mb-6 shadow">
            <h3 class="font-bold mb-2">Please fix these errors:</h3>

            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Edit Room Form --}}
    <form method="POST"
          action="{{ route('admin.rooms.update', $room->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="grid lg:grid-cols-3 gap-8 items-start">

            {{-- Left Side: Room Image --}}
            <div class="lg:col-span-1">

                <div class="bg-white rounded-[2rem] shadow p-6">

                    <h2 class="text-2xl font-extrabold mb-4">
                        Room Image
                    </h2>

                    @if($room->image)
                        <img src="{{ asset('storage/' . $room->image) }}"
                             class="w-full h-72 object-cover rounded-3xl shadow mb-5"
                             alt="{{ $room->room_type }}">
                    @else
                        <div class="w-full h-72 bg-slate-100 rounded-3xl flex items-center justify-center text-slate-400 mb-5">
                            No Image Available
                        </div>
                    @endif

                    <label class="font-bold text-slate-700">
                        Upload New Image
                    </label>

                    <input name="image"
                           type="file"
                           class="w-full mt-2 border border-slate-200 p-3 rounded-2xl">

                    <p class="text-sm text-slate-500 mt-3">
                        Leave empty if you do not want to change the current image.
                    </p>

                </div>

            </div>

            {{-- Right Side: Room Details --}}
            <div class="lg:col-span-2">

                <div class="bg-white rounded-[2rem] shadow p-8">

                    {{-- Section Title --}}
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

                        <div>
                            <h2 class="text-2xl font-extrabold">
                                Room Information
                            </h2>

                            <p class="text-slate-500 mt-1">
                                Edit the main room details and availability.
                            </p>
                        </div>

                        <span class="px-4 py-2 rounded-full text-sm font-bold
                            {{ $room->status == 'available' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $room->status == 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                            {{ $room->status == 'maintenance' ? 'bg-yellow-100 text-yellow-700' : '' }}">
                            {{ ucfirst($room->status) }}
                        </span>

                    </div>

                    {{-- Basic Room Fields --}}
                    <div class="grid md:grid-cols-2 gap-5">

                        {{-- Room Number --}}
                        <div>
                            <label class="font-bold text-slate-700">
                                Room Number
                            </label>

                            <input name="room_number"
                                   value="{{ old('room_number', $room->room_number) }}"
                                   class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none">
                        </div>

                        {{-- Room Type --}}
                        <div>
                            <label class="font-bold text-slate-700">
                                Room Type
                            </label>

                            <input name="room_type"
                                   value="{{ old('room_type', $room->room_type) }}"
                                   class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none">
                        </div>

                        {{-- Price --}}
                        <div>
                            <label class="font-bold text-slate-700">
                                Price Per Night
                            </label>

                            <input name="price_per_night"
                                   type="number"
                                   step="0.01"
                                   value="{{ old('price_per_night', $room->price_per_night) }}"
                                   class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none">
                        </div>

                        {{-- Capacity --}}
                        <div>
                            <label class="font-bold text-slate-700">
                                Capacity
                            </label>

                            <input name="capacity"
                                   type="number"
                                   value="{{ old('capacity', $room->capacity) }}"
                                   class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none">
                        </div>

                        {{-- Status --}}
                        <div class="md:col-span-2">
                            <label class="font-bold text-slate-700">
                                Status
                            </label>

                            <select name="status"
                                    class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none">
                                <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>
                                    Available
                                </option>

                                <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>
                                    Occupied
                                </option>

                                <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>
                                    Maintenance
                                </option>
                            </select>
                        </div>

                    </div>

                    {{-- Description --}}
                    <div class="mt-8">
                        <label class="font-bold text-slate-700">
                            Description
                        </label>

                        <textarea name="description"
                                  rows="5"
                                  class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none">{{ old('description', $room->description) }}</textarea>
                    </div>

                    {{-- Facilities --}}
                    <div class="mt-6">
                        <label class="font-bold text-slate-700">
                            Facilities
                        </label>

                        <input name="facilities"
                               value="{{ old('facilities', is_array($room->facilities) ? implode(', ', $room->facilities) : '') }}"
                               class="w-full mt-2 border border-slate-200 p-4 rounded-2xl focus:border-amber-400 outline-none"
                               placeholder="Free WiFi, Air Conditioning, Smart TV, Mini Bar">

                        <p class="text-sm text-slate-500 mt-2">
                            Separate facilities using commas.
                        </p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row justify-end gap-4 mt-8 pt-6 border-t border-slate-100">

                        <a href="{{ route('admin.rooms.index') }}"
                           class="bg-slate-200 text-slate-800 px-8 py-4 rounded-2xl font-bold hover:bg-slate-300 transition text-center">
                            Cancel
                        </a>

                        <button type="submit"
                                class="bg-amber-400 text-slate-950 px-8 py-4 rounded-2xl font-extrabold hover:bg-amber-300 transition">
                            Update Room
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection