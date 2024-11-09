<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Color') }}
        </h2>
    </x-slot>

    <div class="p-6 bg-white dark:bg-gray-800 rounded-lg shadow-lg">
        <!-- Back Button -->
        <a href="{{ route('colors.index') }}"
            class="inline-block bg-gray-500 hover:bg-gray-600 dark:bg-gray-600 dark:hover:bg-gray-700 text-white px-4 py-2 rounded-md mb-4">
            {{ __('Back to Color List') }}
        </a>

        <!-- Form to Edit the Color -->
        <form action="{{ route('colors.update', $color->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <!-- Color Name Input -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('Color Name') }}
                    </label>
                    <input type="text" name="color" id="color" value="{{ old('color', $color->color) }}"
                        class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-white dark:border-gray-600"
                        required>
                    @error('color')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="inline-block bg-blue-500 hover:bg-blue-600 dark:bg-blue-600 dark:hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                        {{ __('Update Color') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
