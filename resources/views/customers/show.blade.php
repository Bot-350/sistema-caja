<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-malba-gray-dark md:text-3xl">
            Historial del Cliente
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto px-4 space-y-6">

        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold text-malba-gray-dark">{{ $customer->name }}</h3>
                <p class="text-sm text-malba-gray-medium">Consulta de historial completo de servicios y productos</p>
            </div>
            <a href="{{ route('customers.edit', $customer) }}"
                class="inline-flex items-center rounded-full bg-malba-rose-pale px-4 py-2 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                Editar Cliente
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                <p class="text-sm text-malba-gray-medium">Nombre</p>
                <p class="font-semibold text-malba-gray-dark">{{ $customer->name }}</p>
            </div>
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                <p class="text-sm text-malba-gray-medium">Teléfono</p>
                <p class="font-semibold text-malba-gray-dark">{{ $customer->phone ?? '-' }}</p>
            </div>
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                <p class="text-sm text-malba-gray-medium">Correo</p>
                <p class="font-semibold text-malba-gray-dark break-all">{{ $customer->email ?? '-' }}</p>
            </div>
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                <p class="text-sm text-malba-gray-medium">Cumpleaños</p>
                <p class="font-semibold text-malba-gray-dark">
                    {{ $customer->birthday ? $customer->birthday->format('d/m/Y') : '-' }}
                </p>
            </div>
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                <p class="text-sm text-malba-gray-medium">Cantidad de visitas</p>
                <p class="font-semibold text-malba-gray-dark">{{ $customer->visit_count ?? 0 }}</p>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-malba-gray-lighter bg-white shadow-elegant-lg">
            <div class="border-b border-malba-gray-lighter bg-malba-rose-pale/20 px-6 py-4">
                <h3 class="text-lg font-semibold text-malba-gray-dark">Historial de Servicios y Productos</h3>
            </div>

            @if($sales->isEmpty())
                <div class="px-6 py-10 text-center text-malba-gray-medium">
                    Este cliente no tiene historial registrado.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-malba-rose-pale/20 border-b border-malba-gray-lighter">
                            <tr>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Venta #</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Fecha</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Productos y servicios adquiridos</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Método de pago</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Total</th>
                                <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr class="border-b border-malba-gray-lighter align-top transition-colors hover:bg-malba-gray-light">
                                    <td class="px-6 py-4 font-medium text-malba-gray-dark">{{ $sale->number }}</td>
                                    <td class="px-6 py-4 text-malba-gray-dark">
                                        {{ $sale->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-malba-gray-dark">
                                        @if($sale->items->isEmpty())
                                            -
                                        @else
                                            <ul class="space-y-1">
                                                @foreach($sale->items as $item)
                                                    <li>
                                                        <span class="font-medium">{{ $item->product_name }}</span>
                                                        <span class="text-malba-gray-medium">x{{ $item->quantity }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 capitalize text-malba-gray-dark">{{ $sale->payment_method }}</td>
                                    <td class="px-6 py-4 text-malba-gray-dark">{{ number_format($sale->total, 2) }} Bs</td>
                                    <td class="px-6 py-4">
                                        @if($sale->status === 'activa')
                                            <span class="inline-flex items-center rounded-full border border-green-200 bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                                Activa
                                            </span>
                                        @else
                                            <span class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                                Anulada
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="flex justify-end">
            <a href="{{ route('customers.index') }}"
                class="inline-flex items-center rounded-full border border-malba-gray-lighter bg-white px-4 py-2 text-sm font-semibold text-malba-gray-dark shadow-elegant transition-all duration-200 hover:border-malba-rose-pale hover:text-malba-rose-dark hover:shadow-elegant-lg">
                Volver a Clientes
            </a>
        </div>

    </div>
</x-app-layout>