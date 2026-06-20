<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-malba-gray-dark md:text-3xl">
            Detalle de Venta
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">

        {{-- Encabezado de la venta --}}
        <div class="mb-6 rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold text-malba-gray-dark">Venta #{{ $sale->number }}</h3>
                <a href="{{ route('sales.index') }}"
                    class="inline-flex items-center rounded-full border border-malba-gray-lighter bg-white px-4 py-2 text-sm font-semibold text-malba-gray-dark shadow-elegant transition-all duration-200 hover:border-malba-rose-pale hover:text-malba-rose-dark hover:shadow-elegant-lg">
                    Volver
                </a>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-malba-gray-medium">Cliente:</span>
                    <span class="ml-2">{{ $sale->customer->name ?? 'Sin cliente' }}</span>
                </div>
                <div>
                    <span class="text-malba-gray-medium">Cajero:</span>
                    <span class="ml-2">{{ $sale->user_name }}</span>
                </div>
                <div>
                    <span class="text-malba-gray-medium">Método de pago:</span>
                    <span class="ml-2 capitalize">{{ $sale->payment_method }}</span>
                </div>
                <div>
                    <span class="text-malba-gray-medium">Estado:</span>
                    @if($sale->status === 'activa')
                        <span class="ml-2 inline-flex items-center rounded-full border border-green-200 bg-green-50 px-2 py-1 text-xs font-semibold text-green-700">
                            Activa
                        </span>
                    @else
                        <span class="ml-2 inline-flex items-center rounded-full border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">
                            Anulada
                        </span>
                    @endif
                </div>
                <div>
                    <span class="text-malba-gray-medium">Fecha:</span>
                    <span class="ml-2">{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        <div class="mb-6 rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
            <h3 class="mb-4 text-lg font-semibold text-malba-gray-dark">Resumen del Descuento</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-sm">
                <div class="rounded-2xl border border-malba-gray-lighter bg-malba-gray-light p-4 shadow-elegant">
                    <p class="text-malba-gray-medium">Subtotal</p>
                    <p class="font-semibold text-malba-gray-dark">{{ number_format($sale->subtotal ?? $sale->total, 2) }} Bs</p>
                </div>
                <div class="rounded-2xl border border-malba-gray-lighter bg-malba-gray-light p-4 shadow-elegant">
                    <p class="text-malba-gray-medium">Descuento aplicado</p>
                    <p class="font-semibold text-malba-gray-dark">{{ number_format($sale->discount_percentage ?? 0, 2) }}%</p>
                </div>
                <div class="rounded-2xl border border-malba-gray-lighter bg-malba-gray-light p-4 shadow-elegant">
                    <p class="text-malba-gray-medium">Monto descontado</p>
                    <p class="font-semibold text-malba-gray-dark">{{ number_format($sale->discount_amount ?? 0, 2) }} Bs</p>
                </div>
                <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                    <p class="text-malba-rose-dark">Total final</p>
                    <p class="text-xl font-bold text-malba-rose-dark">{{ number_format($sale->total, 2) }} Bs</p>
                </div>
            </div>
        </div>

        {{-- Items de la venta --}}
        <div class="mb-6 rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
            <h3 class="mb-4 text-lg font-semibold text-malba-gray-dark">Productos</h3>
            <table class="w-full text-left">
                <thead class="border-b border-malba-gray-lighter bg-malba-rose-pale/20">
                    <tr>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Producto</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Precio</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Cantidad</th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sale->items as $item)
                    <tr class="border-b border-malba-gray-lighter transition-colors hover:bg-malba-gray-light">
                        <td class="px-4 py-3 text-malba-gray-dark">{{ $item->product_name }}</td>
                        <td class="px-4 py-3 text-malba-gray-dark">{{ number_format($item->price, 2) }} Bs</td>
                        <td class="px-4 py-3 text-malba-gray-dark">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 text-malba-gray-dark">{{ number_format($item->price * $item->quantity, 2) }} Bs</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-t border-malba-gray-lighter">
                        <td colspan="3" class="px-4 py-3 text-right font-bold text-malba-gray-dark">Total:</td>
                        <td class="px-4 py-3 text-lg font-bold text-malba-rose-dark">{{ number_format($sale->total, 2) }} Bs</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Botón anular --}}
        @if(auth()->user()->isAdmin() && $sale->status === 'activa')
        <div class="flex justify-end">
            <form action="{{ route('sales.destroy', $sale) }}" method="POST"
                onsubmit="return confirm('¿Anular esta venta?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center rounded-full bg-red-500 px-4 py-2 font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-red-600 hover:shadow-elegant-lg">
                    Anular Venta
                </button>
            </form>
        </div>
        @endif

    </div>
</x-app-layout>