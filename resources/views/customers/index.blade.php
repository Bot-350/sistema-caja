<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
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

        {{-- Botón agregar --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('customers.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Cliente
            </a>
        </div>

        {{-- Lista de clientes --}}
        <div class="bg-white rounded-lg shadow">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-gray-600">#</th>
                        <th class="px-6 py-3 text-gray-600">Nombre</th>
                        <th class="px-6 py-3 text-gray-600">Teléfono</th>
                        <th class="px-6 py-3 text-gray-600">Correo</th>
                        <th class="px-6 py-3 text-gray-600">Cumpleaños</th>
                        <th class="px-6 py-3 text-gray-600">Visitas</th>
                        <th class="px-6 py-3 text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $customer->id }}</td>
                        <td class="px-6 py-3">{{ $customer->name }}</td>
                        <td class="px-6 py-3">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $customer->email ?? '-' }}</td>
                        <td class="px-6 py-3">
                            {{ $customer->birthday ? $customer->birthday->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-3">{{ $customer->visit_count }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="{{ route('customers.show', $customer) }}"
                                class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 text-sm">
                                Ver
                            </a>
                            <a href="{{ route('customers.edit', $customer) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                                Editar
                            </a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este cliente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-400">
                            No hay clientes registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>