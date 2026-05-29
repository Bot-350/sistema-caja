<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Caja
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">

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
                        <span class="font-medium">{{ number_format($cashRegister->opening_amount, 2) }} Bs</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Ventas en efectivo</span>
                        <span class="font-medium text-green-600">+ {{ number_format($ventasEfectivo, 2) }} Bs</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b">
                        <span class="text-gray-600">Ventas en QR</span>
                        <span class="font-medium text-blue-600">+ {{ number_format($ventasQr, 2) }} Bs</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="font-semibold text-lg">Saldo actual</span>
                        <span class="font-bold text-2xl text-gray-800">{{ number_format($saldoActual, 2) }} Bs</span>
                    </div>
                </div>
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