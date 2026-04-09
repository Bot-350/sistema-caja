<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        <div class="flex gap-6">

            <div class="flex-1">

                {{-- Tarjetas de resumen --}}
                <div class="grid grid-cols-3 gap-6 mb-6">

                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-gray-500 text-sm">Ventas hoy</p>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($todayTotal, 2) }} Bs</p>
                        <p class="text-gray-400 text-sm mt-1">{{ $todaySales }} ventas</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-gray-500 text-sm">Ventas este mes</p>
                        <p class="text-3xl font-bold text-green-600">{{ number_format($monthTotal, 2) }} Bs</p>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <p class="text-gray-500 text-sm">Total clientes</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalCustomers }}</p>
                    </div>

                </div>

                {{-- Tablas --}}
                <div class="grid grid-cols-2 gap-6">

                    {{-- Últimas ventas --}}
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b">
                            <h3 class="text-lg font-semibold">Últimas ventas</h3>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-gray-600">Venta #</th>
                                    <th class="px-6 py-3 text-gray-600">Cliente</th>
                                    <th class="px-6 py-3 text-gray-600">Total</th>
                                    <th class="px-6 py-3 text-gray-600">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestSales as $sale)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3">
                                        <a href="{{ route('sales.show', $sale) }}"
                                            class="text-blue-600 hover:underline">
                                            {{ $sale->number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-3">{{ $sale->customer->name ?? 'Sin cliente' }}</td>
                                    <td class="px-6 py-3">{{ number_format($sale->total, 2) }} Bs</td>
                                    <td class="px-6 py-3">
                                        @if($sale->status === 'activa')
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                                                Activa
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
                                                Anulada
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-400">
                                        No hay ventas registradas.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Productos más vendidos --}}
                    <div class="bg-white rounded-lg shadow">
                        <div class="px-6 py-4 border-b">
                            <h3 class="text-lg font-semibold">Productos más vendidos este mes</h3>
                        </div>
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-6 py-3 text-gray-600">Producto</th>
                                    <th class="px-6 py-3 text-gray-600">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topProducts as $product)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-6 py-3">{{ $product->product_name }}</td>
                                    <td class="px-6 py-3">{{ $product->total_quantity }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="px-6 py-4 text-center text-gray-400">
                                        No hay ventas este mes.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

            {{-- Accesos rápidos --}}
            <div class="w-48 bg-white rounded-lg shadow p-4 flex flex-col gap-2">
                <p class="text-gray-500 text-sm mb-2 font-medium"></p>
                <a href="{{ route('sales.create') }}"
                    class="bg-blue-600 text-white px-3 py-2 rounded text-sm text-center hover:bg-blue-700">
                    Nueva Venta
                </a>
                <a href="{{ route('sales.index') }}"
                    class="bg-blue-100 text-blue-700 px-3 py-2 rounded text-sm text-center hover:bg-blue-200">
                    Ver Ventas
                </a>
                <a href="{{ route('customers.create') }}"
                    class="bg-green-600 text-white px-3 py-2 rounded text-sm text-center hover:bg-green-700">
                    Nuevo Cliente
                </a>
                <a href="{{ route('customers.index') }}"
                    class="bg-green-100 text-green-700 px-3 py-2 rounded text-sm text-center hover:bg-green-200">
                    Ver Clientes
                </a>
                <a href="{{ route('products.index') }}"
                    class="bg-purple-100 text-purple-700 px-3 py-2 rounded text-sm text-center hover:bg-purple-200">
                    Ver Productos
                </a>
                <a href="{{ route('categories.index') }}"
                    class="bg-yellow-100 text-yellow-700 px-3 py-2 rounded text-sm text-center hover:bg-yellow-200">
                    Ver Categorías
                </a>
            </div>

        </div>

    </div>
</x-app-layout>