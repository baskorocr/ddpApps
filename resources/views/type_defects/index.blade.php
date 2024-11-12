<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Type Defects Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <!-- Add New Defect Type Button -->
        <button id="openCreateModal"
            class="inline-block bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Add New Type Defect') }}
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
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($typeDefects as $typeDefect)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $typeDefect->id }}
                            </td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                {{ $typeDefect->type }}
                            </td>
                            <td class="px-6 py-4 flex space-x-4">
                                <!-- Edit Button -->
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-4 py-2 rounded-md editDefectTypeBtn"
                                    data-id="{{ $typeDefect->id }}" data-type="{{ $typeDefect->type }}">
                                    {{ __('Edit') }}
                                </button>

                                <!-- Delete Button -->
                                <form action="{{ route('type_defects.destroy', $typeDefect->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this defect type?');">
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

    <!-- Modal for Create New Defect Type -->
    <!-- Modal for Create New Defect Type with Multiple Entries -->
    <div id="createDefectModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Add New Defect Types') }}
            </h2>

            <form id="createDefectForm" method="POST" action="{{ route('type_defects.store') }}">
                @csrf
                <div id="defectInputs">
                    <div class="defect-entry space-y-4">
                        <label for="type[]" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            {{ __('Defect Type') }}
                        </label>
                        <input type="text" name="type[]"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>
                </div>



                <button type="button" id="addDefectInput"
                    class="mt-4 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md">
                    {{ __('Add More Customers') }}
                </button>
                <div class="flex justify-between mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                        {{ __('Add Defect Types') }}
                    </button>
                    <button type="button" id="closeCreateModal"
                        class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        {{ __('Close') }}
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- Modal for Edit Defect Type -->
    <div id="editDefectModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Edit Defect Type') }}</h2>

            <form id="editDefectForm" method="POST" action="{{ route('type_defects.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="editDefectId" name="defect_type_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="editType"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Type') }}</label>
                        <input type="text" name="type" id="editType"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Update Defect Type') }}
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


            const editDefectModal = document.getElementById('editDefectModal');
            const closeEditModalButton = document.getElementById('closeEditModal');
            const editButtons = document.querySelectorAll('.editDefectTypeBtn');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    const type = this.getAttribute('data-type');

                    // Populate the modal with the current defect type data
                    document.getElementById('editType').value = type;
                    document.getElementById('editDefectId').value = id;

                    // Change the form action to point to the specific defect type
                    document.getElementById('editDefectForm').action =
                        `/{{ auth()->user()->role }}/type_defects/${id}`;

                    // Show the modal
                    editDefectModal.classList.remove('hidden');
                });
            });

            closeEditModalButton.addEventListener('click', function() {
                editDefectModal.classList.add('hidden');
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const openCreateModalButton = document.getElementById('openCreateModal');
            const createModal = document.getElementById('createDefectModal');
            const closeCreateModalButton = document.getElementById('closeCreateModal');
            const addDefectInputButton = document.getElementById('addDefectInput');
            const defectInputsContainer = document.getElementById('defectInputs');

            openCreateModalButton.addEventListener('click', function() {
                createModal.classList.remove('hidden');
            });

            closeCreateModalButton.addEventListener('click', function() {
                createModal.classList.add('hidden');
            });

            addDefectInputButton.addEventListener('click', function() {
                const newDefectInput = document.createElement('div');
                newDefectInput.classList.add('defect-entry', 'space-y-4');
                newDefectInput.innerHTML = `
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Defect Type') }}</label>
            <input type="text" name="type[]" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" required>
        `;
                defectInputsContainer.appendChild(newDefectInput);
            });
        });
    </script>
</x-app-layout>
