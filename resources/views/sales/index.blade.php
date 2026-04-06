<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nueva Venta
            </a>
        </div>

        {{-- Lista de ventas --}}
        <div class="bg-white rounded-lg shadow">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-gray-600">Venta #</th>
                        <th class="px-6 py-3 text-gray-600">Cliente</th>
                        <th class="px-6 py-3 text-gray-600">Cajero</th>
                        <th class="px-6 py-3 text-gray-600">Pago</th>
                        <th class="px-6 py-3 text-gray-600">Estado</th>
                        <th class="px-6 py-3 text-gray-600">Total</th>
                        <th class="px-6 py-3 text-gray-600">Fecha</th>
                        <th class="px-6 py-3 text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $sale->number }}</td>
                        <td class="px-6 py-3">{{ $sale->customer->name ?? 'Sin cliente' }}</td>
                        <td class="px-6 py-3">{{ $sale->user_name }}</td>
                        <td class="px-6 py-3 capitalize">{{ $sale->payment_method }}</td>
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
                        <td class="px-6 py-3">{{ number_format($sale->total, 2) }} Bs</td>
                        <td class="px-6 py-3">{{ $sale->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="{{ route('sales.show', $sale) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                Ver
                            </a>
                            @if($sale->status === 'activa')
                            <form action="{{ route('sales.destroy', $sale) }}" method="POST"
                                onsubmit="return confirm('¿Anular esta venta?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                    Anular
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-4 text-center text-gray-400">
                            No hay ventas registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>