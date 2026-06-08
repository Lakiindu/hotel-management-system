<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'New Contact Message',
                'message' => 'New message received from ' . $contact->name,
                'url' => route('admin.contacts.index'),
                'is_read' => false,
            ]);
        }

        return redirect('/#contact')
            ->with('success', 'Your message has been sent successfully.');
    }
}