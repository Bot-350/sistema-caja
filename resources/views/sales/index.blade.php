<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-malba-gray-dark leading-tight">
            Ventas
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto px-4">

        {{-- Mensajes --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        {{-- Botón nueva venta --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('sales.create') }}"
                class="bg-malba-rose-pale text-white px-4 py-2 rounded-lg hover:bg-malba-rose-dark shadow-elegant">
                + Nueva Venta
            </a>
        </div>

        {{-- Lista de ventas --}}
        <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter">
            <table class="w-full text-left">
                <thead class="bg-malba-rose-pale">
                    <tr>
                        <th class="px-6 py-3 text-white font-semibold">Venta #</th>
                        <th class="px-6 py-3 text-white font-semibold">Cliente</th>
                        <th class="px-6 py-3 text-white font-semibold">Cajero</th>
                        <th class="px-6 py-3 text-white font-semibold">Pago</th>
                        <th class="px-6 py-3 text-white font-semibold">Estado</th>
                        <th class="px-6 py-3 text-white font-semibold">Total</th>
                        <th class="px-6 py-3 text-white font-semibold">Fecha</th>
                        <th class="px-6 py-3 text-white font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr class="border-b border-malba-gray-lighter hover:bg-malba-gray-light transition-colors duration-150">
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $sale->number }}</td>
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $sale->customer->name ?? 'Sin cliente' }}</td>
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $sale->user_name }}</td>
                        <td class="px-6 py-3 text-malba-gray-dark capitalize">{{ $sale->payment_method }}</td>
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
                        <td class="px-6 py-3 text-malba-gray-dark">{{ number_format($sale->total, 2) }} Bs</td>
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="{{ route('sales.show', $sale) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded-lg hover:bg-blue-600 text-sm shadow-elegant transition-colors">
                                Ver
                            </a>
                            @if($sale->status === 'activa')
                                <a href="{{ route('sales.ticket', $sale) }}"
                                    class="bg-malba-gray-medium text-white px-3 py-1 rounded-lg hover:bg-malba-gray-dark text-sm shadow-elegant transition-colors">
                                    Imprimir
                                </a>
                            @endif
                            @if(auth()->user()->isAdmin() && $sale->status === 'activa')
                            <form action="{{ route('sales.destroy', $sale) }}" method="POST"
                                onsubmit="return confirm('¿Anular esta venta?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 text-sm shadow-elegant transition-colors">
                                    Anular
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-malba-gray-medium">
                            No hay ventas registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>