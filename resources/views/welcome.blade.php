dasds

{{-- <x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white rounded-lg shadow-lg">
        <div class="flex space-x-4 overflow-x-auto">
            <!-- First Table -->
            <div class="w-1/2">
                <table class="table-auto min-w-full text-left text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('ID') }}
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Name') }}
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Email') }}
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($user as $u)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $u->npk }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $u->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $u->email }}
                                </td>
                                <td class="px-6 py-4 flex space-x-4">
                                    <!-- Edit Button -->

                                    <!-- Delete Button -->
                                    <form action="{{ url('/supervisor/deleteUser/' . $u->npk) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Second Table -->
            <div class="w-1/2">
                <table class="table-auto min-w-full text-left text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Another ID') }}
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Another Name') }}
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Another Email') }}
                            </th>
                            <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Another Actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($anotherUser as $au)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $au->npk }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $au->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-700">
                                    {{ $au->email }}
                                </td>
                                <td class="px-6 py-4 flex space-x-4">
                                    <!-- Edit Button -->

                                    <!-- Delete Button -->
                                    <form action="{{ url('/supervisor/deleteAnotherUser/' . $au->npk) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md">
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
    </div>
</x-app-layout> --}}
