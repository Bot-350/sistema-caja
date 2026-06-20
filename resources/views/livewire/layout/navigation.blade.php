<?php

use App\Livewire\Actions\Logout;
use App\Models\Customer;
use Carbon\Carbon;
use Livewire\Volt\Component;

new class extends Component
{
    public function logout(Logout $logout): void
    {
        $logout();
        $this->redirect('/', navigate: true);
    }
}; ?>

@php
    $today = now()->startOfDay();
    $birthdayNotifications = Customer::query()
        ->whereNotNull('birthday')
        ->get()
        ->map(function (Customer $customer) use ($today) {
            $birthday = Carbon::parse($customer->birthday)->startOfDay();
            $nextBirthday = Carbon::create($today->year, $birthday->month, $birthday->day, 0, 0, 0);

            if ($nextBirthday->lt($today)) {
                $nextBirthday->addYear();
            }

            if ($today->diffInDays($nextBirthday, false) > 7) {
                return null;
            }

            if ($nextBirthday->isSameDay($today)) {
                $status = 'Cumple hoy';
            } elseif ($nextBirthday->isSameDay($today->copy()->addDay())) {
                $status = 'Cumple mañana';
            } else {
                $status = 'Cumple en los próximos 7 días';
            }

            return [
                'id' => $customer->id,
                'name' => $customer->name,
                'birthday' => $nextBirthday,
                'birthday_label' => $nextBirthday->format('d/m/Y'),
                'status' => $status,
            ];
        })
        ->filter()
        ->sortBy('birthday')
        ->values()
        ->all();
@endphp

