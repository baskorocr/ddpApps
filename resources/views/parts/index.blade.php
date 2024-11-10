<x-app-layout>
    <x-slot name="header">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Parts Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <button id="openCreateModal"
            class="inline-block bg-green-500 hover:bg-green-600 dark:bg-green-600 dark:hover:bg-green-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Add New Part') }}
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
                            {{ __('Item') }}
                        </th>
                        <th
                            class="px-6 py-3 text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                    @foreach ($parts as $part)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $part->id }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $part->typePart->type }}</td>
                            <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $part->item }}</td>
                            <td class="px-6 py-4 flex space-x-4">
                                <button
                                    class="bg-yellow-500 hover:bg-yellow-600 dark:bg-yellow-600 dark:hover:bg-yellow-700 text-white px-4 py-2 rounded-md editPartBtn"
                                    data-id="{{ $part->id }}" data-item="{{ $part->item }}"
                                    data-idtype="{{ $part->idType }}">
                                    {{ __('Edit') }}
                                </button>

                                <form action="{{ route('parts.destroy', $part->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this part?');">
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

    <!-- Create Part Modal -->
    <div id="createPartModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Add New Part') }}</h2>

            <form id="createPartForm" method="POST" action="{{ route('parts.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="item"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Item') }}</label>
                        <input type="text" name="item" id="item"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div>
                        <label for="idType"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Type') }}</label>
                        <select name="idType" id="idType"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            @foreach ($typeParts as $typePart)
                                <option value="{{ $typePart->id }}">{{ $typePart->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Add Part') }}
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

    <!-- Edit Part Modal -->
    <div id="editPartModal" class="fixed inset-0 bg-gray-500 bg-opacity-50 hidden flex justify-center items-center">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 w-96">
            <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4">{{ __('Edit Part') }}</h2>

            <form id="editPartForm" method="POST" action="{{ route('parts.update', ':id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" id="editPartId" name="part_id" value="">

                <div class="space-y-4">
                    <div>
                        <label for="editItem"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Item') }}</label>
                        <input type="text" name="item" id="editItem"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                    </div>

                    <div>
                        <label for="editIdType"
                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Type') }}</label>
                        <select name="idType" id="editIdType"
                            class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                            required>
                            @foreach ($typeParts as $typePart)
                                <option value="{{ $typePart->id }}">{{ $typePart->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                            {{ __('Update Part') }}
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
        // Open create modal
        document.getElementById('openCreateModal').addEventListener('click', function() {
            document.getElementById('createPartModal').classList.remove('hidden');
        });

        // Close create modal
        document.getElementById('closeCreateModal').addEventListener('click', function() {
            document.getElementById('createPartModal').classList.add('hidden');
        });

        // Open edit modal
        document.querySelectorAll('.editPartBtn').forEach(function(button) {
            button.addEventListener('click', function() {
                const partId = this.dataset.id;
                const item = this.dataset.item;
                const idType = this.dataset.idtype;

                document.getElementById('editPartId').value = partId;
                document.getElementById('editItem').value = item;
                document.getElementById('editIdType').value = idType;

                document.getElementById('editPartForm').action = '/{{ auth()->user()->role }}/parts/' +
                    partId;
                document.getElementById('editPartModal').classList.remove('hidden');
            });
        });

        // Close edit modal
        document.getElementById('closeEditModal').addEventListener('click', function() {
            document.getElementById('editPartModal').classList.add('hidden');
        });
    </script>
</x-app-layout>
