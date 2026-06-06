<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $rooms = Room::query()
            ->when($search, function ($query) use ($search) {
                $query->where('room_number', 'like', "%{$search}%")
                    ->orWhere('room_type', 'like', "%{$search}%");
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(6);

        return view('admin.rooms.index', compact('rooms', 'search', 'status'));
    }

    public function ajaxRooms(Request $request)
    {
        $search = $request->search;
        $status = $request->status;

        $rooms = Room::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('room_number', 'like', "%{$search}%")
                        ->orWhere('room_type', 'like', "%{$search}%");
                });
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'rooms' => $rooms,
        ]);
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms',
            'room_type' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        Room::create([
            'room_number' => $request->room_number,
            'room_type' => $request->room_type,
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'facilities' => $request->facilities
                ? array_map('trim', explode(',', $request->facilities))
                : [],
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room added successfully.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'room_type' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = $room->image;

        if ($request->hasFile('image')) {
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }

            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        $room->update([
            'room_number' => $request->room_number,
            'room_type' => $request->room_type,
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'facilities' => $request->facilities
                ? array_map('trim', explode(',', $request->facilities))
                : [],
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}