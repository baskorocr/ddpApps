<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Shift Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <button id="openCreateModal"
            class="inline-block bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Add New Shift') }}
        </button>

        <div class="overflow-x-auto">
            <table class="table-auto min-w-full text-left text-sm">
                <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('ID') }}</th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Shift') }}</th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($shifts as $shift)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $shift->id }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $shift->shift }}</td>
                            <td class="px-6 py-4 flex space-x-4">
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-4 py-2 rounded-md editShiftBtn"
                                    data-id="{{ $shift->id }}" data-shift="{{ $shift->shift }}">
                                    {{ __('Edit') }}
                                </button>

                                <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this shift?');">
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

    <!-- Modal for Create New Shift -->
    <div id="createShiftModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Add New Shifts') }}</h2>

            <form method="POST" action="{{ route('shifts.store') }}">
                @csrf
                <div class="space-y-4" id="shiftFieldsContainer">
                    <div class="shift-field">
                        <label for="shift"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Shift') }}</label>
                        <input type="text" name="shift[]"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>
                </div>

                <!-- Button to add more shift input fields -->
                <button type="button" id="addShiftField"
                    class="mt-3 bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md">
                    {{ __('Add Another Shift') }}
                </button>

                <div class="flex justify-between mt-4">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                        {{ __('Add Shifts') }}
                    </button>
                    <button type="button" id="closeCreateModal"
                        class="bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        {{ __('Close') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal for Edit Shift -->
    <div id="editShiftModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Edit Shift') }}</h2>

            <form id="editShiftForm" method="POST" action="{{ route('shifts.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="editShiftId" name="shift_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="editShift"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Shift') }}</label>
                        <input type="text" name="shift" id="editShift"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Update Shift') }}
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


            // Edit modal functionality
            const editButtons = document.querySelectorAll('.editShiftBtn');
            const editModal = document.getElementById('editShiftModal');
            const closeEditModalButton = document.getElementById('closeEditModal');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const shiftId = this.getAttribute('data-id');
                    const shift = this.getAttribute('data-shift');

                    // Set the data in the edit modal
                    document.getElementById('editShiftId').value = shiftId;
                    document.getElementById('editShift').value = shift;

                    // Set the form action to include the shift id
                    const formAction = document.getElementById('editShiftForm').action.replace(
                        ':id',
                        shiftId);
                    document.getElementById('editShiftForm').action = formAction;

                    editModal.classList.remove('hidden');
                });
            });

            closeEditModalButton.addEventListener('click', () => {
                editModal.classList.add('hidden');
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createModal = document.getElementById('createShiftModal');
            const closeCreateModalButton = document.getElementById('closeCreateModal');
            const addShiftFieldButton = document.getElementById('addShiftField');
            const shiftFieldsContainer = document.getElementById('shiftFieldsContainer');

            document.getElementById('openCreateModal').addEventListener('click', () => {
                createModal.classList.remove('hidden');
            });

            closeCreateModalButton.addEventListener('click', () => {
                createModal.classList.add('hidden');
            });

            addShiftFieldButton.addEventListener('click', () => {
                const newField = document.createElement('div');
                newField.classList.add('shift-field');
                newField.innerHTML = `
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Shift') }}</label>
                <input type="text" name="shift[]" class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600" required>
            `;
                shiftFieldsContainer.appendChild(newField);
            });
        });
    </script>
</x-app-layout>
