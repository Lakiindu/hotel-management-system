<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Handles CRUD operations for hotel services in the admin panel
class ServiceController extends Controller
{
    // Display a paginated list of services
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    // Show the form for creating a new service
    public function create()
    {
        return view('admin.services.create');
    }

    // Store a newly created service in storage
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload if provided
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('services', 'public');
        }

        // Create new service record in the database
        Service::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Redirect back to services list with success message
        return redirect()->route('admin.services.index')
            ->with('success', 'Service added successfully.');
    }

    // Show the form for editing an existing service
    public function edit(Service $service)
    {
        return view('admin.services.edit', compact('service'));
    }

    // Update the specified service in storage
    public function update(Request $request, Service $service)
    {
        // Validate incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240',
            'is_active' => 'nullable|boolean',
        ]);

        // Handle image upload and replacement if a new image is provided
        $imagePath = $service->image;

        if ($request->hasFile('image')) {
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }

            $imagePath = $request->file('image')->store('services', 'public');
        }

        // Update service record in the database
        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);

        // Redirect back to services list with success message
        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully.');
    }

    // Remove the specified service from storage
    public function destroy(Service $service)
    {
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        // Redirect back to services list with success message
        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully.');
    }
}