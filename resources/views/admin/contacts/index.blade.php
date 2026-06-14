@extends('layouts.admin')

{{-- Browser tab title --}}
@section('title', 'Contact Messages')

{{-- Page heading --}}
@section('page-title', 'Contact Messages')

{{-- Page subtitle --}}
@section('page-subtitle', 'View messages sent from the contact form')

@section('content')

{{-- Main container card --}}
<div class="bg-white rounded-3xl shadow p-6">

    {{-- Makes table scroll horizontally on small screens --}}
    <div class="overflow-x-auto">

        {{-- Contact messages table --}}
        <table class="w-full text-left">

            {{-- Table headings --}}
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

                {{-- Loop through all contact messages --}}
                @forelse($contacts as $contact)

                    {{-- Single contact row --}}
                    <tr class="border-b hover:bg-slate-50">

                        {{-- Sender name --}}
                        <td class="p-4 font-bold">
                            {{ $contact->name }}
                        </td>

                        {{-- Sender email --}}
                        <td class="p-4">
                            {{ $contact->email }}
                        </td>

                        {{-- Show first 50 characters of message --}}
                        <td class="p-4">
                            {{ Str::limit($contact->message, 50) }}
                        </td>

                        {{-- Message status --}}
                        <td class="p-4">

                            {{-- Badge color changes based on status --}}
                            <span class="px-3 py-1 rounded-full text-sm
                                {{ $contact->status == 'unread'
                                    ? 'bg-amber-100 text-amber-700'
                                    : 'bg-green-100 text-green-700' }}">

                                {{ ucfirst($contact->status) }}

                            </span>

                        </td>

                        {{-- Message date --}}
                        <td class="p-4">
                            {{ $contact->created_at->format('Y-m-d') }}
                        </td>

                        {{-- View message button --}}
                        <td class="p-4">
                            <a href="{{ route('admin.contacts.show', $contact->id) }}"
                               class="bg-slate-950 text-white px-4 py-2 rounded-xl text-sm">
                                View
                            </a>
                        </td>

                    </tr>

                {{-- If no contact messages exist --}}
                @empty

                    <tr>
                        <td colspan="6"
                            class="p-6 text-center text-slate-500">

                            No contact messages found.

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- Pagination links --}}
    <div class="mt-6">
        {{ $contacts->links() }}
    </div>

</div>

@endsection