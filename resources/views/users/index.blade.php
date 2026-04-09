<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Usuarios
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">

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
            <a href="{{ route('users.create') }}"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nuevo Usuario
            </a>
        </div>

        {{-- Lista de usuarios --}}
        <div class="bg-white rounded-lg shadow">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-gray-600">#</th>
                        <th class="px-6 py-3 text-gray-600">Nombre</th>
                        <th class="px-6 py-3 text-gray-600">Correo</th>
                        <th class="px-6 py-3 text-gray-600">Rol</th>
                        <th class="px-6 py-3 text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $user->id }}</td>
                        <td class="px-6 py-3">{{ $user->name }}</td>
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3">
                            @if($user->role === 'admin')
                                <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">
                                    Admin
                                </span>
                            @else
                                <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                                    Cajero
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-3 flex gap-2">
                            <a href="{{ route('users.edit', $user) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                                Editar
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.destroy', $user) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar este usuario?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">
                                    Eliminar
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-400">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>