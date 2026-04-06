<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Venta
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">

        {{-- Encabezado de la venta --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Venta #{{ $sale->number }}</h3>
                <a href="{{ route('sales.index') }}"
                    class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                    Volver
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-gray-500">Cliente:</span>
                    <span class="ml-2">{{ $sale->customer->name ?? 'Sin cliente' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Cajero:</span>
                    <span class="ml-2">{{ $sale->user_name }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Método de pago:</span>
                    <span class="ml-2 capitalize">{{ $sale->payment_method }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Estado:</span>
                    @if($sale->status === 'activa')
                        <span class="ml-2 bg-green-100 text-green-700 px-2 py-1 rounded text-xs">
                            Activa
                        </span>
                    @else
                        <span class="ml-2 bg-red-100 text-red-700 px-2 py-1 rounded text-xs">
                            Anulada
                        </span>
                    @endif
                </div>
                <div>
                    <span class="text-gray-500">Fecha:</span>
                    <span class="ml-2">{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        {{-- Items de la venta --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Productos</h3>
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-4 py-3 text-gray-600">Producto</th>
                        <th class="px-4 py-3 text-gray-600">Precio</th>
                        <th class="px-4 py-3 text-gray-600">Cantidad</th>
                        <th class="px-4 py-3 text-gray-600">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $item->product_name }}</td>
                        <td class="px-4 py-3">{{ number_format($item->price, 2) }} Bs</td>
                        <td class="px-4 py-3">{{ $item->quantity }}</td>
                        <td class="px-4 py-3">{{ number_format($item->price * $item->quantity, 2) }} Bs</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t">
                        <td colspan="3" class="px-4 py-3 text-right font-bold">Total:</td>
                        <td class="px-4 py-3 font-bold text-lg">{{ number_format($sale->total, 2) }} Bs</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Botón anular --}}
        @if($sale->status === 'activa')
        <div class="flex justify-end">
            <form action="{{ route('sales.destroy', $sale) }}" method="POST"
                onsubmit="return confirm('¿Anular esta venta?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                    Anular Venta
                </button>
            </form>
        </div>
        @endif

    </div>
</x-app-layout>