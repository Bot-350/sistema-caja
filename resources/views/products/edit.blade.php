<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Producto
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('products.update', $product) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}"
                        class="border rounded px-3 py-2 w-full" required />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Marca --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Marca</label>
                    <input type="text" name="brand" value="{{ old('brand', $product->brand) }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('brand')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Precio --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Precio</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}"
                        class="border rounded px-3 py-2 w-full" step="0.01" min="0" required />
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categoría --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Categoría</label>
                    <select name="category_id" class="border rounded px-3 py-2 w-full" required>
                        <option value="">Seleccionar categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('products.index') }}"
                        class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Actualizar
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>