<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

<div class="max-w-6xl mx-auto py-10 px-6">

    <div class="mb-8">
        <h1 class="text-4xl font-bold text-slate-800">My Profile</h1>
        <p class="text-slate-500">Manage your account information</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded-xl mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded-xl mb-6">
            <ul class="list-disc ml-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid md:grid-cols-3 gap-8">

        <div class="bg-white p-8 rounded-3xl shadow text-center">
            <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                 class="w-36 h-36 rounded-full object-cover mx-auto mb-4 border-4 border-amber-400">

            <h2 class="text-2xl font-bold">{{ auth()->user()->name }}</h2>
            <p class="text-slate-500">{{ auth()->user()->email }}</p>

            <span class="inline-block mt-4 bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>

        <div class="md:col-span-2 space-y-8">

            <div class="bg-white p-8 rounded-3xl shadow">
                <h2 class="text-2xl font-bold mb-6">Update Profile</h2>

                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="font-semibold">Full Name</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                           class="w-full border p-3 rounded-xl mb-4">

                    <label class="font-semibold">Email</label>
                    <input type="email" value="{{ auth()->user()->email }}"
                           class="w-full border p-3 rounded-xl mb-4 bg-slate-100" disabled>

                    <label class="font-semibold">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                           class="w-full border p-3 rounded-xl mb-4">

                    <label class="font-semibold">Address</label>
                    <textarea name="address" rows="3"
                              class="w-full border p-3 rounded-xl mb-4">{{ old('address', auth()->user()->address) }}</textarea>

                    <label class="font-semibold">Profile Image</label>
                    <input type="file" name="profile_image"
                           class="w-full border p-3 rounded-xl mb-5">

                    <button class="bg-amber-400 text-slate-950 px-6 py-3 rounded-xl font-bold">
                        Save Changes
                    </button>
                </form>
            </div>

            <div class="bg-white p-8 rounded-3xl shadow">
                <h2 class="text-2xl font-bold mb-6">Change Password</h2>

                <form method="POST" action="{{ route('customer.profile.password') }}">
                    @csrf
                    @method('PUT')

                    <label class="font-semibold">Current Password</label>
                    <input type="password" name="current_password"
                           class="w-full border p-3 rounded-xl mb-4">

                    <label class="font-semibold">New Password</label>
                    <input type="password" name="password"
                           class="w-full border p-3 rounded-xl mb-4">

                    <label class="font-semibold">Confirm New Password</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border p-3 rounded-xl mb-5">

                    <button class="bg-slate-950 text-white px-6 py-3 rounded-xl font-bold">
                        Update Password
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

</body>
</html>