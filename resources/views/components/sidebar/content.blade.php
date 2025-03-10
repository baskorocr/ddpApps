<x-perfect-scrollbar as="nav" aria-label="main" class="flex flex-col flex-1 gap-4 px-3">

    {{-- <x-sidebar.link title="Dashboard" href="{{ url(auth()->user()->role . '/dashboard') }}" :isActive="url(auth()->user()->role . '/dashboard')">
        <x-slot name="icon">
            <x-icons.dashboard class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.link> --}}

    @if (auth()->user()->role == 'admin')
        <x-sidebar.dropdown title="Menu Management" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
            <x-slot name="icon">
                <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>


            <x-sidebar.sublink title="customers" href="{{ route('customers.index') }}" :active="request()->routeIs('customers.index')">
                <x-slot name="icon">
                    <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.sublink>
            <x-sidebar.sublink title="colors" href="{{ route('colors.index') }}" :active="request()->routeIs('colors.index')">
                <x-slot name="icon">
                    <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.sublink>
            <x-sidebar.sublink title="type_parts" href="{{ route('type_parts.index') }}" :active="request()->routeIs('type_parts.index')">
                <x-slot name="icon">
                    <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.sublink>
            <x-sidebar.sublink title="type_defacts" href="{{ route('type_defects.index') }}" :active="request()->routeIs('type_defects.index')">
                <x-slot name="icon">
                    <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.sublink>
            <x-sidebar.sublink title="shifts" href="{{ route('shifts.index') }}" :active="request()->routeIs('shifts.index')">
                <x-slot name="icon">
                    <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.sublink>
            <x-sidebar.sublink title="lines" href="{{ route('lines.index') }}" :active="request()->routeIs('lines.index')">
                <x-slot name="icon">
                    <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.sublink>
            <x-sidebar.sublink title="item_defacts" href="{{ route('item_defacts.index') }}" :active="request()->routeIs('item_defacts.index')">
                <x-slot name="icon">
                    <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.sublink>
            <x-sidebar.sublink title="parts" href="{{ route('parts.index') }}" :active="request()->routeIs('parts.index')">
                <x-slot name="icon">
                    <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
                </x-slot>
            </x-sidebar.sublink>

        </x-sidebar.dropdown>

        <x-sidebar.dropdown title="Data Report" :active="Str::startsWith(request()->route()->uri(), 'buttons')">
    <x-slot name="icon">
        <x-heroicon-o-view-grid class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
    </x-slot>

    <x-sidebar.sublink title="FSP Data" href="{{ route('reports.index') }}" :active="request()->routeIs('reports.index')">
        <x-slot name="icon">
            <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.sublink>
    <x-sidebar.sublink title="Detail Defact" href="{{ route('reports.index') }}" :active="request()->routeIs('reports.index')">
        <x-slot name="icon">
            <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
        </x-slot>
    </x-sidebar.sublink>

</x-sidebar.dropdown>


        <x-sidebar.link title="User" href="{{ route('member.index') }}">
            <x-slot name="icon">
                <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>

        <!-- report -->
        
    @endif



    @if (auth()->user()->role == 'supervisor')
        <x-sidebar.link title="User" href="{{ route('member.index') }}">
            <x-slot name="icon">
                <x-heroicon-o-user class="flex-shrink-0 w-6 h-6" aria-hidden="true" />
            </x-slot>
        </x-sidebar.link>
    @endif







</x-perfect-scrollbar>
