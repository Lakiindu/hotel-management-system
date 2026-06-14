<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Handles gallery image management in the admin panel
class GalleryController extends Controller
{
    // Display gallery images with pagination
    public function index()
    {
        $galleries = Gallery::latest()->paginate(6);

        return view('admin.galleries.index', compact('galleries'));
    }

    // Show form to upload a new gallery image
    public function create()
    {
        return view('admin.galleries.create');
    }

    // Validate and store a new gallery image
    public function store(Request $request)
    {
        // Validate form inputs and uploaded image
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ]);

        // Upload image to public storage
        $imagePath = $request->file('image')->store('galleries', 'public');

        // Save gallery record in database
        Gallery::create([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Redirect with success message
        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery image added successfully.');
    }

    // Show edit form for selected gallery image
    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    // Validate and update selected gallery image
    public function update(Request $request, Gallery $gallery)
    {
        // Validate updated form inputs
        $request->validate([
            'title' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ]);

        // Keep old image if no new image is uploaded
        $imagePath = $gallery->image;

        // Replace old image if a new image is uploaded
        if ($request->hasFile('image')) {

            // Delete old image from storage
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }

            // Upload new image
            $imagePath = $request->file('image')->store('galleries', 'public');
        }

        // Update gallery record in database
        $gallery->update([
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Redirect with success message
        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery image updated successfully.');
    }

    // Delete selected gallery image and its file
    public function destroy(Gallery $gallery)
    {
        // Delete image file from storage
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        // Delete gallery record from database
        $gallery->delete();

        // Redirect with success message
        return redirect()->route('admin.galleries.index')
            ->with('success', 'Gallery image deleted successfully.');
    }
}