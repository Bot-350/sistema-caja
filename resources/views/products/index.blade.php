<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Productos
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
            <a href="{{ route('products.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Nuevo Producto
            </a>
        </div>

        {{-- Lista de productos --}}
        <div class="bg-white rounded-lg shadow">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-gray-600">#</th>
                        <th class="px-6 py-3 text-gray-600">Nombre</th>
                        <th class="px-6 py-3 text-gray-600">Marca</th>
                        <th class="px-6 py-3 text-gray-600">Categoría</th>
                        <th class="px-6 py-3 text-gray-600">Precio</th>
                        <th class="px-6 py-3 text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $product->id }}</td>
                        <td class="px-6 py-3">{{ $product->name }}</td>
                        <td class="px-6 py-3">{{ $product->brand ?? '-' }}</td>
                        <td class="px-6 py-3">{{ $product->category->name }}</td>
                        <td class="px-6 py-3">{{ number_format($product->price, 2) }} Bs</td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="{{ route('products.edit', $product) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                                Editar
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este producto?')">
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
                        <td colspan="6" class="px-6 py-4 text-center text-gray-400">
                            No hay productos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>