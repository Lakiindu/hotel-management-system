@extends('layouts.admin')

{{-- Browser tab title --}}
@section('title', 'View Contact Message')

{{-- Page heading --}}
@section('page-title', 'Contact Message')

{{-- Page subtitle --}}
@section('page-subtitle', 'View customer inquiry details')

@section('content')

{{-- Centered container with max width --}}
<div class="max-w-4xl mx-auto">

    {{-- Main message card --}}
    <div class="bg-white rounded-3xl shadow-lg p-8">

        {{-- Header section --}}
        <div class="flex justify-between items-center mb-8">

            {{-- Page title --}}
            <h2 class="text-2xl font-extrabold text-slate-900">
                Message Details
            </h2>

            {{-- Message status badge --}}
            <span class="px-4 py-2 rounded-full text-sm font-bold
                {{ $contact->status == 'unread'
                    ? 'bg-amber-100 text-amber-700'
                    : 'bg-green-100 text-green-700' }}">

                {{ ucfirst($contact->status) }}

            </span>

        </div>

        {{-- Customer basic information --}}
        <div class="grid md:grid-cols-2 gap-6 mb-8">

            {{-- Customer name --}}
            <div>
                <label class="block text-sm font-bold text-slate-500 mb-2">
                    Name
                </label>

                <div class="bg-slate-100 rounded-2xl p-4">
                    {{ $contact->name }}
                </div>
            </div>

            {{-- Customer email --}}
            <div>
                <label class="block text-sm font-bold text-slate-500 mb-2">
                    Email
                </label>

                <div class="bg-slate-100 rounded-2xl p-4">
                    {{ $contact->email }}
                </div>
            </div>

        </div>

        {{-- Full contact message --}}
        <div class="mb-8">

            <label class="block text-sm font-bold text-slate-500 mb-2">
                Message
            </label>

            {{-- Shows full message content --}}
            <div class="bg-slate-100 rounded-2xl p-6 min-h-[200px] whitespace-pre-line">
                {{ $contact->message }}
            </div>

        </div>

        {{-- Additional message information --}}
        <div class="grid md:grid-cols-2 gap-6 mb-8">

            {{-- Message received date and time --}}
            <div>
                <label class="block text-sm font-bold text-slate-500 mb-2">
                    Received On
                </label>

                <div class="bg-slate-100 rounded-2xl p-4">
                    {{ $contact->created_at->format('F d, Y h:i A') }}
                </div>
            </div>

            {{-- Current status --}}
            <div>
                <label class="block text-sm font-bold text-slate-500 mb-2">
                    Status
                </label>

                <div class="bg-slate-100 rounded-2xl p-4">
                    {{ ucfirst($contact->status) }}
                </div>
            </div>

        </div>

        {{-- Action buttons --}}
        <div class="flex flex-wrap gap-4">

            {{-- Return to contact message list --}}
            <a href="{{ route('admin.contacts.index') }}"
               class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-800 transition">
                Back to Messages
            </a>

            {{-- Delete contact message --}}
            <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this message?')">

                @csrf

                {{-- Convert POST request to DELETE request --}}
                @method('DELETE')

                <button type="submit"
                        class="bg-red-500 text-white px-6 py-3 rounded-2xl font-bold hover:bg-red-600 transition">
                    Delete Message
                </button>

            </form>

        </div>

    </div>

</div>

@endsection