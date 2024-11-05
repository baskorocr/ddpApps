<x-app-layout>
    <x-slot name="header">
    </x-slot>

    <!-- Main Content -->
    <div class="flex flex-col items-center justify-center bg-green-300 pt-10 pb-10  space-y-6">
        <!-- Heading Above Both Buttons -->
        <h1 class="text-3xl font-bold text-black mb-8">Select Role Work</h1>

        <div class="flex space-x-4">
            <!-- Left Button -->
            <a href="{{ route('users.q1') }}"
                class="w-[400px] h-[400px] bg-green-500 text-white font-semibold rounded-md hover:bg-blue-800 flex items-center justify-center">
                <h2 class="text-4xl">Q1</h2>
            </a>

            <!-- Right Button -->
            <a href="{{ route('users.q2') }}"
                class="w-[400px] h-[400px] bg-green-500 text-white font-semibold rounded-md hover:bg-blue-800 flex items-center justify-center">
                <h2 class="text-4xl">Q2</h2>
            </a>
        </div>
    </div>

</x-app-layout>
