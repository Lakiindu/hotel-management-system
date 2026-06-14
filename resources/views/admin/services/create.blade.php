@extends('layouts.admin')

@section('title', 'Add Service')

@section('content')

{{-- Display Validation Errors --}}
@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Main Service Form Container --}}
<div class="bg-white p-8 rounded-3xl shadow">

    {{-- Page Heading --}}
    <h2 class="text-2xl font-bold mb-6">
        Add Service
    </h2>

    {{-- Form for creating a new service --}}
    <form method="POST"
          action="{{ route('admin.services.store') }}"
          enctype="multipart/form-data">
        @csrf

        {{-- Title and Icon Fields --}}
        <div class="grid md:grid-cols-2 gap-6">

        {{-- Service Title --}}
            <div>
                <label class="font-semibold">Title</label>

                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       class="w-full border p-3 rounded-xl mt-2"
                       required>
            </div>

        {{-- Service Icon --}}
            <div>
                <label class="font-semibold">Icon</label>

                <input type="text"
                       name="icon"
                       value="{{ old('icon') }}"
                       placeholder="fa-solid fa-dumbbell"
                       class="w-full border p-3 rounded-xl mt-2">
            </div>

        {{-- Service Description --}}
        </div>

        <div class="mt-5">
            <label class="font-semibold">Description</label>

            <textarea name="description"
                      rows="5"
                      class="w-full border p-3 rounded-xl mt-2">{{ old('description') }}</textarea>
        </div>

        {{-- Service Image Upload --}}
        <div class="mt-5">
            <label class="font-semibold">Image</label>

            <input type="file"
                   name="image"
                   class="w-full border p-3 rounded-xl mt-2">
        </div>

        {{-- Service Status --}}
        <div class="mt-5">
            <label class="flex items-center gap-3">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}>

                <span class="font-semibold">Active Service</span>
            </label>
        </div>

        {{-- Form Action Buttons --}}
        <div class="mt-6 flex gap-4">

        {{-- Save Service --}}
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700">
                Save Service
            </button>

            {{-- Return to Service List --}}
            <a href="{{ route('admin.services.index') }}"
               class="bg-gray-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-600">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection