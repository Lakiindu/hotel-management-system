@extends('layouts.admin')

@section('title', 'Edit Service')

@section('content')

<div class="bg-white p-8 rounded-3xl shadow">

```
<h2 class="text-2xl font-bold mb-6">
    Edit Service
</h2>

<form method="POST"
      action="{{ route('admin.services.update', $service->id) }}"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="grid md:grid-cols-2 gap-6">

        <div>
            <label class="block mb-2 font-semibold">
                Title
            </label>

            <input type="text"
                   name="title"
                   value="{{ $service->title }}"
                   class="w-full border p-3 rounded-xl">
        </div>

        <div>
            <label class="block mb-2 font-semibold">
                Icon
            </label>

            <input type="text"
                   name="icon"
                   value="{{ $service->icon }}"
                   placeholder="fa-solid fa-dumbbell"
                   class="w-full border p-3 rounded-xl">
        </div>

    </div>

    <div class="mt-5">
        <label class="block mb-2 font-semibold">
            Description
        </label>

        <textarea name="description"
                  rows="5"
                  class="w-full border p-3 rounded-xl">{{ $service->description }}</textarea>
    </div>

    @if($service->image)
        <div class="mt-5">
            <label class="block mb-2 font-semibold">
                Current Image
            </label>

            <img src="{{ asset('storage/' . $service->image) }}"
                 alt="{{ $service->title }}"
                 class="w-48 h-32 object-cover rounded-xl border">
        </div>
    @endif

    <div class="mt-5">
        <label class="block mb-2 font-semibold">
            Change Image
        </label>

        <input type="file"
               name="image"
               class="w-full border p-3 rounded-xl">
    </div>

    <div class="mt-5">
        <label class="flex items-center gap-3">
            <input type="checkbox"
                   name="is_active"
                   value="1"
                   {{ $service->is_active ? 'checked' : '' }}>

            Active Service
        </label>
    </div>

    <div class="mt-8 flex gap-4">
        <button type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-blue-700 transition">
            Update Service
        </button>

        <a href="{{ route('admin.services.index') }}"
           class="bg-slate-500 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-600 transition">
            Cancel
        </a>
    </div>

</form>
```

</div>

@endsection
