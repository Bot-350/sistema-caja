<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Cliente
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('customers.update', $customer) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}"
                        class="border rounded px-3 py-2 w-full" required />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Teléfono --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Teléfono</label>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Correo --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cumpleaños --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Cumpleaños</label>
                    <input type="date" name="birthday"
                        value="{{ old('birthday', $customer->birthday ? $customer->birthday->format('Y-m-d') : '') }}"
                        class="border rounded px-3 py-2 w-full" />
                    @error('birthday')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('customers.index') }}"
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