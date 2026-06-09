@extends('layouts.admin')

@section('title', 'Gallery Management')

@section('page-title', 'Gallery Management')

@section('page-subtitle', 'Upload and manage hotel gallery images.')

@section('content')

<div class="flex justify-end mb-6">
    <a href="{{ route('admin.galleries.create') }}"
       class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-700">
        + Add Gallery Image
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

    @forelse($galleries as $gallery)

        <div class="bg-white rounded-3xl shadow hover:shadow-xl transition overflow-hidden">

            <img src="{{ asset('storage/' . $gallery->image) }}"
     alt="{{ $gallery->title ?? 'Gallery Image' }}"
     loading="lazy"
     class="w-full h-56 object-cover">

            <div class="p-6">

                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-xl font-extrabold">
                            {{ $gallery->title ?? 'Untitled Image' }}
                        </h3>

                        <p class="text-sm text-slate-500">
                            {{ $gallery->category ?? 'No category' }}
                        </p>
                    </div>

                    @if($gallery->is_active)
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-bold">
                            Active
                        </span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-bold">
                            Inactive
                        </span>
                    @endif
                </div>

                <p class="text-slate-500 mb-6">
                    {{ Str::limit($gallery->description ?? 'No description added.', 100) }}
                </p>

                <div class="flex gap-2">
                    <a href="{{ route('admin.galleries.edit', $gallery->id) }}"
                       class="bg-yellow-400 text-slate-950 px-4 py-2 rounded-xl font-bold">
                        Edit
                    </a>

                    <form method="POST"
                          action="{{ route('admin.galleries.destroy', $gallery->id) }}"
                          class="delete-form">
                        @csrf
                        @method('DELETE')

                        <button type="button"
                                class="delete-btn bg-red-500 text-white px-4 py-2 rounded-xl font-bold">
                            Delete
                        </button>
                    </form>
                </div>

            </div>

        </div>

    @empty

        <div class="xl:col-span-3 bg-white p-10 rounded-3xl shadow text-center">
            <h3 class="text-2xl font-bold mb-2">No gallery images yet</h3>
            <p class="text-slate-500 mb-6">Start by uploading hotel photos.</p>

            <a href="{{ route('admin.galleries.create') }}"
               class="bg-blue-600 text-white px-6 py-3 rounded-xl font-bold">
                Add First Image
            </a>
        </div>

    @endforelse

</div>

<div class="mt-6">
    {{ $galleries->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function () {
        Swal.fire({
            title: 'Delete this gallery image?',
            text: 'This image will be removed permanently.',
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