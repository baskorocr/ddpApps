<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    <x-sidebar.link title="Dashboard" href="{{ url(auth()->user()->role . '/dashboard') }}" :isActive="url(auth()->user()->role . '/dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link>

    <x-sidebar.dropdown title="Form Request" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
        <x-slot name="icon">
            <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>

        <x-sidebar.sublink title="Form Overview" href="#" :active="request()->routeIs('buttons.text')" />
        @if (auth()->user()->role == 'users')
            <x-sidebar.sublink title="Create Form" href="#" :active="request()->routeIs('buttons.text')" />
        @endif
        {{-- <x-sidebar.sublink title="Icon button" href="#" :active="request()->routeIs('buttons.icon')" />
        <x-sidebar.sublink title="Text with icon" href="#" :active="request()->routeIs('buttons.text-icon')" /> --}}
    </x-sidebar.dropdown>
    @if (auth()->user()->role == 'supervisor')
        <x-sidebar.link title="User" href="{{ route('user.index') }}">
            <x-slot name="icon">
                <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
    @endif





</x-perfect-scrollbar>
