<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-malba-gray-dark md:text-3xl">
            Clientes
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

        {{-- Botón agregar --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('customers.create') }}"
                class="inline-flex items-center rounded-full bg-malba-rose-pale px-5 py-2.5 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                + Nuevo Cliente
            </a>
        </div>

        {{-- Lista de clientes --}}
        <div class="overflow-hidden rounded-2xl border border-malba-gray-lighter bg-white shadow-elegant-lg">
            <table class="w-full text-left">
                <thead class="bg-malba-rose-pale/20">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">#</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Nombre</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Teléfono</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Correo</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Cumpleaños</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Visitas</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr class="border-b border-malba-gray-lighter transition-colors hover:bg-malba-gray-light">
                        <td class="px-6 py-3 text-sm text-malba-gray-medium">{{ $customer->id }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-malba-gray-dark">{{ $customer->name }}</td>
                        <td class="px-6 py-3 text-sm text-malba-gray-dark">{{ $customer->phone ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-malba-gray-dark">{{ $customer->email ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-malba-gray-dark">
                            {{ $customer->birthday ? $customer->birthday->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-3 text-sm font-semibold text-malba-gray-dark">{{ $customer->visit_count }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="{{ route('customers.show', $customer) }}"
                                class="inline-flex items-center rounded-full bg-blue-600 px-3 py-1.5 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-blue-700 hover:shadow-elegant-lg">
                                Ver
                            </a>
                            <a href="{{ route('customers.edit', $customer) }}"
                                class="inline-flex items-center rounded-full bg-malba-rose-pale px-3 py-1.5 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                                Editar
                            </a>
                            <form action="{{ route('customers.destroy', $customer) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este cliente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center rounded-full bg-red-500 px-3 py-1.5 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-red-600 hover:shadow-elegant-lg">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-sm text-malba-gray-medium">
                            No hay clientes registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>