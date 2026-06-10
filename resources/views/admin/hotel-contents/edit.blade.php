@extends('layouts.admin')

@section('title', 'Edit Home Content')

@section('page-title', 'Edit Home Content')

@section('page-subtitle', 'Update homepage content sections.')

@section('content')

<div class="bg-white p-8 rounded-[2rem] shadow">

    <form method="POST"
          action="{{ route('admin.hotel-contents.update', $hotelContent->id) }}"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="grid md:grid-cols-2 gap-6">

            <div>

                <label class="font-semibold">
                    Section Key
                </label>

                <input type="text"
                       name="section_key"
                       value="{{ $hotelContent->section_key }}"
                       class="w-full border rounded-xl px-4 py-3 mt-2">

            </div>

            <div>

                <label class="font-semibold">
                    Title
                </label>

                <input type="text"
                       name="title"
                       value="{{ $hotelContent->title }}"
                       class="w-full border rounded-xl px-4 py-3 mt-2">

            </div>

        </div>

        <div class="mt-6">

            <label class="font-semibold">
                Content
            </label>

            <textarea name="content"
                      rows="8"
                      class="w-full border rounded-xl px-4 py-3 mt-2">{{ $hotelContent->content }}</textarea>

        </div>

        @if($hotelContent->image)

            <div class="mt-6">

                <label class="font-semibold">
                    Current Image
                </label>

                <img src="{{ asset('storage/' . $hotelContent->image) }}"
                     class="w-48 h-32 object-cover rounded-xl mt-3">

            </div>

        @endif

        <div class="mt-6">

            <label class="font-semibold">
                Change Image
            </label>

            <input type="file"
                   name="image"
                   class="w-full border rounded-xl px-4 py-3 mt-2">

        </div>

        <div class="mt-6">

            <label class="flex items-center gap-3">

                <input type="checkbox"
                       name="is_active"
                       {{ $hotelContent->is_active ? 'checked' : '' }}>

                Active Content

            </label>

        </div>

        <div class="mt-8 flex gap-4">

            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700">
                Update Content
            </button>

            <a href="{{ route('admin.hotel-contents.index') }}"
               class="bg-gray-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-600">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection