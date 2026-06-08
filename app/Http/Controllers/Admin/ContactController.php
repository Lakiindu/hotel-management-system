<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);

        return view('admin.contacts.index', compact('contacts'));
    }

    public function show(Contact $contact)
{
    if ($contact->status === 'unread') {
        $contact->update([
            'status' => 'read'
        ]);
    }

    return view('admin.contacts.show', compact('contact'));
}

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return back()->with('success', 'Message deleted successfully.');
    }
}