<nav x-data="{ open: false }" class="bg-white border-b border-malba-gray-lighter shadow-elegant dark:bg-[#242a31] dark:border-[#353b44]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-nowrap items-center justify-between gap-3 py-2 lg:h-16 lg:py-0">
            <div class="flex min-w-0 flex-nowrap items-center gap-3">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 rounded-full px-2 py-1 text-sm font-semibold text-malba-gray-dark transition-colors duration-200 hover:bg-malba-gray-light hover:text-malba-rose-dark dark:text-gray-100 dark:hover:bg-white/5 dark:hover:text-malba-rose-pale">
                            <x-application-logo class="h-8 w-8 text-malba-rose-pale" />
                            <span class="block text-[11px] uppercase tracking-[0.35em] text-malba-gray-medium">MALBA</span>
                        </a>
                    @else
                        <a href="{{ route('cajero.dashboard') }}" class="flex items-center gap-3 rounded-full px-2 py-1 text-sm font-semibold text-malba-gray-dark transition-colors duration-200 hover:bg-malba-gray-light hover:text-malba-rose-dark dark:text-gray-100 dark:hover:bg-white/5 dark:hover:text-malba-rose-pale">
                            <x-application-logo class="h-8 w-8 text-malba-rose-pale" />
                            <span class="block text-[11px] uppercase tracking-[0.35em] text-malba-gray-medium">MALBA</span>
                        </a>
                    @endif
                </div>

                {{-- Links según rol --}}
                <div class="hidden sm:ms-4 sm:flex sm:min-w-0 sm:flex-nowrap sm:items-center sm:gap-x-1 md:ms-5 md:gap-x-2 lg:ms-6 lg:gap-x-3 xl:gap-x-4">
                    @if(auth()->user()->isAdmin())
                        {{-- Menú Admin --}}
                        <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('sales.create')" :active="request()->routeIs('sales.create')">
                            Nueva Venta
                        </x-nav-link>
                        <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                            Ventas
                        </x-nav-link>
                        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                            Clientes
                        </x-nav-link>
                        <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.*')">
                            Productos
                        </x-nav-link>
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')">
                            Categorías
                        </x-nav-link>
                        <x-nav-link :href="route('reports.index')" :active="request()->routeIs('reports.*')">
                            Reportes
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                            Usuarios
                        </x-nav-link>
                        <x-nav-link :href="route('cash.index')" :active="request()->routeIs('cash.*')">
                            Caja
                        </x-nav-link>
                    @else
                        {{-- Menú Cajero --}}
                        <x-nav-link :href="route('cajero.dashboard')" :active="request()->routeIs('cajero.dashboard')">
                            Inicio
                        </x-nav-link>
                        <x-nav-link :href="route('sales.create')" :active="request()->routeIs('sales.create')">
                            Nueva Venta
                        </x-nav-link>
                        <x-nav-link :href="route('sales.index')" :active="request()->routeIs('sales.index')">
                            Ventas
                        </x-nav-link>
                        <x-nav-link :href="route('customers.index')" :active="request()->routeIs('customers.*')">
                            Clientes
                        </x-nav-link>
                        <x-nav-link :href="route('cash.index')" :active="request()->routeIs('cash.*')">
                            Caja
                        </x-nav-link>
                    @endif
                </div>
            </div>

            {{-- Notificaciones y usuario --}}
            <div class="hidden sm:flex sm:items-center sm:ms-auto sm:shrink-0 sm:space-x-2">
                <x-dropdown align="right" width="96">
                    <x-slot name="trigger">
                        <button type="button" class="relative inline-flex items-center justify-center rounded-xl border border-malba-gray-lighter bg-white p-2 text-malba-gray-medium shadow-elegant transition-all duration-200 hover:border-malba-rose-pale hover:text-malba-rose-dark hover:shadow-elegant-lg focus:outline-none focus:ring-2 focus:ring-malba-rose-pale dark:border-[#353b44] dark:bg-[#2b313a] dark:text-gray-300 dark:hover:border-malba-rose-pale dark:hover:text-malba-rose-pale">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2a5 5 0 00-5 5v2.586l-.707.707A1 1 0 005 12h10a1 1 0 00.707-1.707L15 9.586V7a5 5 0 00-5-5z" />
                                <path d="M8 15a2 2 0 104 0H8z" />
                            </svg>
                            @if(count($birthdayNotifications) > 0)
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-5 h-5 px-1 rounded-full bg-malba-rose-dark text-white text-[11px] font-semibold leading-none">
                                    {{ count($birthdayNotifications) }}
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="w-96 max-h-96 overflow-y-auto bg-white dark:bg-[#2b313a]">
                            <div class="border-b border-malba-gray-lighter px-4 py-3 bg-malba-rose-pale/10 dark:border-[#353b44] dark:bg-white/5">
                                <p class="text-sm font-semibold text-malba-gray-dark dark:text-gray-100">Cumpleaños próximos</p>
                            </div>

                            @forelse($birthdayNotifications as $notification)
                                <div class="px-4 py-3 border-b border-malba-gray-lighter last:border-b-0 dark:border-[#353b44]">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-medium text-malba-gray-dark dark:text-gray-100">{{ $notification['name'] }}</p>
                                            <p class="text-xs text-malba-gray-medium dark:text-gray-400">{{ $notification['birthday_label'] }}</p>
                                            <p class="text-xs text-malba-rose-dark mt-1">{{ $notification['status'] }}</p>
                                        </div>
                                        <a href="{{ route('customers.show', $notification['id']) }}" class="text-xs font-semibold text-malba-rose-dark hover:text-malba-rose-pale whitespace-nowrap dark:text-malba-rose-pale dark:hover:text-white">
                                            Ver cliente
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-6 text-sm text-malba-gray-medium text-center dark:text-gray-400">
                                    No existen cumpleaños próximos.
                                </div>
                            @endforelse
                        </div>
                    </x-slot>
                </x-dropdown>

                {{-- Dropdown usuario --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-2 rounded-xl border border-malba-gray-lighter bg-white px-3 py-2 text-sm font-medium leading-4 text-malba-gray-medium shadow-elegant transition-all duration-200 hover:border-malba-rose-pale hover:text-malba-gray-dark hover:shadow-elegant-lg focus:outline-none focus:ring-2 focus:ring-malba-rose-pale dark:border-[#353b44] dark:bg-[#2b313a] dark:text-gray-300 dark:hover:border-malba-rose-pale dark:hover:text-gray-100">
                            <span class="h-2 w-2 rounded-full bg-malba-rose-pale"></span>
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name" class="max-w-[140px] truncate"></div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <div x-data="{ dark: document.documentElement.classList.contains('dark') }" @malba-theme-changed.window="dark = document.documentElement.classList.contains('dark')">
                            <button type="button" onclick="window.MALBAToggleTheme()" class="w-full text-start">
                                <x-dropdown-link>
                                    <span x-text="dark ? '☀️ Cambiar a modo claro' : '🌙 Cambiar a modo oscuro'"></span>
                                </x-dropdown-link>
                            </button>
                        </div>
                        <button wire:click="logout" class="w-full text-start">
                            <x-dropdown-link>
                                Cerrar sesión
                            </x-dropdown-link>
                        </button>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-xl border border-malba-gray-lighter bg-white p-2 text-malba-gray-medium shadow-elegant transition-all duration-200 hover:border-malba-rose-pale hover:text-malba-gray-dark hover:shadow-elegant-lg focus:outline-none focus:ring-2 focus:ring-malba-rose-pale dark:border-[#353b44] dark:bg-[#2b313a] dark:text-gray-300 dark:hover:border-malba-rose-pale dark:hover:text-gray-100">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menú responsive --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-white border-t border-malba-gray-lighter dark:bg-[#242a31] dark:border-[#353b44]">
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sales.index')">Ventas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customers.index')">Clientes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('products.index')">Productos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('categories.index')">Categorías</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.index')">Reportes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')">Usuarios</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cash.index')">Caja</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('cajero.dashboard')">Inicio</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sales.create')">Nueva Venta</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sales.index')">Ventas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customers.index')">Clientes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cash.index')">Caja</x-responsive-nav-link>
            @endif
            <button type="button" onclick="window.MALBAToggleTheme()" class="w-full px-4 py-2 text-start text-sm leading-5 text-malba-gray-dark hover:bg-malba-gray-light focus:outline-none focus:bg-malba-gray-light transition duration-150 ease-in-out dark:text-gray-100 dark:hover:bg-white/5 dark:focus:bg-white/5" x-data="{ dark: document.documentElement.classList.contains('dark') }" @malba-theme-changed.window="dark = document.documentElement.classList.contains('dark')">
                <span x-text="dark ? '☀️ Cambiar a modo claro' : '🌙 Cambiar a modo oscuro'"></span>
            </button>
        </div>
        <div class="border-t border-malba-gray-lighter pt-4 pb-1 bg-white dark:bg-[#242a31] dark:border-[#353b44]">
            <div class="px-4">
                <div class="font-medium text-base text-malba-gray-dark dark:text-gray-100">{{ auth()->user()->name }}</div>
                <div class="font-medium text-sm text-malba-gray-medium dark:text-gray-400">{{ auth()->user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>Cerrar sesión</x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
