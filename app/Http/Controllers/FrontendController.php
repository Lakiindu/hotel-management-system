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

        // Get unique room types for the home page search dropdown
        $roomTypes = Room::select('room_type')
            ->distinct()
            ->orderBy('room_type')
            ->pluck('room_type');

        return view('frontend.home', compact(
            'rooms',
            'services',
            'galleries',
            'contents',
            'roomTypes'
        ));
    }

    public function rooms(Request $request)
    {
        // Store search values so we can show them in the rooms page
        $checkIn = $request->check_in;
        $checkOut = $request->check_out;
        $guests = $request->guests;
        $roomCount = $request->room_count;

        $rooms = Room::query()

            // Search by room number or room type
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('room_number', 'like', "%{$request->search}%")
                      ->orWhere('room_type', 'like', "%{$request->search}%");
                });
            })

            // Filter by selected room type
            ->when($request->type, function ($query) use ($request) {
                $query->where('room_type', $request->type);
            })

            // Filter by selected room status
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })

            // Filter by guest count
            ->when($request->guests, function ($query) use ($request) {
                $query->where('capacity', '>=', $request->guests);
            })

            // Show only rooms that are not already booked between selected dates
            ->when($request->check_in && $request->check_out, function ($query) use ($request) {
                $query->whereDoesntHave('bookings', function ($booking) use ($request) {
                    $booking->where('status', '!=', 'cancelled')
                        ->where(function ($q) use ($request) {
                            $q->whereBetween('check_in_date', [
                                $request->check_in,
                                $request->check_out
                            ])
                            ->orWhereBetween('check_out_date', [
                                $request->check_in,
                                $request->check_out
                            ])
                            ->orWhere(function ($inside) use ($request) {
                                $inside->where('check_in_date', '<=', $request->check_in)
                                       ->where('check_out_date', '>=', $request->check_out);
                            });
                        });
                });
            })

            // Sort by low price
            ->when($request->sort == 'price_low', function ($query) {
                $query->orderBy('price_per_night', 'asc');
            })

            // Sort by high price
            ->when($request->sort == 'price_high', function ($query) {
                $query->orderBy('price_per_night', 'desc');
            })

            // Sort by room type
            ->when($request->sort == 'type', function ($query) {
                $query->orderBy('room_type', 'asc');
            })

            // Default sort by newest
            ->when(!$request->sort || $request->sort == 'newest', function ($query) {
                $query->latest();
            })

            ->paginate(9)
            ->withQueryString();

        // Get all room types for dropdown
        $roomTypes = Room::select('room_type')
            ->distinct()
            ->orderBy('room_type')
            ->pluck('room_type');

        $totalRooms = Room::count();

        $availableRooms = Room::where('status', 'available')->count();

        return view('frontend.rooms', compact(
            'rooms',
            'roomTypes',
            'totalRooms',
            'availableRooms',
            'checkIn',
            'checkOut',
            'guests',
            'roomCount'
        ));
    }

    public function roomDetails(Room $room)
    {
        return view('frontend.room-details', compact('room'));
    }

    public function ajaxRooms(Request $request)
    {
        $rooms = Room::query()

            // Search by room number or room type
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('room_number', 'like', "%{$request->search}%")
                      ->orWhere('room_type', 'like', "%{$request->search}%");
                });
            })

            // Filter by selected room type
            ->when($request->type, function ($query) use ($request) {
                $query->where('room_type', $request->type);
            })

            // Filter by selected room status
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })

            // Filter by guest count
            ->when($request->guests, function ($query) use ($request) {
                $query->where('capacity', '>=', $request->guests);
            })

            // Show only rooms that are not already booked between selected dates
            ->when($request->check_in && $request->check_out, function ($query) use ($request) {
                $query->whereDoesntHave('bookings', function ($booking) use ($request) {
                    $booking->where('status', '!=', 'cancelled')
                        ->where(function ($q) use ($request) {
                            $q->whereBetween('check_in_date', [
                                $request->check_in,
                                $request->check_out
                            ])
                            ->orWhereBetween('check_out_date', [
                                $request->check_in,
                                $request->check_out
                            ])
                            ->orWhere(function ($inside) use ($request) {
                                $inside->where('check_in_date', '<=', $request->check_in)
                                       ->where('check_out_date', '>=', $request->check_out);
                            });
                        });
                });
            })

            // Sort by low price
            ->when($request->sort == 'price_low', function ($query) {
                $query->orderBy('price_per_night', 'asc');
            })

            // Sort by high price
            ->when($request->sort == 'price_high', function ($query) {
                $query->orderBy('price_per_night', 'desc');
            })

            // Sort by room type
            ->when($request->sort == 'type', function ($query) {
                $query->orderBy('room_type', 'asc');
            })

            // Default sort by newest
            ->when(!$request->sort || $request->sort == 'newest', function ($query) {
                $query->latest();
            })

            ->get();

        return response()->json([
            'success' => true,
            'rooms' => $rooms,
        ]);
    }
}