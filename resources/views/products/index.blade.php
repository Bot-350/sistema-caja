<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-malba-gray-dark md:text-3xl">
            Productos
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
            <a href="{{ route('products.create') }}"
                class="inline-flex items-center rounded-full bg-malba-rose-pale px-5 py-2.5 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                Nuevo Producto
            </a>
        </div>

        {{-- Lista de productos --}}
        <div class="overflow-hidden rounded-2xl border border-malba-gray-lighter bg-white shadow-elegant-lg">
            <table class="w-full text-left">
                <thead class="bg-malba-rose-pale/20">
                    <tr>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">#</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Nombre</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Marca</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Categoría</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Precio</th>
                        <th class="px-6 py-3 text-xs font-semibold uppercase tracking-wider text-malba-gray-dark">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr class="border-b border-malba-gray-lighter transition-colors hover:bg-malba-gray-light">
                        <td class="px-6 py-3 text-sm text-malba-gray-medium">{{ $product->id }}</td>
                        <td class="px-6 py-3 text-sm font-medium text-malba-gray-dark">{{ $product->name }}</td>
                        <td class="px-6 py-3 text-sm text-malba-gray-dark">{{ $product->brand ?? '-' }}</td>
                        <td class="px-6 py-3 text-sm text-malba-gray-dark">{{ $product->category->name }}</td>
                        <td class="px-6 py-3 text-sm font-semibold text-malba-gray-dark">{{ number_format($product->price, 2) }} Bs</td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="{{ route('products.edit', $product) }}"
                                class="inline-flex items-center rounded-full bg-malba-rose-pale px-3 py-1.5 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                                Editar
                            </a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este producto?')">
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
                        <td colspan="6" class="px-6 py-6 text-center text-sm text-malba-gray-medium">
                            No hay productos registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>