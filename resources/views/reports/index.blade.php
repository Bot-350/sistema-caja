<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Reportes
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        {{-- Filtros --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <form method="GET" action="{{ route('reports.index') }}" class="flex gap-4 items-end">

                {{-- Tipo de reporte --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tipo</label>
                    <select name="type" onchange="this.form.submit()" class="border rounded px-3 py-2">
                        <option value="daily"   {{ $type === 'daily'   ? 'selected' : '' }}>Diario</option>
                        <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Mensual</option>
                        <option value="annual"  {{ $type === 'annual'  ? 'selected' : '' }}>Anual</option>
                    </select>
                </div>

                {{-- Filtro según tipo --}}
                @if($type === 'daily')
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Fecha</label>
                    <input type="date" name="date" value="{{ $date }}"
                        class="border rounded px-3 py-2" />
                </div>
                @elseif($type === 'monthly')
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Mes</label>
                    <input type="month" name="month" value="{{ $month }}"
                        class="border rounded px-3 py-2" />
                </div>
                @else
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Año</label>
                    <input type="number" name="year" value="{{ $year }}"
                        class="border rounded px-3 py-2 w-28" min="2020" max="2099" />
                </div>
                @endif

                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Buscar
                </button>
            </form>
        </div>

        {{-- Resumen --}}
        <div class="grid grid-cols-3 gap-6 mb-6">
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Total ventas</p>
                <p class="text-3xl font-bold text-blue-600">{{ number_format($total, 2) }} Bs</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Número de ventas</p>
                <p class="text-3xl font-bold text-green-600">{{ $sales->count() }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <p class="text-gray-500 text-sm">Promedio por venta</p>
                <p class="text-3xl font-bold text-purple-600">
                    {{ $sales->count() > 0 ? number_format($total / $sales->count(), 2) : '0.00' }} Bs
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">

            {{-- Lista de ventas --}}
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">Ventas del período</h3>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-gray-600">Venta #</th>
                            <th class="px-6 py-3 text-gray-600">Cliente</th>
                            <th class="px-6 py-3 text-gray-600">Cajero</th>
                            <th class="px-6 py-3 text-gray-600">Pago</th>
                            <th class="px-6 py-3 text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <a href="{{ route('sales.show', $sale) }}"
                                    class="text-blue-600 hover:underline">
                                    {{ $sale->number }}
                                </a>
                            </td>
                            <td class="px-6 py-3">{{ $sale->customer->name ?? 'Sin cliente' }}</td>
                            <td class="px-6 py-3">{{ $sale->user_name }}</td>
                            <td class="px-6 py-3 capitalize">{{ $sale->payment_method }}</td>
                            <td class="px-6 py-3">{{ number_format($sale->total, 2) }} Bs</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                                No hay ventas en este período.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Productos más vendidos --}}
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b">
                    <h3 class="text-lg font-semibold">Productos más vendidos</h3>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-gray-600">Producto</th>
                            <th class="px-6 py-3 text-gray-600">Cantidad</th>
                            <th class="px-6 py-3 text-gray-600">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-3">{{ $product->product_name }}</td>
                            <td class="px-6 py-3">{{ $product->total_quantity }}</td>
                            <td class="px-6 py-3">{{ number_format($product->total_amount, 2) }} Bs</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-400">
                                No hay productos vendidos en este período.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>