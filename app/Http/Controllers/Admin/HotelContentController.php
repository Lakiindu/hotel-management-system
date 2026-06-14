<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Handles CRUD operations for hotel content sections in the admin panel
class HotelContentController extends Controller
{
    // Display all hotel content records
    public function index()
    {
        $contents = HotelContent::latest()->paginate(10);
        return view('admin.hotel-contents.index', compact('contents'));
    }

    // Show the form for creating a new hotel content record
    public function create()
    {
        return view('admin.hotel-contents.create');
    }

    // Store a newly created hotel content record
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'section_key' => 'required|string|max:255|unique:hotel_contents,section_key',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload if provided
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotel_contents', 'public');
        }

        // Create new hotel content record in the database
        HotelContent::create([
            'section_key' => $request->section_key,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Redirect back to hotel content list with success message
        return redirect()->route('admin.hotel-contents.index')
            ->with('success', 'Hotel content added successfully.');
    }

    // Show the form for editing an existing hotel content record
    public function edit(HotelContent $hotelContent)
    {
        return view('admin.hotel-contents.edit', compact('hotelContent'));
    }

    // Update an existing hotel content record
    public function update(Request $request, HotelContent $hotelContent)
    {
        $request->validate([
            'section_key' => 'required|string|max:255|unique:hotel_contents,section_key,' . $hotelContent->id,
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload and replacement if a new image is provided
        $imagePath = $hotelContent->image;

        if ($request->hasFile('image')) {
            if ($hotelContent->image) {
                Storage::disk('public')->delete($hotelContent->image);
            }

            $imagePath = $request->file('image')->store('hotel_contents', 'public');
        }

        // Update hotel content record in the database
        $hotelContent->update([
            'section_key' => $request->section_key,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Redirect back to hotel content list with success message
        return redirect()->route('admin.hotel-contents.index')
            ->with('success', 'Hotel content updated successfully.');
    }

    // Delete a hotel content record
    public function destroy(HotelContent $hotelContent)
    {
        if ($hotelContent->image) {
            Storage::disk('public')->delete($hotelContent->image);
        }

        // Delete the hotel content record from the database
        $hotelContent->delete();

        // Redirect back to hotel content list with success message
        return redirect()->route('admin.hotel-contents.index')
            ->with('success', 'Hotel content deleted successfully.');
    }
}