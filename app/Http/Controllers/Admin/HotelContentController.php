<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HotelContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HotelContentController extends Controller
{
    public function index()
    {
        $contents = HotelContent::latest()->paginate(10);
        return view('admin.hotel-contents.index', compact('contents'));
    }

    public function create()
    {
        return view('admin.hotel-contents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'section_key' => 'required|string|max:255|unique:hotel_contents,section_key',
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('hotel_contents', 'public');
        }

        HotelContent::create([
            'section_key' => $request->section_key,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hotel-contents.index')
            ->with('success', 'Hotel content added successfully.');
    }

    public function edit(HotelContent $hotelContent)
    {
        return view('admin.hotel-contents.edit', compact('hotelContent'));
    }

    public function update(Request $request, HotelContent $hotelContent)
    {
        $request->validate([
            'section_key' => 'required|string|max:255|unique:hotel_contents,section_key,' . $hotelContent->id,
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $imagePath = $hotelContent->image;

        if ($request->hasFile('image')) {
            if ($hotelContent->image) {
                Storage::disk('public')->delete($hotelContent->image);
            }

            $imagePath = $request->file('image')->store('hotel_contents', 'public');
        }

        $hotelContent->update([
            'section_key' => $request->section_key,
            'title' => $request->title,
            'content' => $request->content,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.hotel-contents.index')
            ->with('success', 'Hotel content updated successfully.');
    }

    public function destroy(HotelContent $hotelContent)
    {
        if ($hotelContent->image) {
            Storage::disk('public')->delete($hotelContent->image);
        }

        $hotelContent->delete();

        return redirect()->route('admin.hotel-contents.index')
            ->with('success', 'Hotel content deleted successfully.');
    }
}