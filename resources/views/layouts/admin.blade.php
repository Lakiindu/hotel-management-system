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

<body class="bg-slate-100 text-slate-900 overflow-hidden">

<div class="min-h-screen">

// Admin sidebar and header layout
    <aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-950 text-white px-6 py-8 transform -translate-x-full lg:translate-x-0 
    transition-transform duration-300 flex flex-col">
        <div>
            <!-- System Logo -->
             <div class="flex justify-between items-center mb-14">
                <h1 class="text-3xl font-extrabold">
                    Hotel<span class="text-amber-400">Admin.</span>
                </h1>

                <button type="button" id="closeSidebar" class="lg:hidden">
                    <i data-lucide="x"></i>
                </button>
            </div>

            <!-- Main Navigation Menu -->
             <nav class="space-y-2">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                   class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
                   {{ request()->routeIs('admin.dashboard') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="layout-dashboard" class="w-5"></i> Dashboard
                </a>

                <!-- Room Management -->
                <a href="{{ route('admin.rooms.index') }}"
                   class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
                   {{ request()->routeIs('admin.rooms.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="bed-double" class="w-5"></i> Rooms
                </a>

                 <!-- Booking Management -->
                <a href="{{ route('admin.bookings.index') }}"
                   class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
                   {{ request()->routeIs('admin.bookings.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="calendar-check" class="w-5"></i> Bookings
                </a>

                <!-- Customer Management -->
                <a href="{{ route('admin.customers.index') }}"
                   class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
                   {{ request()->routeIs('admin.customers.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="users" class="w-5"></i> Customers
                </a>

                <!-- Payment Management -->
                <a href="{{ route('admin.payments.index') }}"
                   class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
                   {{ request()->routeIs('admin.payments.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="credit-card" class="w-5"></i> Payments
                </a>

                <!-- Reviews Management -->
                <a href="{{ route('admin.reviews.index') }}"
                class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
                {{ request()->routeIs('admin.reviews.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="star" class="w-5"></i> Reviews
                </a>

                <!-- Contact Messages -->
                <a href="{{ route('admin.contacts.index') }}"
                class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
                {{ request()->routeIs('admin.contacts.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="mail" class="w-5"></i> Contact Messages
                </a>

                <!-- Reports -->
                <a href="{{ route('admin.reports.index') }}"
                class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
                {{ request()->routeIs('admin.reports.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                    <i data-lucide="bar-chart-3" class="w-5"></i> Reports
                </a>

        <!-- Website Management -->

            <div class="mt-8 mb-8">
                <p class="px-2 text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">
                Website Management
            </p>

            <!-- Home Page Content -->
            <a href="{{ route('admin.hotel-contents.index') }}"
            class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
            {{ request()->routeIs('admin.hotel-contents.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                <i data-lucide="file-text" class="w-5"></i>
                Home Content
            </a>

            <!-- Services Management -->
            <a href="{{ route('admin.services.index') }}"
            class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
            {{ request()->routeIs('admin.services.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                <i data-lucide="concierge-bell" class="w-5"></i>
                Services
            </a>

            <!-- Gallery Management -->
            <a href="{{ route('admin.galleries.index') }}"
            class="flex items-center gap-4 px-5 py-3 rounded-2xl transition
            {{ request()->routeIs('admin.galleries.*') ? 'bg-amber-400 text-slate-950 font-bold' : 'hover:bg-slate-800' }}">
                <i data-lucide="images" class="w-5"></i>
                Gallery
            </a>

        </div>
            </nav>
        </div>

        <!-- Logout Button -->
        <form method="POST"
      action="{{ route('logout') }}"
      class="mt-auto pt-6 pb-4">            
      @csrf
            <button class="w-full flex items-center justify-center gap-2 bg-red-500 text-white px-5 py-3 rounded-2xl font-bold hover:bg-red-600 transition">
                <i data-lucide="log-out" class="w-5"></i>
                Logout
            </button>
        </form>
    </aside>

    <!-- Mobile Sidebar Background Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden"></div>

    <header class="fixed top-0 left-0 lg:left-72 right-0 z-40 bg-slate-100/95 backdrop-blur border-b border-slate-200">
        <div class="px-6 lg:px-10 py-6 flex justify-between items-center">

            <div class="flex items-center gap-4">
                <button id="openSidebar" type="button"
                        class="lg:hidden bg-white p-3 rounded-2xl shadow">
                    <i data-lucide="menu"></i>
                </button>

                <!-- Page Title & Subtitle -->
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

             <!-- ============ NOTIFICATION SYSTEM ============ -->
            <div class="hidden md:flex items-center gap-4">

                <div class="relative">
                    <!-- Notification Bell -->
                    <button id="notificationBtn"
                            type="button"
                            class="relative bg-white p-4 rounded-2xl shadow hover:bg-slate-50">
                        <i data-lucide="bell"></i>

                        <!-- Unread Notification Count -->
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">
                            {{ auth()->user()->unreadNotifications()->count() }}
                        </span>
                    </button>

                    <!-- Notification Dropdown -->
                    <div id="notificationDropdown"
                         class="hidden absolute right-0 mt-3 w-96 bg-white rounded-3xl shadow-xl z-50 overflow-hidden">

                        <div class="p-5 border-b flex justify-between items-center">
                            <h3 class="font-bold text-slate-800">Notifications</h3>

                            <form method="POST" action="{{ route('notifications.readAll') }}">
                                @csrf
                                @method('PATCH')

                                <button class="text-sm text-blue-600 font-semibold">
                                    Mark all read
                                </button>
                            </form>
                        </div>

                        <!-- Display Recent Notifications -->
                        <div class="max-h-96 overflow-y-auto">
                            @forelse(auth()->user()->notifications()->latest()->take(8)->get() as $notification)
                                <a href="{{ $notification->url ?? '#' }}"
                                 class="block p-5 border-b {{ $notification->is_read ? 'bg-white' : 'bg-amber-50' }}">
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
                                </a>
                            @empty
                                <!-- No Notifications Available -->
                                <div class="p-6 text-center text-slate-500">
                                    No notifications yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            <!-- =========== ADMIN PROFILE SECTION ================ -->
                <div class="flex items-center gap-4 bg-white p-4 rounded-3xl shadow">
                    <div class="w-12 h-12 rounded-full bg-amber-400 text-slate-950 flex items-center justify-center font-extrabold">

                     <!-- Profile Initial -->
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div>
                        <!-- Admin Name -->
                        <p class="font-bold">{{ auth()->user()->name }}</p>
                         <!-- Admin Email -->
                        <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>
            </div>

        </div>
    </header>

    <!-- ============== MAIN PAGE CONTENT ============== -->

    <!-- Child Page Content Appears Here -->
    <main class="lg:ml-72 h-screen overflow-y-auto pt-44 px-6 lg:px-10 pb-10">
        @yield('content')
    </main>

</div>

<!-- ==================  SIDEBAR & NOTIFICATION JAVASCRIPT  ================ -->
<script>
    // Initialize Lucide Icons
    lucide.createIcons();

    // // Mobile Sidebar Open / Close Logic
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

    // Close sidebar when clicking outside on the overlay
    overlay?.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    });

    // Notification Dropdown Logic
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');

    // Toggle notification dropdown on bell click
    notificationBtn?.addEventListener('click', (event) => {
        event.stopPropagation();
        notificationDropdown.classList.toggle('hidden');
    });

    // Close notification dropdown when clicking outside
    document.addEventListener('click', (event) => {
        if (
            notificationDropdown &&
            !notificationDropdown.contains(event.target) &&
            !notificationBtn.contains(event.target)
        ) {
            notificationDropdown.classList.add('hidden');
        }
    });
</script>

@stack('scripts')

</body>
</html>