<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')
</head>

<body class="bg-slate-100 text-slate-900">

<div class="flex min-h-screen">

    <aside id="sidebar"
           class="fixed lg:static inset-y-0 left-0 z-50 w-72 bg-slate-950 text-white px-6 py-8 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col justify-between">

        <div>
            <div class="flex justify-between items-center mb-16">
                <h1 class="text-3xl font-extrabold">
                    Hotel<span class="text-amber-400">Admin.</span>
                </h1>

                <button type="button" id="closeSidebar" class="lg:hidden">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <nav class="space-y-5">
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl {{ request()->routeIs('admin.dashboard') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="layout-dashboard" class="w-5"></i> Dashboard
                </a>

                <a href="{{ route('admin.rooms.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl {{ request()->routeIs('admin.rooms.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="bed-double" class="w-5"></i> Rooms
                </a>

                <a href="{{ route('admin.bookings.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl {{ request()->routeIs('admin.bookings.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="calendar-check" class="w-5"></i> Bookings
                </a>

                <a href="{{ route('admin.customers.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl {{ request()->routeIs('admin.customers.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="users" class="w-5"></i> Customers
                </a>

                <a href="{{ route('admin.payments.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl {{ request()->routeIs('admin.payments.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="credit-card" class="w-5"></i> Payments
                </a>

                <a href="{{ route('admin.reviews.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl {{ request()->routeIs('admin.reviews.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="star" class="w-5"></i> Reviews
                </a>

                <a href="{{ route('admin.reports.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl {{ request()->routeIs('admin.reports.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="bar-chart-3" class="w-5"></i> Reports
                </a>
            </nav>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="w-full flex items-center justify-center gap-2 bg-red-500 text-white px-5 py-3 rounded-2xl font-bold hover:bg-red-600">
                <i data-lucide="log-out" class="w-5"></i>
                Logout
            </button>
        </form>
    </aside>

    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

    <main class="flex-1 p-6 lg:p-10">

        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-4">
                <button id="openSidebar" type="button"
                        class="lg:hidden bg-white p-3 rounded-2xl shadow">
                    <i data-lucide="menu"></i>
                </button>

                <div>
                    <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
                        Admin Panel
                    </p>

                    <h1 class="text-3xl lg:text-4xl font-extrabold">
                        @yield('page-title')
                    </h1>

                    <p class="text-slate-500 mt-2">
                        @yield('page-subtitle')
                    </p>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-4">
                <button class="relative bg-white p-4 rounded-2xl shadow hover:bg-slate-50">
                    <i data-lucide="bell"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        0
                    </span>
                </button>

                <div class="flex items-center gap-4 bg-white p-4 rounded-3xl shadow">
                    <div class="w-12 h-12 rounded-full bg-amber-400 text-slate-950 flex items-center justify-center font-extrabold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <p class="font-bold">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')

    </main>

</div>

<script>
    lucide.createIcons();

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const openSidebar = document.getElementById('openSidebar');
    const closeSidebar = document.getElementById('closeSidebar');

    openSidebar?.addEventListener('click', () => {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    });

    closeSidebar?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });
</script>

@stack('scripts')

</body>
</html>