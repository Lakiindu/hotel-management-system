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

<body class="bg-slate-100 text-slate-900 overflow-hidden">

<div class="min-h-screen">

    @auth
        <!-- Fixed Sidebar -->
        <aside id="sidebar"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-950 text-white px-6 py-8 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col justify-between">

            <div>
                <div class="flex justify-between items-center mb-14">
                    <h1 class="text-3xl font-extrabold">
                        RoyalStay<span class="text-amber-400">.</span>
                    </h1>

                    <button type="button" id="closeSidebar" class="lg:hidden">
                        <i data-lucide="x"></i>
                    </button>
                </div>

                <nav class="space-y-4">
                    <a href="{{ route('customer.dashboard') }}"
                       class="flex items-center gap-3 px-5 py-3 rounded-2xl
                       {{ request()->routeIs('customer.dashboard') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                        <i data-lucide="layout-dashboard" class="w-5"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('rooms') }}"
                       class="flex items-center gap-3 px-5 py-3 rounded-2xl
                       {{ request()->routeIs('rooms') || request()->routeIs('rooms.details') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
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

        <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

        <!-- Fixed Header -->
        <header class="fixed top-0 left-0 lg:left-72 right-0 z-30 bg-slate-100/95 backdrop-blur px-6 lg:px-10 py-6 border-b border-slate-200">
            <div class="flex justify-between items-center">

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

                    <!-- Notifications -->
                    <div class="relative">
                        <button id="customerNotificationBtn"
                                type="button"
                                class="relative bg-white p-4 rounded-2xl shadow hover:bg-slate-50">
                            <i data-lucide="bell"></i>

                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                                {{ auth()->user()->unreadNotifications()->count() }}
                            </span>
                        </button>

                        <div id="customerNotificationDropdown"
                             class="hidden absolute right-0 mt-3 w-96 bg-white rounded-3xl shadow-xl z-50 overflow-hidden">

                            <div class="p-5 border-b flex justify-between items-center">
                                <h3 class="font-bold text-slate-800">
                                    Notifications
                                </h3>

                                <form method="POST" action="{{ route('notifications.readAll') }}">
                                    @csrf
                                    @method('PATCH')

                                    <button class="text-sm text-blue-600 font-semibold">
                                        Mark all read
                                    </button>
                                </form>
                            </div>

                            <div class="max-h-96 overflow-y-auto">
                                @forelse(auth()->user()->notifications()->latest()->take(8)->get() as $notification)
                                    <div class="p-5 border-b {{ $notification->is_read ? 'bg-white' : 'bg-amber-50' }}">
                                        <h4 class="font-bold text-slate-800">
                                            {{ $notification->title }}
                                        </h4>

                                        <p class="text-sm text-slate-500 mt-1">
                                            {{ $notification->message }}
                                        </p>

                                        <p class="text-xs text-slate-400 mt-2">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>

                                        @if(!$notification->is_read)
                                            <form method="POST"
                                                  action="{{ route('notifications.read', $notification->id) }}"
                                                  class="mt-3">
                                                @csrf
                                                @method('PATCH')

                                                <button class="text-xs bg-slate-950 text-white px-3 py-1 rounded-full">
                                                    Mark as read
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                @empty
                                    <div class="p-6 text-center text-slate-500">
                                        No notifications yet.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div class="flex items-center gap-4 bg-white p-4 rounded-3xl shadow">
                        <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                             class="w-12 h-12 rounded-full object-cover">

                        <div>
                            <p class="font-bold">{{ auth()->user()->name }}</p>
                            <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <main class="lg:ml-72 h-screen overflow-y-auto px-6 lg:px-10 pt-44 pb-10">
            @yield('content')
        </main>
    @endauth

    @guest
        <!-- Public Header For Visitors -->
        <header class="bg-slate-950 text-white px-8 py-5 flex justify-between items-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold">
                RoyalStay<span class="text-amber-400">.</span>
            </a>

            <nav class="flex items-center gap-5">
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('rooms') }}">Rooms</a>
                <a href="{{ route('login') }}">Login</a>
                <a href="{{ route('register') }}"
                   class="bg-amber-400 text-slate-950 px-4 py-2 rounded-full font-bold">
                    Register
                </a>
            </nav>
        </header>

        <main class="h-screen overflow-y-auto">
            @yield('content')
        </main>
    @endguest

</div>

<script>
    lucide.createIcons();

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    const openSidebar = document.getElementById('openSidebar');
    const closeSidebar = document.getElementById('closeSidebar');

    openSidebar?.addEventListener('click', () => {
        sidebar?.classList.remove('-translate-x-full');
        overlay?.classList.remove('hidden');
    });

    closeSidebar?.addEventListener('click', () => {
        sidebar?.classList.add('-translate-x-full');
        overlay?.classList.add('hidden');
    });

    overlay?.addEventListener('click', () => {
        sidebar?.classList.add('-translate-x-full');
        overlay?.classList.add('hidden');
    });

    const customerNotificationBtn = document.getElementById('customerNotificationBtn');
    const customerNotificationDropdown = document.getElementById('customerNotificationDropdown');

    customerNotificationBtn?.addEventListener('click', (event) => {
        event.stopPropagation();
        customerNotificationDropdown?.classList.toggle('hidden');
    });

    document.addEventListener('click', (event) => {
        if (
            customerNotificationDropdown &&
            customerNotificationBtn &&
            !customerNotificationDropdown.contains(event.target) &&
            !customerNotificationBtn.contains(event.target)
        ) {
            customerNotificationDropdown.classList.add('hidden');
        }
    });
</script>

@stack('scripts')

</body>
</html>