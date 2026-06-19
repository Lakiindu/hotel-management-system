<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    // Display all contact messages in the admin panel
    public function index()
    {
        // Retrieve the latest contact messages with pagination
        $contacts = Contact::latest()->paginate(10);

        // Pass the messages to the contacts list view
        return view('admin.contacts.index', compact('contacts'));
    }

    // Display a single contact message
    public function show(Contact $contact)
    {
        // If the message is unread, mark it as read
        if ($contact->status === 'unread') {
            $contact->update([
                'status' => 'read'
            ]);
        }

        // Show the selected contact message
        return view('admin.contacts.show', compact('contact'));
    }

    // Delete a contact message
    public function destroy(Contact $contact)
    {
        // Remove the selected message from the database
        $contact->delete();

        // Return back with a success message
        return back()->with('success', 'Message deleted successfully.');
    }
}