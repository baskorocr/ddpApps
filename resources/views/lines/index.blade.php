<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Line Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <button id="openCreateModal"
            class="inline-block bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Add New Line') }}
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
                            {{ __('Name') }}</th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($lines as $line)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $line->id }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $line->nameLine }}</td>
                            <td class="px-6 py-4 flex space-x-4">
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-4 py-2 rounded-md editLineBtn"
                                    data-id="{{ $line->id }}" data-name="{{ $line->nameLine }}">
                                    {{ __('Edit') }}
                                </button>

                                <form action="{{ route('lines.destroy', $line->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this line?');">
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

    <!-- Modal for Create New Line -->
    <div id="createLineModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Add New Line') }}</h2>

            <form id="createLineForm" method="POST" action="{{ route('lines.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="nameLine"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Line Name') }}</label>
                        <input type="text" name="nameLine" id="nameLine"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Add Line') }}
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

    <!-- Modal for Edit Line -->
    <div id="editLineModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Edit Line') }}</h2>

            <form id="editLineForm" method="POST" action="{{ route('lines.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="editLineId" name="line_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="editNameLine"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Line Name') }}</label>
                        <input type="text" name="nameLine" id="editNameLine"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Update Line') }}
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
            const createModal = document.getElementById('createLineModal');
            const closeCreateModalButton = document.getElementById('closeCreateModal');

            openCreateModalButton.addEventListener('click', () => {
                createModal.classList.remove('hidden');
            });

            closeCreateModalButton.addEventListener('click', () => {
                createModal.classList.add('hidden');
            });

            // Edit modal functionality
            const editButtons = document.querySelectorAll('.editLineBtn');
            const editModal = document.getElementById('editLineModal');
            const closeEditModalButton = document.getElementById('closeEditModal');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const lineId = this.getAttribute('data-id');
                    const lineName = this.getAttribute('data-name');

                    // Set the data in the edit modal
                    document.getElementById('editLineId').value = lineId;
                    document.getElementById('editNameLine').value = lineName;

                    // Set the form action to include the line id
                    const formAction = document.getElementById('editLineForm').action.replace(':id',
                        lineId);
                    document.getElementById('editLineForm').action = formAction;

                    editModal.classList.remove('hidden');
                });
            });

            closeEditModalButton.addEventListener('click', () => {
                editModal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
