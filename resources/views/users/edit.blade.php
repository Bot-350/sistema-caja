<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="py-6 max-w-2xl mx-auto px-4">

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Nombre --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="border rounded px-3 py-2 w-full" required />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Correo --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Correo electrónico</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="border rounded px-3 py-2 w-full" required />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Contraseña --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">
                        Nueva contraseña
                        <span class="text-gray-400 font-normal text-sm">(dejar en blanco para no cambiar)</span>
                    </label>
                    <input type="password" name="password"
                        class="border rounded px-3 py-2 w-full" />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-4">
                    <label class="block text-gray-700 font-medium mb-1">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation"
                        class="border rounded px-3 py-2 w-full" />
                </div>

                {{-- Rol --}}
                <div class="mb-6">
                    <label class="block text-gray-700 font-medium mb-1">Rol</label>
                    <select name="role" class="border rounded px-3 py-2 w-full" required>
                        <option value="cajero" {{ old('role', $user->role) === 'cajero' ? 'selected' : '' }}>Cajero</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Botones --}}
                <div class="flex gap-2 justify-end">
                    <a href="{{ route('users.index') }}"
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