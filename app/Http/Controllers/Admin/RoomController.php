<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    // Display all rooms with search and status filters
    public function index(Request $request)
    {
        // Get search keyword and selected status filter
        $search = $request->search;
        $status = $request->status;

        // Retrieve rooms based on search and status
        $rooms = Room::query()

            // Search by room number or room type
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('room_number', 'like', "%{$search}%")
                        ->orWhere('room_type', 'like', "%{$search}%");
                });
            })

            // Filter by room status
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })

            // Show newest rooms first
            ->latest()
            ->paginate(9)
            ->withQueryString();

        // Return room list to the admin page
        return view('admin.rooms.index', compact('rooms', 'search', 'status'));
    }

    // Return room data using AJAX for live searching/filtering
    public function ajaxRooms(Request $request)
    {
        // Get search keyword and selected status
        $search = $request->search;
        $status = $request->status;

        // Retrieve filtered room records
        $rooms = Room::query()

            // Search by room number or room type
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('room_number', 'like', "%{$search}%")
                        ->orWhere('room_type', 'like', "%{$search}%");
                });
            })

            // Filter by room status
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })

            // Show newest rooms first
            ->latest()
            ->get();

        // Return room data as JSON
        return response()->json([
            'success' => true,
            'rooms' => $rooms,
        ]);
    }

    // Display the Add Room page
    public function create()
    {
        return view('admin.rooms.create');
    }

    // Store a newly created room
    public function store(Request $request)
    {
        // Validate room information
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms',
            'room_type' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // Default image path
        $imagePath = null;

        // Upload image if one was selected
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        // Create the new room
        Room::create([
            'room_number' => $request->room_number,
            'room_type' => $request->room_type,
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'description' => $request->description,

            // Convert comma-separated facilities into an array
            'facilities' => $request->facilities
                ? array_map('trim', explode(',', $request->facilities))
                : [],

            'status' => $request->status,
            'image' => $imagePath,
        ]);

        // Redirect back with success message
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room added successfully.');
    }

    // Display Edit Room page
    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    // Update an existing room
    public function update(Request $request, Room $room)
    {
        // Validate updated room information
        $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'room_type' => 'required|string|max:255',
            'price_per_night' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'facilities' => 'nullable|string',
            'status' => 'required|in:available,occupied,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
        ]);

        // Keep existing image unless a new one is uploaded
        $imagePath = $room->image;

        // Replace image if a new one is uploaded
        if ($request->hasFile('image')) {

            // Delete old image from storage
            if ($room->image) {
                Storage::disk('public')->delete($room->image);
            }

            // Store new image
            $imagePath = $request->file('image')->store('rooms', 'public');
        }

        // Update room details
        $room->update([
            'room_number' => $request->room_number,
            'room_type' => $request->room_type,
            'price_per_night' => $request->price_per_night,
            'capacity' => $request->capacity,
            'description' => $request->description,

            // Convert facilities string into an array
            'facilities' => $request->facilities
                ? array_map('trim', explode(',', $request->facilities))
                : [],

            'status' => $request->status,
            'image' => $imagePath,
        ]);

        // Redirect back with success message
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    // Delete a room
    public function destroy(Room $room)
    {
        // Delete room image if it exists
        if ($room->image) {
            Storage::disk('public')->delete($room->image);
        }

        // Delete room record
        $room->delete();

        // Redirect back with success message
        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room deleted successfully.');
    }
}