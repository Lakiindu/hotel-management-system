<x-guest-layout>
    @section('title', 'Login | RoyalStay')

    <div class="mb-8">
        <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
            Welcome Back
        </p>

        <h1 class="text-3xl font-extrabold text-slate-950">
            Login to RoyalStay
        </h1>

        <p class="text-slate-500 mt-2">
            Access your hotel dashboard and manage your bookings.
        </p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="font-semibold text-slate-700">Email Address</label>
            <input id="email"
                   type="email"
                   name="email"
                   value="{{ old('email') }}"
                   required
                   autofocus
                   autocomplete="username"
                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="font-semibold text-slate-700">Password</label>
            <input id="password"
                   type="password"
                   name="password"
                   required
                   autocomplete="current-password"
                   class="w-full mt-2 border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-amber-400 focus:border-amber-400 outline-none">

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       class="rounded border-slate-300 text-amber-500 focus:ring-amber-400"
                       name="remember">

                <span class="ms-2 text-sm text-slate-600">
                    Remember me
                </span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-slate-500 hover:text-amber-500 font-semibold">
                    Forgot password?
                </a>
            @endif
        </div>

        <button class="w-full bg-slate-950 text-white py-3 rounded-2xl font-bold hover:bg-slate-800 transition">
            Log In
        </button>

        <p class="text-center text-sm text-slate-500">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-amber-500 font-bold hover:underline">
                Register now
            </a>
        </p>
    </form>
</x-guest-layout>