<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-malba-gray-dark leading-tight dark:text-gray-100">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        {{-- Tarjetas de resumen --}}
        <div class="grid grid-cols-3 gap-6 mb-6">

            <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter p-6 dark:bg-[#242a31] dark:border-[#353b44]">
                <p class="text-malba-gray-medium text-sm dark:text-gray-400">Ventas hoy</p>
                <p class="text-3xl font-bold text-malba-rose-pale dark:text-malba-rose-pale">{{ number_format($todayTotal, 2) }} Bs</p>
                <p class="text-malba-gray-medium text-sm mt-1 dark:text-gray-400">{{ $todaySales }} ventas</p>
            </div>

            <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter p-6 dark:bg-[#242a31] dark:border-[#353b44]">
                <p class="text-malba-gray-medium text-sm dark:text-gray-400">Ventas este mes</p>
                <p class="text-3xl font-bold text-green-600 dark:text-emerald-400">{{ number_format($monthTotal, 2) }} Bs</p>
            </div>

            <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter p-6 dark:bg-[#242a31] dark:border-[#353b44]">
                <p class="text-malba-gray-medium text-sm dark:text-gray-400">Total clientes</p>
                <p class="text-3xl font-bold text-malba-rose-dark dark:text-malba-rose-pale">{{ $totalCustomers }}</p>
            </div>

        </div>

        {{-- Tablas --}}
        <div class="grid grid-cols-2 gap-6">

            {{-- Últimas ventas --}}
            <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter dark:bg-[#242a31] dark:border-[#353b44]">
                <div class="px-6 py-4 border-b border-malba-gray-lighter dark:border-[#353b44]">
                    <h3 class="text-lg font-semibold text-malba-gray-dark dark:text-gray-100">Últimas ventas</h3>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-malba-rose-pale dark:bg-[#d4989f]">
                        <tr>
                            <th class="px-6 py-3 text-white font-semibold">Venta #</th>
                            <th class="px-6 py-3 text-white font-semibold">Cliente</th>
                            <th class="px-6 py-3 text-white font-semibold">Total</th>
                            <th class="px-6 py-3 text-white font-semibold">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestSales as $sale)
                        <tr class="border-b border-malba-gray-lighter hover:bg-malba-gray-light transition-colors duration-150 dark:border-[#353b44] dark:hover:bg-white/5">
                            <td class="px-6 py-3">
                                <a href="{{ route('sales.show', $sale) }}"
                                    class="text-malba-rose-pale hover:text-malba-rose-dark dark:text-malba-rose-pale dark:hover:text-white">
                                    {{ $sale->number }}
                                </a>
                            </td>
                            <td class="px-6 py-3 text-malba-gray-dark dark:text-gray-100">{{ $sale->customer->name ?? 'Sin cliente' }}</td>
                            <td class="px-6 py-3 text-malba-gray-dark dark:text-gray-100">{{ number_format($sale->total, 2) }} Bs</td>
                            <td class="px-6 py-3">
                                @if($sale->status === 'activa')
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-medium dark:bg-emerald-500/15 dark:text-emerald-300">
                                        Activa
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-700 px-2 py-1 rounded-lg text-xs font-medium dark:bg-red-500/15 dark:text-red-300">
                                        Anulada
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-malba-gray-medium dark:text-gray-400">
                                No hay ventas registradas.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Productos más vendidos --}}
            <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter dark:bg-[#242a31] dark:border-[#353b44]">
                <div class="px-6 py-4 border-b border-malba-gray-lighter dark:border-[#353b44]">
                    <h3 class="text-lg font-semibold text-malba-gray-dark dark:text-gray-100">Productos más vendidos este mes</h3>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-malba-rose-pale dark:bg-[#d4989f]">
                        <tr>
                            <th class="px-6 py-3 text-white font-semibold">Producto</th>
                            <th class="px-6 py-3 text-white font-semibold">Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                        <tr class="border-b border-malba-gray-lighter hover:bg-malba-gray-light transition-colors duration-150 dark:border-[#353b44] dark:hover:bg-white/5">
                            <td class="px-6 py-3 text-malba-gray-dark dark:text-gray-100">{{ $product->product_name }}</td>
                            <td class="px-6 py-3 text-malba-gray-dark dark:text-gray-100">{{ $product->total_quantity }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-6 py-4 text-center text-gray-400 dark:text-gray-500">
                                No hay ventas este mes.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>