<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $rooms = Room::where('status', 'available')
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.home', compact('rooms'));
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