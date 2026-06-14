{{-- Uses the guest layout (for users who are not logged in) --}}
<x-guest-layout>

    {{-- Sets the browser page title --}}
    @section('title', 'Register | RoyalStay')

    {{-- Header section of the registration page --}}
    <div class="mb-8">

        {{-- Small gold-colored heading text --}}
        <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
            Create An Account
        </p>

        {{-- Main page title --}}
        <h1 class="text-3xl font-extrabold text-slate-950">
            Join RoyalStay
        </h1>

        {{-- Short description below the title --}}
        <p class="text-slate-500 mt-2">
            Register to book rooms and manage your hotel stays.
        </p>

    </div>

    {{-- Registration form --}}
    <form method="POST"
          action="{{ route('register') }}"
          class="space-y-5">

        {{-- Laravel CSRF protection token --}}
        @csrf

        {{-- ================= NAME FIELD ================= --}}
        <div>

            {{-- Label for Full Name input --}}
            <label for="name"
                   class="font-semibold text-slate-700">
                Full Name
            </label>

            {{-- Name textbox --}}
            <input id="name"
                   type="text"
                   name="name"

                   {{-- Keeps old value if validation fails --}}
                   value="{{ old('name') }}"

                   required
                   autofocus
                   autocomplete="name"

                   {{-- Tailwind styling --}}
                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            {{-- Displays validation error for name --}}
            <x-input-error :messages="$errors->get('name')"
                           class="mt-2" />

        </div>

        {{-- ================= EMAIL FIELD ================= --}}
        <div>

            {{-- Label for Email --}}
            <label for="email"
                   class="font-semibold text-slate-700">
                Email Address
            </label>

            {{-- Email textbox --}}
            <input id="email"
                   type="email"
                   name="email"

                   {{-- Retains entered email after validation error --}}
                   value="{{ old('email') }}"

                   required
                   autocomplete="username"

                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            {{-- Email validation errors --}}
            <x-input-error :messages="$errors->get('email')"
                           class="mt-2" />

        </div>

        {{-- ================= PHONE FIELD ================= --}}
        <div>

            {{-- Phone number label --}}
            <label for="phone"
                   class="font-semibold text-slate-700">
                Phone Number
            </label>

            {{-- Phone input box --}}
            <input id="phone"
                   type="text"
                   name="phone"

                   {{-- Keeps old phone value --}}
                   value="{{ old('phone') }}"

                   required

                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            {{-- Phone validation errors --}}
            <x-input-error :messages="$errors->get('phone')"
                           class="mt-2" />

        </div>

        {{-- ================= PASSWORD FIELD ================= --}}
        <div>

            {{-- Password label --}}
            <label for="password"
                   class="font-semibold text-slate-700">
                Password
            </label>

            {{-- Password textbox --}}
            <input id="password"
                   type="password"
                   name="password"

                   required
                   autocomplete="new-password"

                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            {{-- Password validation errors --}}
            <x-input-error :messages="$errors->get('password')"
                           class="mt-2" />

        </div>

        {{-- ================= CONFIRM PASSWORD FIELD ================= --}}
        <div>

            {{-- Confirm password label --}}
            <label for="password_confirmation"
                   class="font-semibold text-slate-700">
                Confirm Password
            </label>

            {{-- Confirm password textbox --}}
            <input id="password_confirmation"
                   type="password"
                   name="password_confirmation"

                   required
                   autocomplete="new-password"

                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            {{-- Confirmation password validation errors --}}
            <x-input-error :messages="$errors->get('password_confirmation')"
                           class="mt-2" />

        </div>

        {{-- ================= REGISTER BUTTON ================= --}}
        <button class="w-full bg-slate-950 text-white py-3 rounded-2xl font-bold hover:bg-slate-800 transition">

            {{-- Button text --}}
            Register

        </button>

        {{-- ================= LOGIN LINK ================= --}}
        <p class="text-center text-sm text-slate-500">

            {{-- Message for existing users --}}
            Already registered?

            {{-- Link to login page --}}
            <a href="{{ route('login') }}"
               class="text-amber-500 font-bold hover:underline">

                Login here

            </a>

        </p>

    </form>

</x-guest-layout>