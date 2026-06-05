<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Customer Panel')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    @stack('styles')
</head>

<body class="bg-slate-100 text-slate-900">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside id="sidebar"
           class="fixed lg:static inset-y-0 left-0 z-50 w-72 bg-slate-950 text-white p-6 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col justify-between">

        <div>
            <div class="flex justify-between items-center mb-10">
                <h1 class="text-3xl font-extrabold">
                    RoyalStay<span class="text-amber-400">.</span>
                </h1>

                <button type="button" id="closeSidebar" class="lg:hidden">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <nav class="space-y-3">
                <a href="{{ route('customer.dashboard') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl
                   {{ request()->routeIs('customer.dashboard') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="layout-dashboard" class="w-5"></i>
                    Dashboard
                </a>

                <a href="{{ route('rooms') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl
                   {{ request()->routeIs('rooms') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="bed-double" class="w-5"></i>
                    Browse Rooms
                </a>

                <a href="{{ route('customer.bookings.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl
                   {{ request()->routeIs('customer.bookings.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="calendar-check" class="w-5"></i>
                    My Bookings
                </a>

                <a href="{{ route('customer.payments.index') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl
                   {{ request()->routeIs('customer.payments.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="credit-card" class="w-5"></i>
                    Payments
                </a>

                <a href="{{ route('customer.profile.edit') }}"
                   class="flex items-center gap-3 px-5 py-3 rounded-2xl
                   {{ request()->routeIs('customer.profile.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="user-round" class="w-5"></i>
                    Profile
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

    <!-- Overlay for mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

    <!-- Main -->
    <main class="flex-1 p-6 lg:p-10">

        <!-- Topbar -->
        <div class="flex justify-between items-center mb-8">

            <div class="flex items-center gap-4">
                <button id="openSidebar" type="button"
                        class="lg:hidden bg-white p-3 rounded-2xl shadow">
                    <i data-lucide="menu"></i>
                </button>

                <div>
                    <p class="text-amber-500 font-bold uppercase tracking-widest mb-2">
                        Customer Portal
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

                <!-- Notification placeholder -->
                <button class="relative bg-white p-4 rounded-2xl shadow hover:bg-slate-50">
                    <i data-lucide="bell"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                        0
                    </span>
                </button>

                <!-- Profile -->
                <div class="flex items-center gap-4 bg-white p-4 rounded-3xl shadow">
                    <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                         class="w-12 h-12 rounded-full object-cover border-2 border-amber-400">

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

    if (openSidebar) {
        openSidebar.addEventListener('click', () => {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
        });
    }

    if (closeSidebar) {
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    }

    if (overlay) {
        overlay.addEventListener('click', () => {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('hidden');
        });
    }
</script>

@stack('scripts')

</body>
</html>