@extends('layouts.admin')

@section('title', 'Add Home Content')

@section('page-title', 'Add Home Content')

@section('page-subtitle', 'Create content sections for the homepage.')

@section('content')

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white p-8 rounded-[2rem] shadow">

    <form method="POST"
          action="{{ route('admin.hotel-contents.store') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="grid md:grid-cols-2 gap-6">

            <div>
                <label class="font-semibold">Section Key</label>

                <select name="section_key"
                        class="w-full border rounded-xl px-4 py-3 mt-2"
                        required>
                    <option value="">Select Section</option>
                    <option value="hero" {{ old('section_key') == 'hero' ? 'selected' : '' }}>Hero Section</option>
                    <option value="about" {{ old('section_key') == 'about' ? 'selected' : '' }}>About Section</option>
                    <option value="mission" {{ old('section_key') == 'mission' ? 'selected' : '' }}>Mission</option>
                    <option value="vision" {{ old('section_key') == 'vision' ? 'selected' : '' }}>Vision</option>
                    <option value="contact" {{ old('section_key') == 'contact' ? 'selected' : '' }}>Contact</option>
                    <option value="footer" {{ old('section_key') == 'footer' ? 'selected' : '' }}>Footer</option>
                </select>
            </div>

            <div>
                <label class="font-semibold">Title</label>

                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       class="w-full border rounded-xl px-4 py-3 mt-2">
            </div>

        </div>

        <div class="mt-6">
            <label class="font-semibold">Content</label>

            <textarea name="content"
                      rows="8"
                      class="w-full border rounded-xl px-4 py-3 mt-2">{{ old('content') }}</textarea>
        </div>

        <div class="mt-6">
            <label class="font-semibold">Image</label>

            <input type="file"
                   name="image"
                   class="w-full border rounded-xl px-4 py-3 mt-2">
        </div>

        <div class="mt-6">
            <label class="flex items-center gap-3">
                <input type="checkbox"
                       name="is_active"
                       value="1"
                       {{ old('is_active', true) ? 'checked' : '' }}>

                <span class="font-semibold">Active Content</span>
            </label>
        </div>

        <div class="mt-8 flex gap-4">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700">
                Save Content
            </button>

            <a href="{{ route('admin.hotel-contents.index') }}"
               class="bg-gray-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-600">
                Cancel
            </a>
        </div>

    </form>

</div>

@endsection