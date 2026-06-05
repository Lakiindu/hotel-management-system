@extends('layouts.customer')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

@section('page-subtitle', 'Update your personal details and account security.')

@section('content')

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 text-red-700 p-4 rounded-2xl mb-6">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="grid lg:grid-cols-3 gap-8">

    <div class="space-y-6">

        <div class="bg-slate-950 text-white p-8 rounded-[2rem] shadow text-center">
            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                 class="w-36 h-36 rounded-full object-cover mx-auto mb-5 border-4 border-amber-400">

            <h2 class="text-3xl font-extrabold">
                {{ auth()->user()->name }}
            </h2>

            <p class="text-slate-300">
                {{ auth()->user()->email }}
            </p>

            <span class="inline-block mt-5 bg-amber-400 text-slate-950 px-5 py-2 rounded-full font-bold">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow">
            <p class="text-slate-500">Phone</p>
            <p class="font-bold mb-4">
                {{ auth()->user()->phone ?? 'Not added' }}
            </p>

            <p class="text-slate-500">Address</p>
            <p class="font-bold">
                {{ auth()->user()->address ?? 'Not added' }}
            </p>
        </div>

    </div>

    <div class="lg:col-span-2 space-y-8">

        <div class="bg-white p-8 rounded-[2rem] shadow">
            <h2 class="text-2xl font-extrabold mb-6">
                Update Profile
            </h2>

            <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-5">

                    <div>
                        <label class="font-semibold">Full Name</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', auth()->user()->name) }}"
                               class="w-full border p-3 rounded-xl mt-2">
                    </div>

                    <div>
                        <label class="font-semibold">Email</label>
                        <input type="email"
                               value="{{ auth()->user()->email }}"
                               class="w-full border p-3 rounded-xl mt-2 bg-slate-100"
                               disabled>
                    </div>

                    <div>
                        <label class="font-semibold">Phone</label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone', auth()->user()->phone) }}"
                               class="w-full border p-3 rounded-xl mt-2">
                    </div>

                    <div>
                        <label class="font-semibold">Profile Image</label>
                        <input type="file"
                               name="profile_image"
                               class="w-full border p-3 rounded-xl mt-2">
                    </div>

                </div>

                <div class="mt-5">
                    <label class="font-semibold">Address</label>
                    <textarea name="address"
                              rows="3"
                              class="w-full border p-3 rounded-xl mt-2">{{ old('address', auth()->user()->address) }}</textarea>
                </div>

                <button class="mt-6 bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold">
                    Save Changes
                </button>
            </form>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow">
            <h2 class="text-2xl font-extrabold mb-6">
                Security Settings
            </h2>

            <form method="POST" action="{{ route('customer.profile.password') }}">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-3 gap-5">

                    <div>
                        <label class="font-semibold">Current Password</label>
                        <input type="password"
                               name="current_password"
                               class="w-full border p-3 rounded-xl mt-2">
                    </div>

                    <div>
                        <label class="font-semibold">New Password</label>
                        <input type="password"
                               name="password"
                               class="w-full border p-3 rounded-xl mt-2">
                    </div>

                    <div>
                        <label class="font-semibold">Confirm Password</label>
                        <input type="password"
                               name="password_confirmation"
                               class="w-full border p-3 rounded-xl mt-2">
                    </div>

                </div>

                <button class="mt-6 bg-slate-950 text-white px-6 py-3 rounded-xl font-bold">
                    Update Password
                </button>
            </form>
        </div>

    </div>

</div>

@endsection