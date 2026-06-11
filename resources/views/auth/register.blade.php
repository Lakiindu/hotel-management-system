<x-guest-layout>
    @section('title', 'Register | RoyalStay')

    <div class="mb-8">
        <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
            Create An Account
        </p>

        <h1 class="text-3xl font-extrabold text-slate-950">
            Join RoyalStay
        </h1>

        <p class="text-slate-500 mt-2">
            Register to book rooms and manage your hotel stays.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label for="name" class="font-semibold text-slate-700">Full Name</label>
            <input id="name"
                   type="text"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
                   autocomplete="name"
                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="font-semibold text-slate-700">Email Address</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autocomplete="username"
                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="phone" class="font-semibold text-slate-700">Phone Number</label>
            <input id="phone"
                   type="text"
                   name="phone"
                   value="{{ old('phone') }}"
                   required
                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="font-semibold text-slate-700">Password</label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="new-password"
                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="font-semibold text-slate-700">Confirm Password</label>
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"
                   required
                   autocomplete="new-password"
                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button class="w-full bg-slate-950 text-white py-3 rounded-2xl font-bold hover:bg-slate-800 transition">
            Register
        </button>

        <p class="text-center text-sm text-slate-500">
            Already registered?
            <a href="{{ route('login') }}" class="text-amber-500 font-bold hover:underline">
                Login here
            </a>
        </p>
    </form>
</x-guest-layout>