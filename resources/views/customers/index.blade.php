<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Customer Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <button id="openCreateModal"
            class="inline-block bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Add New Customer') }}
        </button>

        <div class="overflow-x-auto">
            <table class="table-auto min-w-full text-left text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('ID') }}
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Name') }}
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($customers as $customer)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $customer->id }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $customer->name }}
                            </td>
                            <td class="px-6 py-4 flex space-x-4">
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-4 py-2 rounded-md editCustomerBtn"
                                    data-id="{{ $customer->id }}" data-name="{{ $customer->name }}">
                                    {{ __('Edit') }}
                                </button>

                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this customer?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 hover:bg-red-600 dark:bg-red-600 dark:hover:bg-red-700 text-white px-4 py-2 rounded-md">
                                        {{ __('Delete') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Create New Customer -->
    <div id="createCustomerModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 id="createModalTitle" class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                {{ __('Add New Customer') }}</h2>

            <form id="createCustomerForm" method="POST" action="{{ route('customers.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Customer Name') }}</label>
                        <input type="text" name="name" id="name"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                        <span class="text-red-600 text-sm" id="createNameError"></span>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" id="createSubmitButton"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Add Customer') }}
                        </button>
                        <button type="button" id="closeCreateModal"
                            class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Edit Customer -->
    <div id="editCustomerModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 id="editModalTitle" class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                {{ __('Edit Customer') }}</h2>

            <form id="editCustomerForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editCustomerId" name="customer_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="editName"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Customer Name') }}</label>
                        <input type="text" name="name" id="editName"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                        <span class="text-red-600 text-sm" id="editNameError"></span>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit" id="editSubmitButton"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Update Customer') }}
                        </button>
                        <button type="button" id="closeEditModal"
                            class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            {{ __('Close') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Set CSRF token in request headers for AJAX
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Open Create Modal
        document.getElementById('openCreateModal').addEventListener('click', function() {
            document.getElementById('createCustomerModal').classList.remove('hidden');
            document.getElementById('createCustomerForm').reset();
            document.getElementById('createNameError').textContent = '';
        });

        // Close Create Modal
        document.getElementById('closeCreateModal').addEventListener('click', function() {
            document.getElementById('createCustomerModal').classList.add('hidden');
        });

        // Edit Customer
        document.querySelectorAll('.editCustomerBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                const customerId = this.getAttribute('data-id');
                const customerName = this.getAttribute('data-name');

                document.getElementById('editCustomerModal').classList.remove('hidden');
                document.getElementById('editCustomerForm').action =
                    "/{{ auth()->user()->role }}/customers/" + customerId;
                document.getElementById('editCustomerId').value = customerId;
                document.getElementById('editName').value = customerName;
                document.getElementById('editNameError').textContent = '';
            });
        });

        // Close Edit Modal
        document.getElementById('closeEditModal').addEventListener('click', function() {
            document.getElementById('editCustomerModal').classList.add('hidden');
        });

        // Handle form submission for creating customer
        document.getElementById('createCustomerForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const actionUrl = this.action;

            fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken, // Include CSRF token here
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        document.getElementById('createNameError').textContent = data.errors.name || '';
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });

        // Handle form submission for editing customer
        document.getElementById('editCustomerForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(this);
            const actionUrl = this.action;

            fetch(actionUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        document.getElementById('editNameError').textContent = data.errors.name || '';
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
</x-app-layout>
