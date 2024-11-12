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
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $customer->id }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $customer->name }}</td>
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

    <!-- Modal for Create New Customers -->
    <div id="createCustomerModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                {{ __('Add New Customers') }}
            </h2>

            <form id="createCustomerForm" method="POST" action="{{ route('customers.store') }}">
                @csrf
                <div id="customerFields" class="space-y-4">
                    <div>
                        <label for="name[]"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Customer Name') }}</label>
                        <input type="text" name="name[]"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>
                </div>
                <button type="button" id="addMoreCustomers"
                    class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                    {{ __('Add More Customers') }}
                </button>
                <div class="flex justify-between mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                        {{ __('Add Customers') }}
                    </button>
                    <button type="button" id="closeCreateModal"
                        class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        {{ __('Close') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="editCustomerModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                {{ __('Edit Customer') }}
            </h2>

            <form id="editCustomerForm" method="POST">
                @csrf
                @method('PUT')
                <div>
                    <label for="editName"
                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Customer Name') }}</label>
                    <input type="text" id="editName" name="name"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        required>
                </div>
                <div class="flex justify-between mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                        {{ __('Update Customer') }}
                    </button>
                    <button type="button" id="closeEditModal"
                        class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        {{ __('Close') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Show Create Modal
        document.getElementById('openCreateModal').addEventListener('click', () => {
            document.getElementById('createCustomerModal').classList.remove('hidden');
        });

        // Close Create Modal
        document.getElementById('closeCreateModal').addEventListener('click', () => {
            document.getElementById('createCustomerModal').classList.add('hidden');
        });

        // Add More Customer Fields
        document.getElementById('addMoreCustomers').addEventListener('click', () => {
            const customerFieldsContainer = document.getElementById('customerFields');
            const newCustomerField = document.createElement('div');
            newCustomerField.innerHTML =
                `
                <label for="name[]"
                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Customer Name') }}</label>
                <input type="text" name="name[]" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" required>`;
            customerFieldsContainer.appendChild(newCustomerField);
        });

        // Handle Form Submission
        document.getElementById('createCustomerForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch("{{ route('customers.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

                if (response.ok) {
                    location.reload();
                } else {
                    const errorData = await response.json();
                    alert(`Failed to add customers: ${errorData.message || 'Unknown error'}`);
                }
            } catch (error) {
                alert(`Error: ${error.message}`);
            }
        });
    </script>
    <script>
        // Handle Edit Button Click
        document.querySelectorAll('.editCustomerBtn').forEach(button => {
            button.addEventListener('click', () => {
                const customerId = button.getAttribute('data-id');
                const customerName = button.getAttribute('data-name');

                // Set the modal form action to point to the correct route for updating the customer
                document.getElementById('editCustomerForm').action =
                    `/{{ auth()->user()->role }}/customers/${customerId}`;

                // Set the input value to the current customer's name
                document.getElementById('editName').value = customerName;

                // Show the Edit Modal
                document.getElementById('editCustomerModal').classList.remove('hidden');
            });
        });

        // Close Edit Modal
        document.getElementById('closeEditModal').addEventListener('click', () => {
            document.getElementById('editCustomerModal').classList.add('hidden');
        });

        // Handle Edit Form Submission
        document.getElementById('editCustomerForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch(this.action, {
                    method: 'POST', // Use POST here because the PUT method is overridden
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'X-HTTP-Method-Override': 'PUT', // Indicate it's a PUT request
                    },
                    body: formData,
                });

                if (response.ok) {
                    location.reload();
                } else {
                    const errorData = await response.json();
                    alert(`Failed to update customer: ${errorData.message || 'Unknown error'}`);
                }
            } catch (error) {
                alert(`Error: ${error.message}`);
            }
        });
    </script>
</x-app-layout>
