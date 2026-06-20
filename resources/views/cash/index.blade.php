<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-malba-gray-dark md:text-3xl dark:text-gray-100">
            Caja
        </h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto px-4">

        {{-- Mensajes --}}
        @if(session('success'))
            <div class="mb-4 rounded-xl border border-malba-gray-lighter bg-white px-4 py-3 text-malba-gray-dark shadow-elegant">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-xl border border-malba-gray-lighter bg-white px-4 py-3 text-malba-gray-dark shadow-elegant">
                {{ session('error') }}
            </div>
        @endif

        @if($summaryCashRegister)
            <div class="mb-6 rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <h3 class="text-xl font-semibold text-malba-gray-dark">Resumen del Día</h3>
                        <p class="text-sm text-malba-gray-medium">Resumen operativo de caja y movimientos registrados</p>
                    </div>
                    @if($summaryCashRegister->status === 'abierta')
                        <span class="inline-flex items-center rounded-full border border-green-200 bg-green-50 px-3 py-1 text-sm font-semibold text-green-700">Caja Abierta</span>
                    @else
                        <span class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-3 py-1 text-sm font-semibold text-red-700">Caja Cerrada</span>
                    @endif
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <div class="rounded-2xl border border-malba-gray-lighter bg-malba-gray-light p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Fecha actual</p>
                        <p class="font-semibold text-malba-gray-dark">{{ now()->format('d/m/Y') }}</p>
                    </div>
                    <div class="rounded-2xl border border-malba-gray-lighter bg-malba-gray-light p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Hora de apertura</p>
                        <p class="font-semibold text-malba-gray-dark">{{ $summaryCashRegister->opened_at ? $summaryCashRegister->opened_at->format('H:i') : '-' }}</p>
                    </div>
                    <div class="rounded-2xl border border-malba-gray-lighter bg-malba-gray-light p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Hora de cierre</p>
                        <p class="font-semibold text-malba-gray-dark">{{ $summaryCashRegister->closed_at ? $summaryCashRegister->closed_at->format('H:i') : '-' }}</p>
                    </div>
                    <div class="rounded-2xl border border-malba-gray-lighter bg-malba-gray-light p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Usuario responsable</p>
                        <p class="font-semibold text-malba-gray-dark">{{ $summaryCashRegister->user->name ?? '-' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                    <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Monto inicial</p>
                        <p class="font-semibold text-malba-gray-dark">{{ number_format($saldoInicial, 2) }} Bs</p>
                    </div>
                    <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Ventas en efectivo</p>
                        <p class="font-semibold text-green-700">{{ number_format($ventasEfectivo, 2) }} Bs</p>
                    </div>
                    <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Ventas por QR</p>
                        <p class="font-semibold text-malba-rose-dark">{{ number_format($ventasQr, 2) }} Bs</p>
                    </div>
                    <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Ingresos manuales</p>
                        <p class="font-semibold text-green-700">{{ number_format($ingresosManuales, 2) }} Bs</p>
                    </div>
                    <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                        <p class="text-sm text-malba-gray-medium">Egresos manuales</p>
                        <p class="font-semibold text-red-700">{{ number_format($egresosManuales, 2) }} Bs</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="rounded-2xl border border-green-200 bg-green-50 p-4 shadow-elegant">
                        <p class="text-sm font-medium text-green-700">Total ingresos</p>
                        <p class="text-2xl font-bold text-green-800">{{ number_format($totalIngresos, 2) }} Bs</p>
                    </div>
                    <div class="rounded-2xl border border-red-200 bg-red-50 p-4 shadow-elegant">
                        <p class="text-sm font-medium text-red-700">Total egresos</p>
                        <p class="text-2xl font-bold text-red-800">{{ number_format($totalEgresos, 2) }} Bs</p>
                    </div>
                    <div class="rounded-2xl border border-malba-gray-lighter bg-white p-4 shadow-elegant">
                        <p class="text-sm font-medium text-malba-gray-medium">Saldo actual</p>
                        <p class="text-2xl font-bold text-malba-rose-dark">{{ number_format($saldoActual, 2) }} Bs</p>
                    </div>
                </div>
            </div>
        @endif

        @if($cashRegister)
            {{-- Caja abierta --}}
            <div class="mb-6 rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
                <div class="flex items-center gap-3 mb-6">
                    <span class="inline-block h-3 w-3 rounded-full bg-green-500"></span>
                    <h3 class="text-lg font-semibold text-green-700">Caja Abierta</h3>
                    <span class="ml-auto text-sm text-malba-gray-medium">
                        Desde: {{ $cashRegister->opened_at->format('d/m/Y H:i') }}
                    </span>
                </div>

                <div class="space-y-3">
                    <div class="flex items-center justify-between py-3 border-b border-malba-gray-lighter">
                        <span class="text-malba-gray-dark">Monto inicial</span>
                        <span class="font-medium text-malba-gray-dark">{{ number_format($saldoInicial, 2) }} Bs</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-malba-gray-lighter">
                        <span class="text-malba-gray-dark">Ventas en efectivo</span>
                        <span class="font-medium text-green-600">+ {{ number_format($ventasEfectivo, 2) }} Bs</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-malba-gray-lighter">
                        <span class="text-malba-gray-dark">Ventas en QR</span>
                        <span class="font-medium text-malba-rose-dark">+ {{ number_format($ventasQr, 2) }} Bs</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-malba-gray-lighter">
                        <span class="text-malba-gray-dark">Ingresos manuales</span>
                        <span class="font-medium text-green-600">+ {{ number_format($ingresosManuales, 2) }} Bs</span>
                    </div>
                    <div class="flex items-center justify-between py-3 border-b border-malba-gray-lighter">
                        <span class="text-malba-gray-dark">Egresos manuales</span>
                        <span class="font-medium text-red-600">- {{ number_format($egresosManuales, 2) }} Bs</span>
                    </div>
                    <div class="flex items-center justify-between py-3">
                        <span class="text-lg font-semibold text-malba-gray-dark">Saldo actual</span>
                        <span class="text-2xl font-bold text-malba-rose-dark">{{ number_format($saldoActual, 2) }} Bs</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
                    <h3 class="mb-4 text-lg font-semibold text-green-700">Registrar ingreso manual</h3>
                    <form action="{{ route('cash.movements.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="ingreso">
                        <div class="mb-4">
                            <label class="mb-1 block font-medium text-malba-gray-dark">Monto</label>
                            <input type="number" name="amount" value="{{ old('amount') }}"
                                class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" step="0.01" min="0.01" required />
                            @error('amount')
                                <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="mb-1 block font-medium text-malba-gray-dark">Motivo</label>
                            <input type="text" name="reason" value="{{ old('reason') }}"
                                class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" maxlength="255" required />
                            @error('reason')
                                <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-full bg-malba-rose-pale px-4 py-3 text-lg font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                            Registrar Ingreso
                        </button>
                    </form>
                </div>

                <div class="rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
                    <h3 class="mb-4 text-lg font-semibold text-red-700">Registrar egreso manual</h3>
                    <form action="{{ route('cash.movements.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="egreso">
                        <div class="mb-4">
                            <label class="mb-1 block font-medium text-malba-gray-dark">Monto</label>
                            <input type="number" name="amount" value="{{ old('amount') }}"
                                class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" step="0.01" min="0.01" required />
                            @error('amount')
                                <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="mb-1 block font-medium text-malba-gray-dark">Motivo</label>
                            <input type="text" name="reason" value="{{ old('reason') }}"
                                class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" maxlength="255" required />
                            @error('reason')
                                <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                            class="inline-flex w-full items-center justify-center rounded-full bg-red-500 px-4 py-3 text-lg font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-red-600 hover:shadow-elegant-lg">
                            Registrar Egreso
                        </button>
                    </form>
                </div>
            </div>

            <div class="mb-6 rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
                <h3 class="mb-4 text-lg font-semibold text-malba-gray-dark">Historial de movimientos</h3>
                @if($movements->isEmpty())
                    <p class="py-6 text-center text-malba-gray-medium">No hay movimientos registrados en esta caja.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="border-b border-malba-gray-lighter bg-malba-rose-pale/20">
                                <tr>
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Fecha</th>
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Tipo</th>
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Monto</th>
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Motivo</th>
                                    <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($movements as $movement)
                                    <tr class="border-b border-malba-gray-lighter transition-colors hover:bg-malba-gray-light">
                                        <td class="px-4 py-3 text-malba-gray-dark">{{ $movement->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="px-4 py-3">
                                            @if($movement->type === 'ingreso')
                                                <span class="inline-flex items-center rounded-full border border-green-200 bg-green-50 px-2 py-1 text-xs font-semibold text-green-700">Ingreso</span>
                                            @else
                                                <span class="inline-flex items-center rounded-full border border-red-200 bg-red-50 px-2 py-1 text-xs font-semibold text-red-700">Egreso</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-medium {{ $movement->type === 'ingreso' ? 'text-green-700' : 'text-red-700' }}">
                                            {{ number_format($movement->amount, 2) }} Bs
                                        </td>
                                        <td class="px-4 py-3 text-malba-gray-dark">{{ $movement->reason }}</td>
                                        <td class="px-4 py-3 text-malba-gray-dark">{{ $movement->user->name ?? '-' }}</td>
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
                    class="inline-flex w-full items-center justify-center rounded-full bg-red-500 px-4 py-3 text-lg font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-red-600 hover:shadow-elegant-lg">
                    Cerrar Caja
                </button>
            </form>

        @else
            {{-- Caja cerrada --}}
            <div class="mb-6 rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
                <div class="flex items-center gap-3 mb-6">
                    <span class="inline-block h-3 w-3 rounded-full bg-red-500"></span>
                    <h3 class="text-lg font-semibold text-red-700">Caja Cerrada</h3>
                </div>
                <p class="py-4 text-center text-malba-gray-medium">No hay una caja abierta en este momento.</p>
            </div>

            {{-- Formulario abrir caja --}}
            <div class="rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
                <h3 class="mb-4 text-lg font-semibold text-malba-gray-dark">Abrir Caja</h3>
                <form action="{{ route('cash.open') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="mb-1 block font-medium text-malba-gray-dark">Monto inicial</label>
                        <input type="number" name="opening_amount" value="{{ old('opening_amount', 0) }}"
                            class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" step="0.01" min="0" required />
                        @error('opening_amount')
                            <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit"
                        class="inline-flex w-full items-center justify-center rounded-full bg-malba-rose-pale px-4 py-3 text-lg font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                        Abrir Caja
                    </button>
                </form>
            </div>

        @endif

    </div>
</x-app-layout>