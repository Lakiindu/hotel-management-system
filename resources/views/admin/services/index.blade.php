@extends('layouts.admin')

{{-- Browser Page Title --}}
@section('title', 'Services')

{{-- Header Title --}}
@section('page-title', 'Service Management')

{{-- Header Subtitle --}}
@section('page-subtitle', 'Manage hotel services and facilities.')

@section('content')

{{-- Add New Service Button --}}
<div class="flex justify-end mb-6">
    <a href="{{ route('admin.services.create') }}"
       class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold">
        + Add Service
    </a>
</div>

{{-- Success Message After Create/Update/Delete --}}
@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
    {{ session('success') }}
</div>
@endif

{{-- Services Grid Layout --}}
<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

{{-- Loop Through All Services --}}
@foreach($services as $service)

<div class="bg-white rounded-3xl shadow hover:shadow-xl transition">

    {{-- Service Image --}}
    @if($service->image)
        <img src="{{ asset('storage/'.$service->image) }}"
             class="w-full h-52 object-cover rounded-t-3xl">
    @endif

    <div class="p-6">

    {{-- Service Title & Status --}}
        <div class="flex justify-between mb-4">

            <h3 class="text-xl font-extrabold">
                {{ $service->title }}
            </h3>

            {{-- Active / Inactive Badge --}}
            @if($service->is_active)
                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                    Active
                </span>
            @else
                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                    Inactive
                </span>
            @endif

        </div>

        {{-- Short Service Description --}}
        <p class="text-slate-500 mb-6">
            {{ Str::limit($service->description,100) }}
        </p>
        {{-- Action Buttons --}}
        <div class="flex gap-2">

            {{-- Edit Service --}}
            <a href="{{ route('admin.services.edit',$service->id) }}"
               class="bg-yellow-400 text-slate-900 px-4 py-2 rounded-xl font-bold">
                Edit
            </a>

            {{-- Delete Service --}}
            <form action="{{ route('admin.services.destroy',$service->id) }}"
                  method="POST">

                @csrf
                @method('DELETE')

                <button class="bg-red-500 text-white px-4 py-2 rounded-xl font-bold">
                    Delete
                </button>

            </form>

        </div>

    </div>

</div>

@endforeach

</div>

{{-- Pagination Links --}}
<div class="mt-6">
    {{ $services->links() }}
</div>

@endsection
