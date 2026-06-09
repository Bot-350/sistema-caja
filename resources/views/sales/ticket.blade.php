<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight no-print">
            Ticket de Venta
        </h2>
    </x-slot>

    <div class="ticket-page py-6 max-w-2xl mx-auto px-4">
        <div class="bg-white rounded-lg shadow p-6 ticket-print">
            <div class="no-print flex flex-wrap gap-2 justify-end mb-4">
                <button type="button" onclick="window.print()"
                    class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 text-sm">
                    Imprimir
                </button>
                <a href="{{ route('sales.create') }}"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    Nueva Venta
                </a>
                <a href="{{ route('sales.index') }}"
                    class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 text-sm">
                    Volver a Ventas
                </a>
            </div>

            <div class="text-center border-b pb-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Salón de Belleza</h1>
                <p class="text-sm text-gray-500">Ticket de venta</p>
            </div>

            <div class="grid grid-cols-2 gap-3 text-sm mb-4">
                <div>
                    <span class="text-gray-500">Número de venta:</span>
                    <span class="ml-2 font-semibold">{{ $sale->number }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Fecha:</span>
                    <span class="ml-2 font-semibold">{{ $sale->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Cajero:</span>
                    <span class="ml-2 font-semibold">{{ $sale->user_name }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Cliente:</span>
                    <span class="ml-2 font-semibold">{{ $sale->customer->name ?? 'Sin cliente' }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Pago:</span>
                    <span class="ml-2 font-semibold capitalize">{{ $sale->payment_method }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Estado:</span>
                    @if($sale->status === 'activa')
                        <span class="ml-2 inline-flex items-center bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Activa</span>
                    @else
                        <span class="ml-2 inline-flex items-center bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">ANULADA</span>
                    @endif
                </div>
            </div>

            <div class="border rounded-lg overflow-hidden mb-4">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3 text-gray-600">Producto / Servicio</th>
                            <th class="px-4 py-3 text-gray-600">Cant.</th>
                            <th class="px-4 py-3 text-gray-600">Precio</th>
                            <th class="px-4 py-3 text-gray-600">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $item->product_name }}</td>
                                <td class="px-4 py-3">{{ $item->quantity }}</td>
                                <td class="px-4 py-3">{{ number_format($item->price, 2) }} Bs</td>
                                <td class="px-4 py-3">{{ number_format($item->price * $item->quantity, 2) }} Bs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 text-sm">
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-gray-500">Subtotal</p>
                    <p class="font-semibold text-gray-900">{{ number_format($sale->subtotal ?? $sale->total, 2) }} Bs</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-gray-500">Descuento aplicado</p>
                    <p class="font-semibold text-gray-900">{{ number_format($sale->discount_percentage ?? 0, 2) }}%</p>
                </div>
                <div class="p-4 rounded-lg bg-gray-50">
                    <p class="text-gray-500">Monto descontado</p>
                    <p class="font-semibold text-gray-900">{{ number_format($sale->discount_amount ?? 0, 2) }} Bs</p>
                </div>
                <div class="p-4 rounded-lg bg-blue-50">
                    <p class="text-blue-700">Total final pagado</p>
                    <p class="text-xl font-bold text-blue-800">{{ number_format($sale->total, 2) }} Bs</p>
                </div>
            </div>

            <div class="text-center text-sm border-t pt-3 mb-4">
                <p class="text-gray-700">------------------</p>
                <p class="text-gray-700">Gracias por su preferencia</p>
                <p class="text-gray-700">¡Vuelva pronto!</p>
                <p class="text-gray-700">------------------</p>
            </div>
        </div>
    </div>

    <style>
        @media print {
            @page {
                size: auto;
                margin: 8mm;
            }

            html,
            body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            body > div.min-h-screen > :not(main),
            .no-print {
                display: none !important;
            }

            main {
                padding: 0 !important;
                margin: 0 !important;
            }

            .ticket-page {
                max-width: none !important;
                width: 100% !important;
                padding: 0 !important;
                margin: 0 auto !important;
            }

            .ticket-print {
                width: 320px !important;
                max-width: 80mm !important;
                min-width: 0 !important;
                margin: 0 auto !important;
                padding: 10px !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                border: none !important;
                position: relative;
                box-sizing: border-box !important;
                font-size: 11px !important;
                line-height: 1.25 !important;
                color: #111827 !important;
            }

            .ticket-print * {
                box-sizing: border-box !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .ticket-print h1 {
                font-size: 17px !important;
                line-height: 1.15 !important;
                margin: 0 0 2px !important;
            }

            .ticket-print p,
            .ticket-print span {
                font-size: 11px !important;
                line-height: 1.25 !important;
            }

            .ticket-print > div {
                margin-bottom: 8px !important;
            }

            .ticket-print > div:first-of-type {
                display: none !important;
            }

            .ticket-print .text-center {
                padding-bottom: 7px !important;
                margin-bottom: 7px !important;
            }

            .ticket-print .grid {
                gap: 4px 6px !important;
                margin-bottom: 8px !important;
            }

            .ticket-print .ml-2 {
                margin-left: 3px !important;
            }

            .ticket-print .rounded-lg,
            .ticket-print .rounded {
                border-radius: 2px !important;
            }

            .ticket-print .border.rounded-lg.overflow-hidden {
                margin-bottom: 8px !important;
            }

            .ticket-print table {
                width: 100% !important;
                table-layout: fixed !important;
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            .ticket-print th,
            .ticket-print td {
                padding: 4px 3px !important;
                font-size: 10px !important;
                line-height: 1.2 !important;
                vertical-align: top !important;
                word-break: break-word !important;
            }

            .ticket-print th:nth-child(1),
            .ticket-print td:nth-child(1) {
                width: 43% !important;
            }

            .ticket-print th:nth-child(2),
            .ticket-print td:nth-child(2) {
                width: 13% !important;
                text-align: center !important;
            }

            .ticket-print th:nth-child(3),
            .ticket-print td:nth-child(3),
            .ticket-print th:nth-child(4),
            .ticket-print td:nth-child(4) {
                width: 22% !important;
                text-align: right !important;
            }

            .ticket-print .p-4 {
                padding: 6px !important;
            }

            .ticket-print .text-xl {
                font-size: 15px !important;
                line-height: 1.15 !important;
            }

            .ticket-print .flex.justify-between {
                padding-top: 6px !important;
                margin-bottom: 0 !important;
                gap: 6px !important;
            }
        }
    </style>
</x-app-layout>
