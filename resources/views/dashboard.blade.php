<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <h2 class="text-xl font-semibold leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <x-button target="_blank" href="https://github.com/kamona-wd/kui-laravel-breeze" variant="black"
                class="justify-center max-w-xs gap-2">
                <x-icons.github class="w-6 h-6" aria-hidden="true" />
                <span>Star on Github</span>
            </x-button>
        </div>
    </x-slot>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        {{ __("You're logged in!")  }}
    </div>
</x-app-layout>


 <div x-data="{ open: false }" id="data"
            class="p-4 md:p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-6">
            <!-- Toggle Button -->
            <button @click="open = !open"
                class="text-lg font-semibold mb-4 cursor-pointer w-full flex justify-between items-center p-3 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                <span>Toggle Content</span>
                <i :class="open ? 'rotate-180' : ''" class="fas fa-chevron-down transition-transform duration-200"></i>
            </button>

            <!-- Collapsible Content -->
            <div x-show="open" x-transition>
            </div>
</div>