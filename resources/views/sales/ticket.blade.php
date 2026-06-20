<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-malba-gray-dark md:text-3xl no-print">
            Ticket de Venta
        </h2>
    </x-slot>

    <div class="ticket-page py-6 max-w-2xl mx-auto px-4">
        <div class="ticket-print rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
            <div class="no-print mb-4 flex flex-wrap justify-end gap-2">
                <button type="button" onclick="window.print()"
                    class="rounded-full bg-malba-rose-pale px-4 py-2 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                    Imprimir
                </button>
                <a href="{{ route('sales.create') }}"
                    class="rounded-full bg-malba-rose-pale px-4 py-2 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                    Nueva Venta
                </a>
                <a href="{{ route('sales.index') }}"
                    class="rounded-full border border-malba-gray-lighter bg-white px-4 py-2 text-sm font-semibold text-malba-gray-dark shadow-elegant transition-all duration-200 hover:border-malba-rose-pale hover:text-malba-rose-dark hover:shadow-elegant-lg">
                    Volver a Ventas
                </a>
            </div>

            <div class="ticket-header text-center border-b border-malba-gray-lighter pb-4 mb-4">
                <p class="text-xs font-semibold tracking-[0.35em] text-malba-gray-medium">MALBA</p>
                <h1 class="mt-1 text-xl font-bold tracking-[0.2em] text-malba-gray-dark">THE BEAUTY HOUSE</h1>
                <p class="mt-2 text-sm font-medium text-malba-rose-dark">Sistema de Control de Ventas</p>
            </div>

            <div class="grid grid-cols-1 gap-2 text-sm mb-4">
                <div class="flex justify-between gap-3 border-b border-dotted border-malba-gray-lighter pb-2">
                    <span class="text-malba-gray-medium">N° Ticket</span>
                    <span class="font-semibold text-malba-gray-dark">{{ $sale->number }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-dotted border-malba-gray-lighter pb-2">
                    <span class="text-malba-gray-medium">Fecha</span>
                    <span class="font-semibold text-malba-gray-dark">{{ $sale->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-dotted border-malba-gray-lighter pb-2">
                    <span class="text-malba-gray-medium">Hora</span>
                    <span class="font-semibold text-malba-gray-dark">{{ $sale->created_at->format('H:i') }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-dotted border-malba-gray-lighter pb-2">
                    <span class="text-malba-gray-medium">Cajero</span>
                    <span class="font-semibold text-malba-gray-dark text-right">{{ $sale->user_name }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-malba-gray-medium">Cliente</span>
                    <span class="font-semibold text-malba-gray-dark text-right">{{ $sale->customer->name ?? 'Sin cliente' }}</span>
                </div>
            </div>

            <div class="mb-4 overflow-hidden rounded-xl border border-malba-gray-lighter">
                <table class="w-full text-left text-sm">
                    <thead class="bg-malba-rose-pale/20 border-b border-malba-gray-lighter">
                        <tr>
                            <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Producto</th>
                            <th class="px-2 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark text-center">Cantidad</th>
                            <th class="px-2 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark text-right">Precio</th>
                            <th class="px-3 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sale->items as $item)
                            <tr class="border-b border-malba-gray-lighter">
                                <td class="px-3 py-3 align-top text-malba-gray-dark">{{ $item->product_name }}</td>
                                <td class="px-2 py-3 align-top text-center text-malba-gray-dark">{{ $item->quantity }}</td>
                                <td class="px-2 py-3 align-top text-right text-malba-gray-dark">{{ number_format($item->price, 2) }} Bs</td>
                                <td class="px-3 py-3 align-top text-right text-malba-gray-dark">{{ number_format($item->price * $item->quantity, 2) }} Bs</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 gap-2 mb-4 text-sm">
                <div class="flex justify-between gap-3 border-b border-dotted border-malba-gray-lighter pb-2">
                    <p class="text-malba-gray-medium">Subtotal</p>
                    <p class="font-semibold text-malba-gray-dark">{{ number_format($sale->subtotal ?? $sale->total, 2) }} Bs</p>
                </div>
                <div class="flex justify-between gap-3 border-b border-dotted border-malba-gray-lighter pb-2">
                    <p class="text-malba-gray-medium">Descuento</p>
                    <p class="font-semibold text-malba-gray-dark">{{ number_format($sale->discount_percentage ?? 0, 2) }}%</p>
                </div>
                <div class="flex justify-between gap-3 border-b border-dotted border-malba-gray-lighter pb-2">
                    <p class="text-malba-gray-medium">Monto descontado</p>
                    <p class="font-semibold text-malba-gray-dark">{{ number_format($sale->discount_amount ?? 0, 2) }} Bs</p>
                </div>
                <div class="rounded-xl border border-malba-rose-pale bg-malba-rose-pale/10 px-4 py-3">
                    <div class="flex justify-between gap-3">
                        <p class="font-semibold text-malba-rose-dark">TOTAL</p>
                        <p class="text-xl font-bold text-malba-rose-dark">{{ number_format($sale->total, 2) }} Bs</p>
                    </div>
                </div>
            </div>

            <div class="text-center text-sm border-t border-malba-gray-lighter pt-3 mb-4">
                <p class="text-malba-gray-dark">Método de pago</p>
                <p class="mt-1 font-semibold capitalize text-malba-gray-dark">{{ $sale->payment_method }}</p>
                <p class="mt-3 text-malba-gray-medium">Gracias por su visita</p>
                <p class="font-semibold tracking-[0.2em] text-malba-gray-dark">MALBA THE BEAUTY HOUSE</p>
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
                width: 80mm !important;
                max-width: 80mm !important;
                min-width: 0 !important;
                margin: 0 auto !important;
                padding: 6mm 5mm !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                border: none !important;
                position: relative;
                box-sizing: border-box !important;
                font-size: 10px !important;
                line-height: 1.2 !important;
                color: #111827 !important;
            }

            .ticket-print * {
                box-sizing: border-box !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .ticket-print [class*="text-"] {
                color: #111827 !important;
            }

            .ticket-print .text-malba-gray-medium,
            .ticket-print .text-gray-400,
            .ticket-print .text-gray-500,
            .ticket-print .text-gray-600 {
                color: #6b7280 !important;
            }

            .ticket-print .text-malba-rose-dark,
            .ticket-print .text-malba-rose-pale {
                color: #b54a57 !important;
            }

            .ticket-print .text-malba-gray-dark,
            .ticket-print .text-gray-700,
            .ticket-print .text-gray-800,
            .ticket-print .text-gray-900 {
                color: #111827 !important;
            }

            .ticket-print .bg-white,
            .ticket-print .bg-malba-rose-pale\/10,
            .ticket-print .bg-malba-rose-pale\/20 {
                background-color: transparent !important;
            }

            .ticket-print .border-malba-gray-lighter,
            .ticket-print .border-dotted,
            .ticket-print .border-b,
            .ticket-print .border-malba-rose-pale {
                border-color: #d1d5db !important;
            }

            .ticket-print thead,
            .ticket-print .bg-malba-rose-pale\/20 {
                background-color: transparent !important;
            }

            .ticket-print h1 {
                font-size: 14px !important;
                line-height: 1.15 !important;
                margin: 0 0 2px !important;
            }

            .ticket-print p,
            .ticket-print span {
                font-size: 10px !important;
                line-height: 1.2 !important;
            }

            .ticket-print > div {
                margin-bottom: 6px !important;
            }

            .ticket-print .text-center {
                padding-bottom: 5px !important;
                margin-bottom: 5px !important;
            }

            .ticket-print .grid {
                gap: 4px 6px !important;
                margin-bottom: 6px !important;
            }

            .ticket-print .ml-2 {
                margin-left: 3px !important;
            }

            .ticket-print .rounded-lg,
            .ticket-print .rounded {
                border-radius: 2px !important;
            }

            .ticket-print .border.rounded-lg.overflow-hidden {
                margin-bottom: 6px !important;
            }

            .ticket-print table {
                width: 100% !important;
                table-layout: fixed !important;
                font-size: 9px !important;
                line-height: 1.15 !important;
            }

            .ticket-print th,
            .ticket-print td {
                padding: 3px 2px !important;
                font-size: 9px !important;
                line-height: 1.15 !important;
                vertical-align: top !important;
                word-break: break-word !important;
            }

            .ticket-print th:nth-child(1),
            .ticket-print td:nth-child(1) {
                width: 46% !important;
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
                width: 20% !important;
                text-align: right !important;
            }

            .ticket-print .p-4 {
                padding: 5px !important;
            }

            .ticket-print .text-xl {
                font-size: 13px !important;
                line-height: 1.15 !important;
            }

            .ticket-print .flex.justify-between {
                padding-top: 4px !important;
                margin-bottom: 0 !important;
                gap: 4px !important;
            }
        }
    </style>
</x-app-layout>
