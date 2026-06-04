<!DOCTYPE html>
<html>
<head>
    <title>Customer Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-slate-100">

<div class="flex min-h-screen">

    <aside class="w-64 bg-slate-950 text-white p-6">
        <h1 class="text-2xl font-bold mb-8">Hotel Admin</h1>

        
        <nav class="space-y-3">

    <a href="{{ route('admin.dashboard') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Dashboard</a>

    <a href="{{ route('admin.rooms.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Rooms</a>

    <a href="{{ route('admin.bookings.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Bookings</a>

    <a href="{{ route('admin.customers.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Customers</a>

    <a href="{{ route('admin.payments.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Payments</a>

    <a href="{{ route('admin.reviews.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Reviews</a>

    <a href="{{ route('admin.reports.index') }}" class="block hover:bg-slate-800 px-4 py-2 rounded-lg">Reports</a>
    
    </nav>
    </aside>

    <main class="flex-1 p-8">

        <h1 class="text-3xl font-bold mb-8">
            Customer Management
        </h1>

        <div class="grid md:grid-cols-3 gap-6 mb-8">

            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-slate-500">Total Customers</h3>
                <p class="text-4xl font-bold">{{ $totalCustomers }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-green-500">Active Customers</h3>
                <p class="text-4xl font-bold">{{ $activeCustomers }}</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-red-500">Inactive Customers</h3>
                <p class="text-4xl font-bold">{{ $inactiveCustomers }}</p>
            </div>

        </div>

        <form method="GET"
              class="bg-white p-5 rounded-2xl shadow mb-6 flex gap-4">

            <input type="text"
                   name="search"
                   value="{{ $search }}"
                   placeholder="Search customer..."
                   class="border rounded-xl px-4 py-3 flex-1">

            <select name="status"
                    class="border rounded-xl px-4 py-3">

                <option value="">All</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>

            </select>

            <button class="bg-slate-950 text-white px-6 rounded-xl">
                Search
            </button>

        </form>

        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <table class="w-full">

                <thead class="bg-slate-950 text-white">

                <tr>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Phone</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>

                </thead>

                <tbody>

                @foreach($customers as $customer)

                    <tr class="border-b">

                        <td class="p-4">
                            <p class="font-bold">{{ $customer->name }}</p>
                            <p class="text-sm text-slate-500">
                                {{ $customer->email }}
                            </p>
                        </td>

                        <td class="p-4">
                            {{ $customer->phone ?? '-' }}
                        </td>

                        <td class="p-4">

                            @if($customer->is_active)

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Active
                                </span>

                            @else

                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm">
                                    Inactive
                                </span>

                            @endif

                        </td>

                        <td class="p-4 flex gap-2">

                            <a href="{{ route('admin.customers.show', $customer->id) }}"
                               class="bg-blue-600 text-white px-4 py-2 rounded-lg">
                                View
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.customers.toggleStatus', $customer->id) }}">
                                @csrf
                                @method('PATCH')

                                <button class="bg-amber-500 text-white px-4 py-2 rounded-lg">
                                    {{ $customer->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </main>

</div>

</body>
</html>