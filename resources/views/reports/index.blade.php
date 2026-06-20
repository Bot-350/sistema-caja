<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-malba-gray-dark md:text-3xl">
            Reportes
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">

        {{-- Filtros --}}
        <div class="mb-6 rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
            <form method="GET" action="{{ route('reports.index') }}" class="flex gap-4 items-end">

                {{-- Tipo de reporte --}}
                <div>
                    <label class="mb-1 block font-medium text-malba-gray-dark">Tipo</label>
                    <select name="type" onchange="this.form.submit()" class="rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20">
                        <option value="daily"   {{ $type === 'daily'   ? 'selected' : '' }}>Diario</option>
                        <option value="monthly" {{ $type === 'monthly' ? 'selected' : '' }}>Mensual</option>
                        <option value="annual"  {{ $type === 'annual'  ? 'selected' : '' }}>Anual</option>
                    </select>
                </div>

                {{-- Filtro según tipo --}}
                @if($type === 'daily')
                <div>
                    <label class="mb-1 block font-medium text-malba-gray-dark">Fecha</label>
                    <input type="date" name="date" value="{{ $date }}"
                        class="rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" />
                </div>
                @elseif($type === 'monthly')
                <div>
                    <label class="mb-1 block font-medium text-malba-gray-dark">Mes</label>
                    <input type="month" name="month" value="{{ $month }}"
                        class="rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" />
                </div>
                @else
                <div>
                    <label class="mb-1 block font-medium text-malba-gray-dark">Año</label>
                    <input type="number" name="year" value="{{ $year }}"
                        class="w-28 rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" min="2020" max="2099" />
                </div>
                @endif

                <button type="submit"
                    class="inline-flex items-center rounded-full bg-malba-rose-pale px-4 py-2 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                    Buscar
                </button>
            </form>
        </div>

        {{-- Resumen --}}
        <div class="grid grid-cols-3 gap-6 mb-6">
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant">
                <p class="text-sm text-malba-gray-medium">Total ventas</p>
                <p class="text-3xl font-bold text-malba-rose-dark">{{ number_format($total, 2) }} Bs</p>
            </div>
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant">
                <p class="text-sm text-malba-gray-medium">Número de ventas</p>
                <p class="text-3xl font-bold text-malba-gray-dark">{{ $sales->count() }}</p>
            </div>
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant">
                <p class="text-sm text-malba-gray-medium">Promedio por venta</p>
                <p class="text-3xl font-bold text-malba-rose-pale">
                    {{ $sales->count() > 0 ? number_format($total / $sales->count(), 2) : '0.00' }} Bs
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">

            {{-- Lista de ventas --}}
            <div class="rounded-2xl border border-malba-gray-lighter bg-white shadow-elegant-lg">
                <div class="border-b border-malba-gray-lighter px-6 py-4 bg-malba-rose-pale/20">
                    <h3 class="text-lg font-semibold text-malba-gray-dark">Ventas del período</h3>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-malba-rose-pale/20 border-b border-malba-gray-lighter">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Venta #</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Cliente</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Cajero</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Pago</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr class="border-b border-malba-gray-lighter transition-colors hover:bg-malba-gray-light">
                            <td class="px-6 py-3">
                                <a href="{{ route('sales.show', $sale) }}"
                                    class="font-semibold text-malba-rose-dark hover:underline">
                                    {{ $sale->number }}
                                </a>
                            </td>
                            <td class="px-6 py-3 text-malba-gray-dark">{{ $sale->customer->name ?? 'Sin cliente' }}</td>
                            <td class="px-6 py-3 text-malba-gray-dark">{{ $sale->user_name }}</td>
                            <td class="px-6 py-3 capitalize text-malba-gray-dark">{{ $sale->payment_method }}</td>
                            <td class="px-6 py-3 text-malba-gray-dark">{{ number_format($sale->total, 2) }} Bs</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-malba-gray-medium">
                                No hay ventas en este período.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Productos más vendidos --}}
            <div class="rounded-2xl border border-malba-gray-lighter bg-white shadow-elegant-lg">
                <div class="border-b border-malba-gray-lighter px-6 py-4 bg-malba-rose-pale/20">
                    <h3 class="text-lg font-semibold text-malba-gray-dark">Productos más vendidos</h3>
                </div>
                <table class="w-full text-left">
                    <thead class="bg-malba-rose-pale/20 border-b border-malba-gray-lighter">
                        <tr>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Producto</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Cantidad</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topProducts as $product)
                        <tr class="border-b border-malba-gray-lighter transition-colors hover:bg-malba-gray-light">
                            <td class="px-6 py-3 text-malba-gray-dark">{{ $product->product_name }}</td>
                            <td class="px-6 py-3 text-malba-gray-dark">{{ $product->total_quantity }}</td>
                            <td class="px-6 py-3 text-malba-gray-dark">{{ number_format($product->total_amount, 2) }} Bs</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-malba-gray-medium">
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