<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Caja
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

        @if($summaryCashRegister)
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900">Resumen del Día</h3>
                        <p class="text-sm text-gray-500">Resumen operativo de caja y movimientos registrados</p>
                    </div>
                    @if($summaryCashRegister->status === 'abierta')
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">Caja Abierta</span>
                    @else
                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-medium">Caja Cerrada</span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Fecha actual</p>
                        <p class="font-semibold text-gray-900">{{ now()->format('d/m/Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Hora de apertura</p>
                        <p class="font-semibold text-gray-900">{{ $summaryCashRegister->opened_at ? $summaryCashRegister->opened_at->format('H:i') : '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Hora de cierre</p>
                        <p class="font-semibold text-gray-900">{{ $summaryCashRegister->closed_at ? $summaryCashRegister->closed_at->format('H:i') : '-' }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-sm text-gray-500">Usuario responsable</p>
                        <p class="font-semibold text-gray-900">{{ $summaryCashRegister->user->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Monto inicial</p>
                        <p class="font-semibold text-gray-900">{{ number_format($saldoInicial, 2) }} Bs</p>
                    </div>
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Ventas en efectivo</p>
                        <p class="font-semibold text-green-700">{{ number_format($ventasEfectivo, 2) }} Bs</p>
                    </div>
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Ventas por QR</p>
                        <p class="font-semibold text-blue-700">{{ number_format($ventasQr, 2) }} Bs</p>
                    </div>
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Ingresos manuales</p>
                        <p class="font-semibold text-green-700">{{ number_format($ingresosManuales, 2) }} Bs</p>
                    </div>
                    <div class="bg-white border rounded-lg p-4">
                        <p class="text-sm text-gray-500">Egresos manuales</p>
                        <p class="font-semibold text-red-700">{{ number_format($egresosManuales, 2) }} Bs</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-sm text-green-700">Total ingresos</p>
                        <p class="text-2xl font-bold text-green-800">{{ number_format($totalIngresos, 2) }} Bs</p>
                    </div>
                    <div class="bg-red-50 rounded-lg p-4">
                        <p class="text-sm text-red-700">Total egresos</p>
                        <p class="text-2xl font-bold text-red-800">{{ number_format($totalEgresos, 2) }} Bs</p>
                    </div>
                    <div class="bg-blue-50 rounded-lg p-4">
                        <p class="text-sm text-blue-700">Saldo actual</p>
                        <p class="text-2xl font-bold text-blue-800">{{ number_format($saldoActual, 2) }} Bs</p>
                    </div>
                </div>
            </div>
        @endif

        @if($cashRegister)
            {{-- Caja abierta --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                    <h3 class="text-lg font-semibold text-green-600">Caja Abierta</h3>
                    <span class="text-gray-400 text-sm ml-auto">
                        Desde: {{ $cashRegister->opened_at->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Monto inicial</span>
                        <span class="font-medium">{{ number_format($saldoInicial, 2) }} Bs</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Ventas en efectivo</span>
                        <span class="font-medium text-green-600">+ {{ number_format($ventasEfectivo, 2) }} Bs</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Ventas en QR</span>
                        <span class="font-medium text-blue-600">+ {{ number_format($ventasQr, 2) }} Bs</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Ingresos manuales</span>
                        <span class="font-medium text-green-600">+ {{ number_format($ingresosManuales, 2) }} Bs</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Egresos manuales</span>
                        <span class="font-medium text-red-600">- {{ number_format($egresosManuales, 2) }} Bs</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="font-semibold text-lg">Saldo actual</span>
                        <span class="font-bold text-2xl text-gray-800">{{ number_format($saldoActual, 2) }} Bs</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-green-700">Registrar ingreso manual</h3>
                    <form action="{{ route('cash.movements.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="ingreso">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Monto</label>
                            <input type="number" name="amount" value="{{ old('amount') }}"
                                class="border rounded px-3 py-2 w-full" step="0.01" min="0.01" required />
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Motivo</label>
                            <input type="text" name="reason" value="{{ old('reason') }}"
                                class="border rounded px-3 py-2 w-full" maxlength="255" required />
                            @error('reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="bg-green-600 text-white px-4 py-3 rounded-lg w-full font-semibold hover:bg-green-700 text-lg">
                            Registrar Ingreso
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold mb-4 text-red-700">Registrar egreso manual</h3>
                    <form action="{{ route('cash.movements.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="egreso">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Monto</label>
                            <input type="number" name="amount" value="{{ old('amount') }}"
                                class="border rounded px-3 py-2 w-full" step="0.01" min="0.01" required />
                            @error('amount')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-1">Motivo</label>
                            <input type="text" name="reason" value="{{ old('reason') }}"
                                class="border rounded px-3 py-2 w-full" maxlength="255" required />
                            @error('reason')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="bg-red-600 text-white px-4 py-3 rounded-lg w-full font-semibold hover:bg-red-700 text-lg">
                            Registrar Egreso
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Historial de movimientos</h3>
                @if($movements->isEmpty())
                    <p class="text-center text-gray-400 py-6">No hay movimientos registrados en esta caja.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-gray-600">Fecha</th>
                                    <th class="px-4 py-3 text-gray-600">Tipo</th>
                                    <th class="px-4 py-3 text-gray-600">Monto</th>
                                    <th class="px-4 py-3 text-gray-600">Motivo</th>
                                    <th class="px-4 py-3 text-gray-600">Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movements as $movement)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 text-gray-700">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3">
                                            @if($movement->type === 'ingreso')
                                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-medium">Ingreso</span>
                                            @else
                                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-medium">Egreso</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-medium {{ $movement->type === 'ingreso' ? 'text-green-700' : 'text-red-700' }}">
                                            {{ number_format($movement->amount, 2) }} Bs
                                        </td>
                                        <td class="px-4 py-3 text-gray-700">{{ $movement->reason }}</td>
                                        <td class="px-4 py-3 text-gray-700">{{ $movement->user->name ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Botón cerrar caja --}}
            <form action="{{ route('cash.close') }}" method="POST"
                onsubmit="return confirm('¿Estás seguro de cerrar la caja?')">
                @csrf
                <button type="submit"
                    class="bg-red-500 text-white px-4 py-3 rounded-lg w-full font-semibold hover:bg-red-600 text-lg">
                    Cerrar Caja
                </button>
            </form>

        @else
            {{-- Caja cerrada --}}
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                    <h3 class="text-lg font-semibold text-red-600">Caja Cerrada</h3>
                </div>
                <p class="text-gray-400 text-center py-4">No hay una caja abierta en este momento.</p>
            </div>

            {{-- Formulario abrir caja --}}
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold mb-4">Abrir Caja</h3>
                <form action="{{ route('cash.open') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Monto inicial</label>
                        <input type="number" name="opening_amount" value="{{ old('opening_amount', 0) }}"
                            class="border rounded px-3 py-2 w-full" step="0.01" min="0" required />
                        @error('opening_amount')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="bg-green-600 text-white px-4 py-3 rounded-lg w-full font-semibold hover:bg-green-700 text-lg">
                        Abrir Caja
                    </button>
                </form>
            </div>

        @endif

    </div>
</x-app-layout>