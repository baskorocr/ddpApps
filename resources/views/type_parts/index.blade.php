<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Type Parts Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <button id="openCreateModal"
            class="inline-block bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Add New Type Part') }}
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
                            {{ __('Type') }}
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Customer ID') }}
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($typeParts as $typePart)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $typePart->id }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $typePart->type }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $typePart->customer->name }}
                            </td>
                            <td class="px-6 py-4 flex space-x-4">
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-4 py-2 rounded-md editTypePartBtn"
                                    data-id="{{ $typePart->id }}" data-type="{{ $typePart->type }}"
                                    data-customer="{{ $typePart->customer->id }}">
                                    {{ __('Edit') }}
                                </button>

                                <form action="{{ route('type_parts.destroy', $typePart->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this type part?');">
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

    <!-- Modal for Create New Type Part -->
    <div id="createTypePartModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Add New Type Part') }}</h2>

            <form id="createTypePartForm" method="POST" action="{{ route('type_parts.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="type"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Type') }}</label>
                        <input type="text" name="type" id="type"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div>
                        <label for="idCustomer"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Customer') }}</label>
                        <select name="idCustomer" id="idCustomer"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Add Type Part') }}
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

    <!-- Modal for Edit Type Part -->
    <div id="editTypePartModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Edit Type Part') }}</h2>

            <form id="editTypePartForm" method="POST" action="{{ route('type_parts.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="editTypePartId" name="type_part_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="editType"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Type') }}</label>
                        <input type="text" name="type" id="editType"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div>
                        <label for="editIdCustomer"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Customer') }}</label>
                        <select name="idCustomer" id="editIdCustomer"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Update Type Part') }}
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
        document.addEventListener('DOMContentLoaded', function() {
            const openCreateModalButton = document.getElementById('openCreateModal');
            const createModal = document.getElementById('createTypePartModal');
            const closeCreateModalButton = document.getElementById('closeCreateModal');

            openCreateModalButton.addEventListener('click', function() {
                createModal.classList.remove('hidden');
            });

            closeCreateModalButton.addEventListener('click', function() {
                createModal.classList.add('hidden');
            });

            const editTypePartModal = document.getElementById('editTypePartModal');
            const closeEditModalButton = document.getElementById('closeEditModal');
            const editButtons = document.querySelectorAll('.editTypePartBtn');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');
                    const customer = this.getAttribute('data-customer');

                    // Populate the modal with the current type part data
                    document.getElementById('editType').value = type;
                    document.getElementById('editIdCustomer').value = customer;
                    document.getElementById('editTypePartId').value = id;

                    // Change the form action to point to the specific type part
                    document.getElementById('editTypePartForm').action =
                        `/{{ auth()->user()->role }}/type_parts/${id}`;

                    // Show the modal
                    editTypePartModal.classList.remove('hidden');
                });
            });

            closeEditModalButton.addEventListener('click', function() {
                editTypePartModal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
