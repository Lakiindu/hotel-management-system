<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Service;
use App\Models\Gallery;
use App\Models\HotelContent;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $rooms = Room::where('status', 'available')
            ->latest()
            ->take(3)
            ->get();

        $services = Service::where('is_active', true)
            ->latest()
            ->take(6)
            ->get();

        $galleries = Gallery::where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        $contents = HotelContent::where('is_active', true)
            ->get()
            ->keyBy('section_key');

        return view('frontend.home', compact(
            'rooms',
            'services',
            'galleries',
            'contents'
        ));
    }

    public function rooms(Request $request)
    {
        $rooms = Room::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('room_number', 'like', "%{$request->search}%")
                      ->orWhere('room_type', 'like', "%{$request->search}%");
                });
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('room_type', $request->type);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->paginate(6);

        $roomTypes = Room::select('room_type')
            ->distinct()
            ->pluck('room_type');

        return view('frontend.rooms', compact('rooms', 'roomTypes'));
    }

    public function roomDetails(Room $room)
    {
        return view('frontend.room-details', compact('room'));
    }

    public function ajaxRooms(Request $request)
    {
        $rooms = Room::query()
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('room_number', 'like', "%{$request->search}%")
                      ->orWhere('room_type', 'like', "%{$request->search}%");
                });
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('room_type', $request->type);
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'rooms' => $rooms,
        ]);
    }
}