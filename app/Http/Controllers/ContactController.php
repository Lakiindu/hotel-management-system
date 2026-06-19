<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Notification;

class ContactController extends Controller
{
    // Store a contact message submitted from the frontend contact form
    public function store(Request $request)
    {
        // Validate the contact form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Save the contact message into the database
        $contact = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'status' => 'unread',
        ]);

        // Retrieve all admin accounts
        $admins = User::where('role', 'admin')->get();

        // Notify each admin about the new contact message
        foreach ($admins as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'New Contact Message',
                'message' => 'New message received from ' . $contact->name,
                'url' => route('admin.contacts.index'),
                'is_read' => false,
            ]);
        }
        // Redirect back to the contact section with a success message
        return redirect('/#contact')
            ->with('success', 'Your message has been sent successfully.');
    }
}