@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')
@section('page-subtitle', 'View messages sent from the contact form')

@section('content')
<div class="bg-white rounded-3xl shadow p-6">

    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="border-b text-slate-500">
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Message</th>
                    <th class="p-4">Status</th>
                    <th class="p-4">Date</th>
                    <th class="p-4">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($contacts as $contact)
                    <tr class="border-b hover:bg-slate-50">
                        <td class="p-4 font-bold">{{ $contact->name }}</td>
                        <td class="p-4">{{ $contact->email }}</td>
                        <td class="p-4">{{ Str::limit($contact->message, 50) }}</td>
                        <td class="p-4">
                            <span class="px-3 py-1 rounded-full text-sm
                                {{ $contact->status == 'unread' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700' }}">
                                {{ ucfirst($contact->status) }}
                            </span>
                        </td>
                        <td class="p-4">{{ $contact->created_at->format('Y-m-d') }}</td>
                        <td class="p-4">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}"
                               class="bg-slate-950 text-white px-4 py-2 rounded-xl text-sm">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-slate-500">
                            No contact messages found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $contacts->links() }}
    </div>

</div>
@endsection