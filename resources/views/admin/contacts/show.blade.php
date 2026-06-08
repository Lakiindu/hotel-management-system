@extends('layouts.admin')

@section('title', 'View Contact Message')
@section('page-title', 'Contact Message')
@section('page-subtitle', 'View customer inquiry details')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="bg-white rounded-3xl shadow-lg p-8">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-extrabold text-slate-900">
                Message Details
            </h2>

            <span class="px-4 py-2 rounded-full text-sm font-bold
                {{ $contact->status == 'unread'
                    ? 'bg-amber-100 text-amber-700'
                    : 'bg-green-100 text-green-700' }}">
                {{ ucfirst($contact->status) }}
            </span>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-8">

            <div>
                <label class="block text-sm font-bold text-slate-500 mb-2">
                    Name
                </label>

                <div class="bg-slate-100 rounded-2xl p-4">
                    {{ $contact->name }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-500 mb-2">
                    Email
                </label>

                <div class="bg-slate-100 rounded-2xl p-4">
                    {{ $contact->email }}
                </div>
            </div>

        </div>

        <div class="mb-8">
            <label class="block text-sm font-bold text-slate-500 mb-2">
                Message
            </label>

            <div class="bg-slate-100 rounded-2xl p-6 min-h-[200px] whitespace-pre-line">
                {{ $contact->message }}
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-6 mb-8">

            <div>
                <label class="block text-sm font-bold text-slate-500 mb-2">
                    Received On
                </label>

                <div class="bg-slate-100 rounded-2xl p-4">
                    {{ $contact->created_at->format('F d, Y h:i A') }}
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-500 mb-2">
                    Status
                </label>

                <div class="bg-slate-100 rounded-2xl p-4">
                    {{ ucfirst($contact->status) }}
                </div>
            </div>

        </div>

        <div class="flex flex-wrap gap-4">

            <a href="{{ route('admin.contacts.index') }}"
               class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-800 transition">
                Back to Messages
            </a>

            <form action="{{ route('admin.contacts.destroy', $contact->id) }}"
                  method="POST"
                  onsubmit="return confirm('Delete this message?')">

                @csrf
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