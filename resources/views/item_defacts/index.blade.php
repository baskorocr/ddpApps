<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Item Defects Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <button id="openCreateModal"
            class="inline-block bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Add New Item Defect') }}
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
                            {{ __('Type Defact') }}
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Item Defact') }}
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($itemDefacts as $itemDefact)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $itemDefact->id }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $itemDefact->typeDefact->type }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $itemDefact->itemDefact }}</td>
                            <td class="px-6 py-4 flex space-x-4">
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-4 py-2 rounded-md editItemDefactBtn"
                                    data-id="{{ $itemDefact->id }}" data-item-defact="{{ $itemDefact->itemDefact }}"
                                    data-type-defact="{{ $itemDefact->typeDefact->id }}">
                                    {{ __('Edit') }}
                                </button>

                                <form action="{{ route('item_defacts.destroy', $itemDefact->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this item defect?');">
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

    <!-- Modal for Create New Item Defect -->
    <div id="createItemDefectModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Add New Item Defect') }}
            </h2>

            <form id="createItemDefectForm" method="POST" action="{{ route('item_defacts.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="idTypeDefact"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Type Defact') }}</label>
                        <select name="idTypeDefact" id="idTypeDefact"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            @foreach ($typeDefacts as $typeDefact)
                                <option value="{{ $typeDefact->id }}">{{ $typeDefact->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="item_defact"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Item Defect') }}</label>
                        <input type="text" name="itemDefact" id="item_defact"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">{{ __('Add Item Defect') }}</button>
                        <button type="button" id="closeCreateModal"
                            class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md">{{ __('Close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Edit Item Defect -->
    <div id="editItemDefectModal"
        class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Edit Item Defect') }}</h2>

            <form id="editItemDefectForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="editItemDefectId" name="item_defect_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="editTypeDefact"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Type Defact') }}</label>
                        <select name="idTypeDefact" id="editTypeDefact"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            @foreach ($typeDefacts as $typeDefact)
                                <option value="{{ $typeDefact->id }}">{{ $typeDefact->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="editItemDefact"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Item Defect') }}</label>
                        <input type="text" name="itemDefact" id="editItemDefact"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">{{ __('Update Item Defect') }}</button>
                        <button type="button" id="closeEditModal"
                            class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md">{{ __('Close') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createModal = document.getElementById('createItemDefectModal');
            const editModal = document.getElementById('editItemDefectModal');
            const closeCreateModalButton = document.getElementById('closeCreateModal');
            const closeEditModalButton = document.getElementById('closeEditModal');

            document.getElementById('openCreateModal').addEventListener('click', function() {
                createModal.classList.remove('hidden');
            });

            document.querySelectorAll('.editItemDefactBtn').forEach(button => {
                button.addEventListener('click', function() {
                    const itemId = button.getAttribute('data-id');
                    const itemDefact = button.getAttribute('data-item-defact');
                    const typeDefactId = button.getAttribute('data-type-defact');

                    document.getElementById('editItemDefectId').value = itemId;
                    document.getElementById('editItemDefact').value = itemDefact;
                    document.getElementById('editTypeDefact').value = typeDefactId;

                    // Dynamically update the action URL of the form
                    const form = document.getElementById('editItemDefectForm');
                    form.action = `/admin/item_defacts/${itemId}`;

                    editModal.classList.remove('hidden');
                });
            });

            closeCreateModalButton.addEventListener('click', function() {
                createModal.classList.add('hidden');
            });

            closeEditModalButton.addEventListener('click', function() {
                editModal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
