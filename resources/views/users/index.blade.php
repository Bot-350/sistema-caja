<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-malba-gray-dark leading-tight">
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
                class="bg-malba-rose-pale text-white px-4 py-2 rounded-lg hover:bg-malba-rose-dark shadow-elegant">
                + Nuevo Usuario
            </a>
        </div>

        {{-- Lista de usuarios --}}
        <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter">
            <table class="w-full text-left">
                <thead class="bg-malba-rose-pale">
                    <tr>
                        <th class="px-6 py-3 text-white font-semibold">#</th>
                        <th class="px-6 py-3 text-white font-semibold">Nombre</th>
                        <th class="px-6 py-3 text-white font-semibold">Correo</th>
                        <th class="px-6 py-3 text-white font-semibold">Rol</th>
                        <th class="px-6 py-3 text-white font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr class="border-b border-malba-gray-lighter hover:bg-malba-gray-light transition-colors duration-150">
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $user->id }}</td>
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $user->name }}</td>
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $user->email }}</td>
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
                                class="bg-malba-rose-pale text-white px-3 py-1 rounded-lg hover:bg-malba-rose-dark text-sm shadow-elegant transition-colors">
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
                        <td colspan="5" class="px-6 py-4 text-center text-malba-gray-medium">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>