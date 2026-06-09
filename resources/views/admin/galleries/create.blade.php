@extends('layouts.admin')

@section('title', 'Add Gallery Image')

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

<div class="bg-white p-8 rounded-3xl shadow">

    <h2 class="text-2xl font-bold mb-6">
        Add Gallery Image
    </h2>

    <form method="POST"
          action="{{ route('admin.galleries.store') }}"
          enctype="multipart/form-data">

        @csrf

        <div class="grid md:grid-cols-2 gap-6">

            <div>
                <label class="font-semibold">
                    Title
                </label>

                <input type="text"
                       name="title"
                       value="{{ old('title') }}"
                       class="w-full border p-3 rounded-xl mt-2">
            </div>

            <div>
                <label class="font-semibold">
                    Category
                </label>

                <input type="text"
                       name="category"
                       value="{{ old('category') }}"
                       placeholder="Luxury Room, Pool, Restaurant..."
                       class="w-full border p-3 rounded-xl mt-2">
            </div>

        </div>

        <div class="mt-5">

            <label class="font-semibold">
                Description
            </label>

            <textarea name="description"
                      rows="5"
                      class="w-full border p-3 rounded-xl mt-2">{{ old('description') }}</textarea>

        </div>

        <div class="mt-5">

            <label class="font-semibold">
                Image
            </label>

            <input type="file"
                   name="image"
                   required
                   class="w-full border p-3 rounded-xl mt-2">

        </div>

        <div class="mt-5">

            <label class="flex items-center gap-3">

                <input type="checkbox"
                       name="is_active"
                       value="1"
                       checked>

                Active Gallery Image

            </label>

        </div>

        <div class="mt-6 flex gap-4">

            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700">
                Save Image
            </button>

            <a href="{{ route('admin.galleries.index') }}"
               class="bg-gray-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-gray-600">
                Cancel
            </a>

        </div>

    </form>

</div>

@endsection