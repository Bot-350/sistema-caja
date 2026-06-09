<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Historial del Cliente
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto px-4 space-y-6">

        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold text-gray-900">{{ $customer->name }}</h3>
                <p class="text-sm text-gray-500">Consulta de historial completo de servicios y productos</p>
            </div>
            <a href="{{ route('customers.edit', $customer) }}"
                class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 text-sm">
                Editar Cliente
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Nombre</p>
                <p class="font-semibold text-gray-900">{{ $customer->name }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Teléfono</p>
                <p class="font-semibold text-gray-900">{{ $customer->phone ?? '-' }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Correo</p>
                <p class="font-semibold text-gray-900 break-all">{{ $customer->email ?? '-' }}</p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Cumpleaños</p>
                <p class="font-semibold text-gray-900">
                    {{ $customer->birthday ? $customer->birthday->format('d/m/Y') : '-' }}
                </p>
            </div>
            <div class="bg-white rounded-lg shadow p-4">
                <p class="text-sm text-gray-500">Cantidad de visitas</p>
                <p class="font-semibold text-gray-900">{{ $customer->visit_count ?? 0 }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Historial de Servicios y Productos</h3>
            </div>

            @if($sales->isEmpty())
                <div class="px-6 py-10 text-center text-gray-500">
                    Este cliente no tiene historial registrado.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3 text-gray-600">Venta #</th>
                                <th class="px-6 py-3 text-gray-600">Fecha</th>
                                <th class="px-6 py-3 text-gray-600">Productos y servicios adquiridos</th>
                                <th class="px-6 py-3 text-gray-600">Método de pago</th>
                                <th class="px-6 py-3 text-gray-600">Total</th>
                                <th class="px-6 py-3 text-gray-600">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr class="border-b hover:bg-gray-50 align-top">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $sale->number }}</td>
                                    <td class="px-6 py-4 text-gray-700">
                                        {{ $sale->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">
                                        @if($sale->items->isEmpty())
                                            -
                                        @else
                                            <ul class="space-y-1">
                                                @foreach($sale->items as $item)
                                                    <li>
                                                        <span class="font-medium">{{ $item->product_name }}</span>
                                                        <span class="text-gray-500">x{{ $item->quantity }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 capitalize text-gray-700">{{ $sale->payment_method }}</td>
                                    <td class="px-6 py-4 text-gray-700">{{ number_format($sale->total, 2) }} Bs</td>
                                    <td class="px-6 py-4">
                                        @if($sale->status === 'activa')
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">
                                                Activa
                                            </span>
                                        @else
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">
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
                class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                Volver a Clientes
            </a>
        </div>

    </div>
</x-app-layout>