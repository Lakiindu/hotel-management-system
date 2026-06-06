@extends('layouts.customer')

@section('title', 'My Profile')

@section('page-title', 'My Profile')

@section('page-subtitle', 'Update your personal details and account security.')

@section('content')

@php
    $user = auth()->user();

    $completionClass = match (true) {
        $profileCompletion >= 100 => 'w-full',
        $profileCompletion >= 80 => 'w-4/5',
        $profileCompletion >= 60 => 'w-3/5',
        $profileCompletion >= 40 => 'w-2/5',
        $profileCompletion >= 20 => 'w-1/5',
        default => 'w-0',
    };
@endphp

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

        <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl transition-all duration-300">

            <div class="flex justify-between items-center mb-3">
                <h3 class="font-bold">Profile Completion</h3>

                <span class="font-bold text-amber-500">
                    {{ $profileCompletion }}%
                </span>
            </div>

            <div class="w-full bg-slate-200 rounded-full h-3">
                <div class="bg-amber-400 h-3 rounded-full {{ $completionClass }}"></div>
            </div>

        </div>

        <div class="bg-slate-950 text-white p-8 rounded-[2rem] shadow text-center hover:shadow-xl transition-all duration-300">
            <img src="{{ $user->profile_image ? asset('storage/' . $user->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}"
                 class="w-36 h-36 rounded-full object-cover mx-auto mb-5 border-4 border-amber-400">

            <h2 class="text-3xl font-extrabold">
                {{ $user->name }}
            </h2>

            <p class="text-slate-300">
                {{ $user->email }}
            </p>

            <span class="inline-block mt-5 bg-amber-400 text-slate-950 px-5 py-2 rounded-full font-bold">
                {{ ucfirst($user->role) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-4">

            <div class="bg-white p-5 rounded-3xl shadow text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <p class="text-slate-500 text-sm">Account Status</p>

                <h3 class="font-bold text-green-600 mt-2">
                    Active ✓
                </h3>
            </div>

            <div class="bg-white p-5 rounded-3xl shadow text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                <p class="text-slate-500 text-sm">Member Since</p>

                <h3 class="font-bold mt-2">
                    {{ $user->created_at->format('M Y') }}
                </h3>
            </div>

        </div>

        <div class="bg-white p-6 rounded-3xl shadow hover:shadow-xl transition-all duration-300">
            <p class="text-slate-500">Phone</p>
            <p class="font-bold mb-4">
                {{ $user->phone ?? 'Not added' }}
            </p>

            <p class="text-slate-500">Address</p>
            <p class="font-bold">
                {{ $user->address ?? 'Not added' }}
            </p>
        </div>

        <div class="bg-white p-6 rounded-3xl shadow text-center hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <p class="text-slate-500 mb-2">
                Total Completed Stays
            </p>

            <h2 class="text-4xl font-extrabold text-amber-500">
                {{ $totalStays }}
            </h2>
        </div>

    </div>

    <div class="lg:col-span-2 space-y-8">

        <div class="bg-white p-8 rounded-[2rem] shadow hover:shadow-xl transition-all duration-300">
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
                               value="{{ old('name', $user->name) }}"
                               class="w-full border p-3 rounded-xl mt-2">
                    </div>

                    <div>
                        <label class="font-semibold">Email</label>
                        <input type="email"
                               value="{{ $user->email }}"
                               class="w-full border p-3 rounded-xl mt-2 bg-slate-100"
                               disabled>
                    </div>

                    <div>
                        <label class="font-semibold">Phone</label>
                        <input type="text"
                               name="phone"
                               value="{{ old('phone', $user->phone) }}"
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
                              class="w-full border p-3 rounded-xl mt-2">{{ old('address', $user->address) }}</textarea>
                </div>

                <button class="mt-6 bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold hover:bg-amber-300 transition">
                    Save Changes
                </button>
            </form>
        </div>

        <div class="bg-white p-8 rounded-[2rem] shadow hover:shadow-xl transition-all duration-300">
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

                <button class="mt-6 bg-slate-950 text-white px-6 py-3 rounded-xl font-bold hover:bg-slate-800 transition">
                    Update Password
                </button>
            </form>
        </div>

    </div>

</div>

@endsection