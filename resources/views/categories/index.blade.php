<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Categorías
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

        {{-- Formulario crear --}}
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4">Nueva Categoría</h3>
            <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4">
                @csrf
                <input
                    type="text"
                    name="name"
                    placeholder="Nombre de la categoría"
                    class="border rounded px-3 py-2 flex-1"
                    required
                />
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Agregar
                </button>
            </form>
            @error('name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lista de categorías --}}
        <div class="bg-white rounded-lg shadow">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b">
                    <tr>
                        <th class="px-6 py-3 text-gray-600">#</th>
                        <th class="px-6 py-3 text-gray-600">Nombre</th>
                        <th class="px-6 py-3 text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-3">{{ $category->id }}</td>
                        <td class="px-6 py-3">{{ $category->name }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            {{-- Editar --}}
                            <button
                                onclick="openEdit({{ $category->id }}, '{{ $category->name }}')"
                                class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm">
                                Editar
                            </button>
                            {{-- Eliminar --}}
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar esta categoría?')">
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
                        <td colspan="3" class="px-6 py-4 text-center text-gray-400">
                            No hay categorías registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal editar --}}
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
            <div class="bg-white rounded-lg shadow p-6 w-96">
                <h3 class="text-lg font-semibold mb-4">Editar Categoría</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" id="editName" name="name"
                        class="border rounded px-3 py-2 w-full mb-4" required />
                    <div class="flex gap-2 justify-end">
                        <button type="button" onclick="closeEdit()"
                            class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        function openEdit(id, name) {
            document.getElementById('editName').value = name;
            document.getElementById('editForm').action = '/categories/' + id;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEdit() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
    </script>

</x-app-layout>