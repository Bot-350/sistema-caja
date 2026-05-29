<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bienvenido, {{ auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">

        {{-- Tarjetas de resumen --}}
        <div class="grid grid-cols-2 gap-6 mb-6">

            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Mis ventas hoy</p>
                <p class="text-3xl font-bold text-blue-600">{{ number_format($todayTotal, 2) }} Bs</p>
                <p class="text-gray-400 text-sm mt-1">{{ $todaySales }} ventas</p>
            </div>

            <div class="bg-white rounded-lg shadow p-6 flex flex-col justify-center items-center gap-3">
                <a href="{{ route('cash.index') }}"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg w-full text-center font-semibold hover:bg-blue-700 text-lg">
                    Abrir / Cerrar Caja
                </a>
            </div>

        </div>

        {{-- Últimas ventas --}}
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h3 class="text-lg font-semibold">Mis últimas ventas</h3>
                <a href="{{ route('sales.index') }}" class="text-blue-600 text-sm hover:underline">
                    Ver todas
                </a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-gray-600">Venta #</th>
                        <th class="px-6 py-3 text-gray-600">Cliente</th>
                        <th class="px-6 py-3 text-gray-600">Pago</th>
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
                        <td class="px-6 py-3 capitalize">{{ $sale->payment_method }}</td>
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
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                            No has registrado ventas hoy.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>