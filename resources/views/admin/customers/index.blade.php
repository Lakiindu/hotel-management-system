@extends('layouts.admin')

@section('title', 'Customer Management')

@section('page-title', 'Customer Management')

@section('page-subtitle', 'Search, view and manage registered hotel customers.')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-blue-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-500">Total Customers</p>
                <h2 class="text-4xl font-extrabold text-blue-600">
                    {{ $totalCustomers }}
                </h2>
            </div>

            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center">
                <i data-lucide="users"></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-green-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-500">Active Customers</p>
                <h2 class="text-4xl font-extrabold text-green-600">
                    {{ $activeCustomers }}
                </h2>
            </div>

            <div class="w-12 h-12 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center">
                <i data-lucide="user-check"></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow border-l-4 border-red-500 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-slate-500">Inactive Customers</p>
                <h2 class="text-4xl font-extrabold text-red-600">
                    {{ $inactiveCustomers }}
                </h2>
            </div>

            <div class="w-12 h-12 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center">
                <i data-lucide="user-x"></i>
            </div>
        </div>
    </div>

</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-4 rounded-2xl mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white p-5 rounded-3xl shadow mb-6 grid md:grid-cols-3 gap-4">

    <input type="text"
           id="customerSearch"
           value="{{ $search }}"
           placeholder="Search name, email or phone..."
           class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">

    <select id="customerStatus"
            class="border border-slate-200 rounded-2xl px-4 py-3 focus:ring-2 focus:ring-blue-500 outline-none">
        <option value="">All Status</option>
        <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ $status === '0' ? 'selected' : '' }}>Inactive</option>
    </select>

    <button type="button"
            id="customerReset"
            class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-800 transition">
        Reset
    </button>

</div>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[950px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-5 text-left">Customer</th>
                    <th class="p-5 text-left">Phone</th>
                    <th class="p-5 text-left">Account</th>
                    <th class="p-5 text-left">Status</th>
                    <th class="p-5 text-left">Actions</th>
                </tr>
            </thead>

            <tbody id="customersTableBody">
                @forelse($customers as $customer)

                    <tr class="border-b hover:bg-slate-50 transition">

                        <td class="p-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-extrabold">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>

                                <div>
                                    <p class="font-extrabold text-slate-900">
                                        {{ $customer->name }}
                                    </p>

                                    <p class="text-sm text-slate-500">
                                        {{ $customer->email }}
                                    </p>

                                    <p class="text-xs text-slate-400">
                                        Customer ID #{{ $customer->id }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="p-5">
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                {{ $customer->phone ?? 'Not added' }}
                            </span>
                        </td>

                        <td class="p-5">
                            <p class="font-semibold text-slate-800">
                                {{ ucfirst($customer->role) }}
                            </p>

                            <p class="text-sm text-slate-500">
                                Joined {{ $customer->created_at ? $customer->created_at->format('Y-m-d') : '-' }}
                            </p>
                        </td>

                        <td class="p-5">
                            @if($customer->is_active)
                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold">
                                    Active
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td class="p-5">
                            <div class="flex gap-2">

                                <a href="{{ route('admin.customers.show', $customer->id) }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-blue-700 transition">
                                    View
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.customers.toggleStatus', $customer->id) }}"
                                      class="toggle-form">
                                    @csrf
                                    @method('PATCH')

                                    <button type="button"
                                            class="toggle-btn px-4 py-2 rounded-xl font-bold transition
                                            {{ $customer->is_active ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-green-600 text-white hover:bg-green-700' }}">
                                        {{ $customer->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="p-10 text-center text-slate-500">
                            No customers found.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6" id="customersPagination">
    {{ $customers->links() }}
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const customerSearch = document.getElementById('customerSearch');
const customerStatus = document.getElementById('customerStatus');
const customerReset = document.getElementById('customerReset');
const customersTableBody = document.getElementById('customersTableBody');
const customersPagination = document.getElementById('customersPagination');

function avatarLetter(name) {
    return name ? name.charAt(0).toUpperCase() : 'C';
}

function activeBadge(isActive) {
    return isActive
        ? `<span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-sm font-bold">Active</span>`
        : `<span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-sm font-bold">Inactive</span>`;
}

function actionButton(isActive) {
    return isActive
        ? `bg-red-500 text-white hover:bg-red-600`
        : `bg-green-600 text-white hover:bg-green-700`;
}

function attachToggleEvents() {
    document.querySelectorAll('.toggle-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Update customer status?',
                text: 'This will change the customer account access.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, update',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: new FormData(form)
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Success', data.message, 'success')
                                .then(() => loadAdminCustomers());
                        } else {
                            Swal.fire('Error', 'Could not update customer status.', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Something went wrong.', 'error');
                    });
                }
            });
        });
    });
}

