<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight tracking-tight text-malba-gray-dark md:text-3xl">
            Nuevo Producto
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">

        <div class="rounded-2xl border border-malba-gray-lighter bg-white p-6 shadow-elegant-lg">
            <form action="{{ route('products.store') }}" method="POST">
                @csrf

                {{-- Nombre --}}
                <div class="mb-4">
                    <label class="mb-1 block font-medium text-malba-gray-dark">Nombre</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 placeholder:text-malba-gray-medium focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" required />
                    @error('name')
                        <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Marca --}}
                <div class="mb-4">
                    <label class="mb-1 block font-medium text-malba-gray-dark">Marca</label>
                    <input type="text" name="brand" value="{{ old('brand') }}"
                        class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 placeholder:text-malba-gray-medium focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" />
                    @error('brand')
                        <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Precio --}}
                <div class="mb-4">
                    <label class="mb-1 block font-medium text-malba-gray-dark">Precio</label>
                    <input type="number" name="price" value="{{ old('price') }}"
                        class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 placeholder:text-malba-gray-medium focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" step="0.01" min="0" required />
                    @error('price')
                        <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Categoría --}}
                <div class="mb-6">
                    <label class="mb-1 block font-medium text-malba-gray-dark">Categoría</label>
                    <select name="category_id" class="w-full rounded-xl border border-malba-gray-lighter bg-malba-gray-light px-3 py-2 text-malba-gray-dark shadow-elegant transition-colors duration-200 focus:border-malba-rose-pale focus:bg-white focus:outline-none focus:ring-2 focus:ring-malba-rose-pale/20" required>
                        <option value="">Seleccionar categoría</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm font-medium text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('products.index') }}"
                        class="inline-flex items-center rounded-full border border-malba-gray-lighter bg-white px-4 py-2 text-sm font-semibold text-malba-gray-dark shadow-elegant transition-all duration-200 hover:border-malba-rose-pale hover:text-malba-rose-dark hover:shadow-elegant-lg">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center rounded-full bg-malba-rose-pale px-4 py-2 text-sm font-semibold text-white shadow-elegant transition-all duration-200 hover:bg-malba-rose-dark hover:shadow-elegant-lg">
                        Guardar
                    </button>
                </div>

            </form>
        </div>

    </div>
</x-app-layout>