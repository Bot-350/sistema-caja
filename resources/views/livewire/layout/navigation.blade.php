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

<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="text-gray-800 font-semibold text-sm">
                            Sistema de Caja
                        </a>
                    @else
                        <a href="{{ route('cajero.dashboard') }}" class="text-gray-800 font-semibold text-sm">
                            Sistema de Caja
                        </a>
                    @endif
                </div>

                {{-- Links según rol --}}
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
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
            <div class="hidden sm:flex sm:items-center sm:ms-6 sm:space-x-3">
                <x-dropdown align="right" width="96">
                    <x-slot name="trigger">
                        <button type="button" class="relative inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none transition ease-in-out duration-150">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 2a5 5 0 00-5 5v2.586l-.707.707A1 1 0 005 12h10a1 1 0 00.707-1.707L15 9.586V7a5 5 0 00-5-5z" />
                                <path d="M8 15a2 2 0 104 0H8z" />
                            </svg>
                            @if(count($birthdayNotifications) > 0)
                                <span class="absolute -top-1 -right-1 inline-flex items-center justify-center min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-[11px] font-semibold leading-none">
                                    {{ count($birthdayNotifications) }}
                                </span>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="w-96 max-h-96 overflow-y-auto">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-700">Cumpleaños próximos</p>
                            </div>

                            @forelse($birthdayNotifications as $notification)
                                <div class="px-4 py-3 border-b border-gray-100 last:border-b-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $notification['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $notification['birthday_label'] }}</p>
                                            <p class="text-xs text-blue-600 mt-1">{{ $notification['status'] }}</p>
                                        </div>
                                        <a href="{{ route('customers.show', $notification['id']) }}" class="text-xs text-blue-600 hover:underline whitespace-nowrap">
                                            Ver cliente
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="px-4 py-6 text-sm text-gray-500 text-center">
                                    No existen cumpleaños próximos.
                                </div>
                            @endforelse
                        </div>
                    </x-slot>
                </x-dropdown>

                {{-- Dropdown usuario --}}
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
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
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
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
        <div class="pt-2 pb-3 space-y-1">
            @if(auth()->user()->isAdmin())
                <x-responsive-nav-link :href="route('dashboard')">Dashboard</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sales.index')">Ventas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customers.index')">Clientes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('products.index')">Productos</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('categories.index')">Categorías</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('reports.index')">Reportes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')">Usuarios</x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('cajero.dashboard')">Inicio</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sales.create')">Nueva Venta</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('sales.index')">Ventas</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('customers.index')">Clientes</x-responsive-nav-link>
                <x-responsive-nav-link :href="route('cash.index')">Caja</x-responsive-nav-link>
            @endif
        </div>
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <button wire:click="logout" class="w-full text-start">
                    <x-responsive-nav-link>Cerrar sesión</x-responsive-nav-link>
                </button>
            </div>
        </div>
    </div>
</nav>
