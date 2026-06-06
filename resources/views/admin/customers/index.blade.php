@extends('layouts.admin')

@section('title', 'Customer Management')

@section('page-title', 'Customer Management')

@section('page-subtitle', 'Search, view and manage registered hotel customers.')

@section('content')

<div class="grid md:grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Total Customers</p>
        <h2 class="text-4xl font-extrabold text-blue-600">
            {{ $totalCustomers }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Active Customers</p>
        <h2 class="text-4xl font-extrabold text-green-600">
            {{ $activeCustomers }}
        </h2>
    </div>

    <div class="bg-white p-6 rounded-3xl shadow">
        <p class="text-slate-500">Inactive Customers</p>
        <h2 class="text-4xl font-extrabold text-red-600">
            {{ $inactiveCustomers }}
        </h2>
    </div>

</div>

<div class="bg-white p-5 rounded-3xl shadow mb-6 grid md:grid-cols-3 gap-4">

    <input type="text"
           id="customerSearch"
           value="{{ $search }}"
           placeholder="Search customer..."
           class="border rounded-2xl px-4 py-3">

    <select id="customerStatus"
            class="border rounded-2xl px-4 py-3">
        <option value="">All Status</option>
        <option value="1" {{ $status === '1' ? 'selected' : '' }}>Active</option>
        <option value="0" {{ $status === '0' ? 'selected' : '' }}>Inactive</option>
    </select>

    <button type="button"
            id="customerReset"
            class="bg-slate-950 text-white px-6 py-3 rounded-2xl font-bold">
        Reset
    </button>

</div>

<div class="bg-white rounded-[2rem] shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px]">
            <thead class="bg-slate-950 text-white">
                <tr>
                    <th class="p-4 text-left">Customer</th>
                    <th class="p-4 text-left">Phone</th>
                    <th class="p-4 text-left">Status</th>
                    <th class="p-4 text-left">Actions</th>
                </tr>
            </thead>

            <tbody id="customersTableBody">
                @forelse($customers as $customer)

                    <tr class="border-b hover:bg-slate-50">

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
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    Active
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex gap-2">

                                <a href="{{ route('admin.customers.show', $customer->id) }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-xl font-bold">
                                    View
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.customers.toggleStatus', $customer->id) }}"
                                      class="toggle-form">
                                    @csrf
                                    @method('PATCH')

                                    <button type="button"
                                            class="toggle-btn bg-amber-500 text-white px-4 py-2 rounded-xl font-bold">
                                        {{ $customer->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500">
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

function attachToggleEvents() {
    document.querySelectorAll('.toggle-btn').forEach(button => {
        button.addEventListener('click', function () {
            const form = this.closest('form');

            Swal.fire({
                title: 'Update customer status?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes',
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
            <td colspan="4" class="p-8 text-center text-slate-500">
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
                    <td colspan="4" class="p-8 text-center text-slate-500">
                        No customers found.
                    </td>
                </tr>
            `;
            return;
        }

        data.customers.forEach(customer => {
            let activeBadge = customer.is_active
                ? `<span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">Active</span>`
                : `<span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">Inactive</span>`;

            let buttonText = customer.is_active ? 'Deactivate' : 'Activate';

            customersTableBody.innerHTML += `
                <tr class="border-b hover:bg-slate-50">
                    <td class="p-4">
                        <p class="font-bold">${customer.name}</p>
                        <p class="text-sm text-slate-500">${customer.email}</p>
                    </td>

                    <td class="p-4">
                        ${customer.phone ?? '-'}
                    </td>

                    <td class="p-4">
                        ${activeBadge}
                    </td>

                    <td class="p-4">
                        <div class="flex gap-2">
                            <a href="/admin/customers/${customer.id}"
                               class="bg-blue-600 text-white px-4 py-2 rounded-xl font-bold">
                                View
                            </a>

                            <form method="POST"
                                  action="/admin/customers/${customer.id}/toggle-status"
                                  class="toggle-form">
                                @csrf
                                @method('PATCH')

                                <button type="button"
                                        class="toggle-btn bg-amber-500 text-white px-4 py-2 rounded-xl font-bold">
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