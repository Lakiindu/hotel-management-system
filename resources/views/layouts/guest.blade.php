<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'RoyalStay')</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-slate-900 antialiased">

<div class="min-h-screen bg-slate-100 grid lg:grid-cols-2">

    <div class="hidden lg:flex bg-slate-950 text-white p-12 flex-col justify-between">
        <a href="{{ route('home') }}" class="text-4xl font-extrabold">
            RoyalStay<span class="text-amber-400">.</span>
        </a>

        <div>
            <p class="text-amber-400 font-bold uppercase tracking-widest mb-4">
                Hotel Management System
            </p>

            <h1 class="text-5xl font-extrabold leading-tight mb-6">
                Manage bookings, rooms and payments easily.
            </h1>

            <p class="text-slate-300 text-lg max-w-xl">
                Welcome to RoyalStay. Login or create an account to book rooms,
                manage stays, view payments and enjoy a smooth hotel experience.
            </p>
        </div>

        <p class="text-slate-400 text-sm">
            © {{ date('Y') }} RoyalStay Hotel. All rights reserved.
        </p>
    </div>

    <div class="flex items-center justify-center p-6">
        <div class="w-full max-w-md">

            <div class="lg:hidden text-center mb-8">
                <a href="{{ route('home') }}" class="text-4xl font-extrabold">
                    RoyalStay<span class="text-amber-500">.</span>
                </a>
            </div>

            <div class="bg-white rounded-[2rem] shadow-xl p-8">
                {{ $slot }}
            </div>

        </div>
    </div>

</div>

</body>
</html>