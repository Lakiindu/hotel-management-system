@extends('layouts.admin')

@section('title', 'Services')

@section('page-title', 'Service Management')

@section('page-subtitle', 'Manage hotel services and facilities.')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.services.create') }}"
       class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold">
        + Add Service
    </a>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
    {{ session('success') }}
</div>
@endif

<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

@foreach($services as $service)

<div class="bg-white rounded-3xl shadow hover:shadow-xl transition">

    @if($service->image)
        <img src="{{ asset('storage/'.$service->image) }}"
             class="w-full h-52 object-cover rounded-t-3xl">
    @endif

    <div class="p-6">

        <div class="flex justify-between mb-4">

            <h3 class="text-xl font-extrabold">
                {{ $service->title }}
            </h3>

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

        <p class="text-slate-500 mb-6">
            {{ Str::limit($service->description,100) }}
        </p>

        <div class="flex gap-2">

            <a href="{{ route('admin.services.edit',$service->id) }}"
               class="bg-yellow-400 text-slate-900 px-4 py-2 rounded-xl font-bold">
                Edit
            </a>

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

<div class="mt-6">
    {{ $services->links() }}
</div>

@endsection