<?php

namespace App\Http\Controllers;

use App\Models\Room;

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
}