function loadAdminCustomers() {
    const search = customerSearch.value;
    const status = customerStatus.value;

    customersTableBody.innerHTML = `
        <tr>
            <td colspan="5" class="p-10 text-center text-slate-500">
                Loading customers...
            </td>
        </tr>
    `;

    fetch(`{{ route('admin.ajax.customers') }}?search=${encodeURIComponent(search)}&status=${encodeURIComponent(status)}`, {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        customersTableBody.innerHTML = '';
        customersPagination.innerHTML = '';

        if (data.customers.length === 0) {
            customersTableBody.innerHTML = `
                <tr>
                    <td colspan="5" class="p-10 text-center text-slate-500">
                        No customers found.
                    </td>
                </tr>
            `;
            return;
        }

        data.customers.forEach(customer => {
            let isActive = customer.is_active == 1 || customer.is_active === true;
            let buttonText = isActive ? 'Deactivate' : 'Activate';
            let phone = customer.phone ?? 'Not added';
            let joined = customer.created_at ? customer.created_at.substring(0, 10) : '-';

            customersTableBody.innerHTML += `
                <tr class="border-b hover:bg-slate-50 transition">

                    <td class="p-5">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center font-extrabold">
                                ${avatarLetter(customer.name)}
                            </div>

                            <div>
                                <p class="font-extrabold text-slate-900">
                                    ${customer.name}
                                </p>

                                <p class="text-sm text-slate-500">
                                    ${customer.email}
                                </p>

                                <p class="text-xs text-slate-400">
                                    Customer ID #${customer.id}
                                </p>
                            </div>
                        </div>
                    </td>

                    <td class="p-5">
                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                            ${phone}
                        </span>
                    </td>

                    <td class="p-5">
                        <p class="font-semibold text-slate-800">
                            Customer
                        </p>

                        <p class="text-sm text-slate-500">
                            Joined ${joined}
                        </p>
                    </td>

                    <td class="p-5">
                        ${activeBadge(isActive)}
                    </td>

                    <td class="p-5">
                        <div class="flex gap-2">
                            <a href="/admin/customers/${customer.id}"
                               class="bg-blue-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-blue-700 transition">
                                View
                            </a>

                            <form method="POST"
                                  action="/admin/customers/${customer.id}/toggle-status"
                                  class="toggle-form">
                                @csrf
                                @method('PATCH')

                                <button type="button"
                                        class="toggle-btn px-4 py-2 rounded-xl font-bold transition ${actionButton(isActive)}">
                                    ${buttonText}
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            `;
        });

        attachToggleEvents();
    })
    .catch(() => {
        Swal.fire('Error', 'Failed to load customers.', 'error');
    });
}

customerSearch.addEventListener('keyup', loadAdminCustomers);
customerStatus.addEventListener('change', loadAdminCustomers);

customerReset.addEventListener('click', function () {
    customerSearch.value = '';
    customerStatus.value = '';
    loadAdminCustomers();
});

attachToggleEvents();
</script>
@endpush