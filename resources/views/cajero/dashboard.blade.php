<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-malba-gray-dark leading-tight">
            Bienvenido, {{ auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">

        {{-- Tarjetas de resumen --}}
        <div class="grid grid-cols-2 gap-6 mb-6">

            <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter p-6">
                <p class="text-malba-gray-medium text-sm">Mis ventas hoy</p>
                <p class="text-3xl font-bold text-malba-rose-pale">{{ number_format($todayTotal, 2) }} Bs</p>
                <p class="text-malba-gray-medium text-sm mt-1">{{ $todaySales }} ventas</p>
            </div>

            <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter p-6 flex flex-col justify-center items-center gap-3">
                <a href="{{ route('cash.index') }}"
                    class="bg-malba-rose-pale text-white px-6 py-3 rounded-lg w-full text-center font-semibold hover:bg-malba-rose-dark text-lg shadow-elegant transition-colors">
                    Abrir / Cerrar Caja
                </a>
            </div>

        </div>

        {{-- Últimas ventas --}}
        <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter">
            <div class="px-6 py-4 border-b border-malba-gray-lighter flex justify-between items-center">
                <h3 class="text-lg font-semibold text-malba-gray-dark">Mis últimas ventas</h3>
                <a href="{{ route('sales.index') }}" class="text-malba-rose-pale text-sm hover:text-malba-rose-dark">
                    Ver todas
                </a>
            </div>
            <table class="w-full text-left">
                <thead class="bg-malba-rose-pale">
                    <tr>
                        <th class="px-6 py-3 text-white font-semibold">Venta #</th>
                        <th class="px-6 py-3 text-white font-semibold">Cliente</th>
                        <th class="px-6 py-3 text-white font-semibold">Pago</th>
                        <th class="px-6 py-3 text-white font-semibold">Total</th>
                        <th class="px-6 py-3 text-white font-semibold">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestSales as $sale)
                    <tr class="border-b border-malba-gray-lighter hover:bg-malba-gray-light transition-colors duration-150">
                        <td class="px-6 py-3">
                            <a href="{{ route('sales.show', $sale) }}"
                                class="text-malba-rose-pale hover:text-malba-rose-dark">
                                {{ $sale->number }}
                            </a>
                        </td>
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $sale->customer->name ?? 'Sin cliente' }}</td>
                        <td class="px-6 py-3 text-malba-gray-dark capitalize">{{ $sale->payment_method }}</td>
                        <td class="px-6 py-3 text-malba-gray-dark">{{ number_format($sale->total, 2) }} Bs</td>
                        <td class="px-6 py-3">
                            @if($sale->status === 'activa')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg text-xs font-medium">
                                    Activa
                                </span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-lg text-xs font-medium">
                                    Anulada
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-malba-gray-medium">
                            No has registrado ventas hoy.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>