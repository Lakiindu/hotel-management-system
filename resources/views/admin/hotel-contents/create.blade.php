@extends('layouts.admin')

{{-- Browser tab title --}}
@section('title', 'Add Home Content')

{{-- Admin header title --}}
@section('page-title', 'Add Home Content')

{{-- Admin header subtitle --}}
@section('page-subtitle', 'Create content sections for the homepage.')

@section('content')

{{-- Display validation errors if form submission fails --}}
@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
        <ul class="list-disc ml-5">

        {{-- Loop through all validation error messages --}}
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Main form card --}}
<div class="bg-white p-8 rounded-[2rem] shadow">

{{-- Form to save new homepage content --}}
    <form method="POST"
          action="{{ route('admin.hotel-contents.store') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="grid md:grid-cols-2 gap-6">

        {{-- Select which homepage section this content belongs to --}}
            <div>
                <label class="font-semibold">Section Key</label>

                <select name="section_key"
                        class="w-full border rounded-xl px-4 py-3 mt-2"
                        required>

                        {{-- old() keeps selected value after validation error --}}
                    <option value="">Select Section</option>
                    <option value="hero" {{ old('section_key') == 'hero' ? 'selected' : '' }}>Hero Section</option>
                    <option value="about" {{ old('section_key') == 'about' ? 'selected' : '' }}>About Section</option>
                    <option value="mission" {{ old('section_key') == 'mission' ? 'selected' : '' }}>Mission</option>
                    <option value="vision" {{ old('section_key') == 'vision' ? 'selected' : '' }}>Vision</option>
                    <option value="contact" {{ old('section_key') == 'contact' ? 'selected' : '' }}>Contact</option>
                    <option value="footer" {{ old('section_key') == 'footer' ? 'selected' : '' }}>Footer</option>
                </select>
            </div>

            {{-- Content title field --}}
            <div>
                <label class="font-semibold">Title</label>

                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       class="w-full border rounded-xl px-4 py-3 mt-2">
            </div>

        </div>

        {{-- Main content text field --}}
        <div class="mt-6">
            <label class="font-semibold">Content</label>

            <textarea name="content"
                      rows="8"
                      class="w-full border rounded-xl px-4 py-3 mt-2">{{ old('content') }}</textarea>
        </div>

        {{-- Homepage section image upload --}}
        <div class="mt-6">
            <label class="font-semibold">Image</label>

            <input type="file"
                   name="image"
                   class="w-full border rounded-xl px-4 py-3 mt-2">
        </div>

        {{-- Active / inactive status --}}
        <div class="mt-6">
            <label class="flex items-center gap-3">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}>

                <span class="font-semibold">Active Content</span>
            </label>
        </div>

        {{-- Form buttons --}}
        <div class="mt-8 flex gap-4">
            {{-- Submit form and save content --}}
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700">
                Save Content
            </button>

            {{-- Go back without saving --}}
            <a href="{{ route('admin.hotel-contents.index') }}"
               class="bg-gray-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-600">
                Cancel
            </a>
        </div>

    </form>

</div>

@endsection