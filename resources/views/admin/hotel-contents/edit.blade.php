@extends('layouts.admin')

{{-- Browser tab title --}}
@section('title', 'Edit Home Content')

{{-- Page heading --}}
@section('page-title', 'Edit Home Content')

{{-- Page subheading --}}
@section('page-subtitle', 'Update homepage content sections.')

@section('content')

{{-- Display validation errors if update fails --}}
@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Main edit form container --}}
<div class="bg-white p-8 rounded-[2rem] shadow">

    {{-- Form submits updated content data --}}
    <form method="POST"
          action="{{ route('admin.hotel-contents.update', $hotelContent->id) }}"
          enctype="multipart/form-data">

        @csrf

        {{-- Converts POST request into PUT request for update --}}
        @method('PUT')

        {{-- Section Key and Title Fields --}}
        <div class="grid md:grid-cols-2 gap-6">

            {{-- Homepage Section Identifier --}}
            <div>
                <label class="font-semibold">
                    Section Key
                </label>

                <select name="section_key"
                        class="w-full border rounded-xl px-4 py-3 mt-2"
                        required>

                    <option value="hero"
                        {{ old('section_key', $hotelContent->section_key) == 'hero' ? 'selected' : '' }}>
                        Hero Section
                    </option>

                    <option value="about"
                        {{ old('section_key', $hotelContent->section_key) == 'about' ? 'selected' : '' }}>
                        About Section
                    </option>

                    <option value="mission"
                        {{ old('section_key', $hotelContent->section_key) == 'mission' ? 'selected' : '' }}>
                        Mission
                    </option>

                    <option value="vision"
                        {{ old('section_key', $hotelContent->section_key) == 'vision' ? 'selected' : '' }}>
                        Vision
                    </option>

                    <option value="contact"
                        {{ old('section_key', $hotelContent->section_key) == 'contact' ? 'selected' : '' }}>
                        Contact
                    </option>

                    <option value="footer"
                        {{ old('section_key', $hotelContent->section_key) == 'footer' ? 'selected' : '' }}>
                        Footer
                    </option>

                </select>
            </div>

            {{-- Content Title --}}
            <div>
                <label class="font-semibold">
                    Title
                </label>

                <input type="text"
                       name="title"
                       value="{{ old('title', $hotelContent->title) }}"
                       class="w-full border rounded-xl px-4 py-3 mt-2">
            </div>

        </div>

        {{-- Main Content Text --}}
        <div class="mt-6">
            <label class="font-semibold">
                Content
            </label>

            <textarea name="content"
                      rows="8"
                      class="w-full border rounded-xl px-4 py-3 mt-2">{{ old('content', $hotelContent->content) }}</textarea>
        </div>

        {{-- Display Current Image --}}
        @if($hotelContent->image)
            <div class="mt-6">
                <label class="font-semibold">
                    Current Image
                </label>

                <img src="{{ asset('storage/' . $hotelContent->image) }}"
                     class="w-48 h-32 object-cover rounded-xl mt-3">
            </div>
        @endif

        {{-- Upload New Image --}}
        <div class="mt-6">
            <label class="font-semibold">
                Change Image
            </label>

            <input type="file"
                   name="image"
                   class="w-full border rounded-xl px-4 py-3 mt-2">
        </div>

        {{-- Active / Inactive Status --}}
        <div class="mt-6">
            <label class="flex items-center gap-3">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', $hotelContent->is_active) ? 'checked' : '' }}>

                <span class="font-semibold">
                    Active Content
                </span>
            </label>
        </div>

        {{-- Form Action Buttons --}}
        <div class="mt-8 flex gap-4">

            {{-- Save Updated Content --}}
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700">
                Update Content
            </button>

            {{-- Return to Content List --}}
            <a href="{{ route('admin.hotel-contents.index') }}"
               class="bg-gray-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-600">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection