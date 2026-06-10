@extends('layouts.admin')

@section('title', 'Home Content Management')

@section('page-title', 'Home Content Management')

@section('page-subtitle', 'Manage homepage hero, about, mission, vision, contact and footer content.')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.hotel-contents.create') }}"
       class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-700">
        + Add Content
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[1000px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-5 text-left">Section</th>
                    <th class="p-5 text-left">Title</th>
                    <th class="p-5 text-left">Content</th>
                    <th class="p-5 text-left">Image</th>
                    <th class="p-5 text-left">Status</th>
                    <th class="p-5 text-left">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($contents as $content)
                    <tr class="border-b hover:bg-slate-50 transition">

                        <td class="p-5">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">
                                {{ $content->section_key }}
                            </span>
                        </td>

                        <td class="p-5 font-bold">
                            {{ $content->title ?? '-' }}
                        </td>

                        <td class="p-5 text-slate-600">
                            {{ Str::limit($content->content ?? '-', 120) }}
                        </td>

                        <td class="p-5">
                            @if($content->image)
                                <img src="{{ asset('storage/' . $content->image) }}"
                                     class="w-24 h-16 object-cover rounded-xl">
                            @else
                                <span class="text-slate-400">No image</span>
                            @endif
                        </td>

                        <td class="p-5">
                            @if($content->is_active)
                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold">
                                    Active
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td class="p-5">
                            <div class="flex gap-2">
                                <a href="{{ route('admin.hotel-contents.edit', $content->id) }}"
                                   class="bg-yellow-400 text-slate-950 px-4 py-2 rounded-xl font-bold">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.hotel-contents.destroy', $content->id) }}"
                                      class="delete-form">
                                    @csrf
                                    @method('DELETE')

                                    <button type="button"
                                            class="delete-btn bg-red-500 text-white px-4 py-2 rounded-xl font-bold">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-10 text-center text-slate-500">
                            No home content found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $contents->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        Swal.fire({
            title: 'Delete this content?',
            text: 'This content section will be removed permanently.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                this.closest('form').submit();
            }
        });
    });
});
</script>
@endpush