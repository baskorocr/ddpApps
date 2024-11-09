<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Color Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <button id="openCreateModal"
            class="inline-block bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Add New Color') }}
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
                            {{ __('Color') }}
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($colors as $color)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $color->id }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $color->color }}</td>
                            <td class="px-6 py-4 flex space-x-4">
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-4 py-2 rounded-md editColorBtn"
                                    data-id="{{ $color->id }}" data-color="{{ $color->color }}">
                                    {{ __('Edit') }}
                                </button>

                                <form action="{{ route('colors.destroy', $color->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this color?');">
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

    <!-- Modal for Create New Color -->
    <div id="createColorModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                {{ __('Add New Color') }}
            </h2>

            <form id="createColorForm" method="POST" action="{{ route('colors.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="color"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Color Name') }}</label>
                        <input type="text" name="color" id="color"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Add Color') }}
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

    <!-- Modal for Edit Color -->
    <div id="editColorModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">
                {{ __('Edit Color') }}
            </h2>

            <form id="editColorForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" id="editColorId" name="color_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="editColor"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Color Name') }}</label>
                        <input type="text" name="color" id="editColor"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>
                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Update Color') }}
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Create Modal
        document.getElementById('openCreateModal').addEventListener('click', () => {
            document.getElementById('createColorModal').classList.remove('hidden');
        });

        document.getElementById('closeCreateModal').addEventListener('click', () => {
            document.getElementById('createColorModal').classList.add('hidden');
        });

        document.getElementById('createColorForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const actionUrl = this.action;

            try {
                const response = await fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

                if (response.ok) {
                    alert('Color added successfully!');
                    location.reload();
                } else {
                    const errorData = await response.json();
                    alert(`Failed to add color: ${errorData.message || 'Unknown error'}`);
                }
            } catch (error) {
                alert(`Error: ${error.message}`);
            }
        });

        // Edit Modal
        document.querySelectorAll('.editColorBtn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                const color = button.getAttribute('data-color');

                document.getElementById('editColorModal').classList.remove('hidden');
                document.getElementById('editColorId').value = id;
                document.getElementById('editColor').value = color;
                document.getElementById('editColorForm').action =
                    `/{{ auth()->user()->role }}/colors/${id}`;
            });
        });

        document.getElementById('closeEditModal').addEventListener('click', () => {
            document.getElementById('editColorModal').classList.add('hidden');
        });

        document.getElementById('editColorForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const actionUrl = this.action;

            try {
                const response = await fetch(actionUrl, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: formData,
                });

                if (response.ok) {
                    alert('Color updated successfully!');
                    location.reload();
                } else {
                    const errorData = await response.json();
                    alert(`Failed to update color: ${errorData.message || 'Unknown error'}`);
                }
            } catch (error) {
                alert(`Error: ${error.message}`);
            }
        });
    </script>
</x-app-layout>
