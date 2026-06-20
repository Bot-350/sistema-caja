<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-malba-gray-dark leading-tight">
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
        <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter p-6 mb-6">
            <h3 class="text-lg font-semibold mb-4 text-malba-gray-dark">Nueva Categoría</h3>
            <form action="{{ route('categories.store') }}" method="POST" class="flex gap-4">
                @csrf
                <input
                    type="text"
                    name="name"
                    placeholder="Nombre de la categoría"
                    class="border-malba-gray-lighter rounded-lg px-3 py-2 flex-1 focus:border-malba-rose-pale focus:ring-2 focus:ring-malba-rose-pale/20 shadow-elegant"
                    required
                />
                <button type="submit" class="bg-malba-rose-pale text-white px-4 py-2 rounded-lg hover:bg-malba-rose-dark shadow-elegant">
                    Agregar
                </button>
            </form>
            @error('name')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        {{-- Lista de categorías --}}
        <div class="bg-white rounded-lg shadow-elegant border border-malba-gray-lighter">
            <table class="w-full text-left">
                <thead class="bg-malba-rose-pale">
                    <tr>
                        <th class="px-6 py-3 text-white font-semibold">#</th>
                        <th class="px-6 py-3 text-white font-semibold">Nombre</th>
                        <th class="px-6 py-3 text-white font-semibold">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                    <tr class="border-b border-malba-gray-lighter hover:bg-malba-gray-light transition-colors duration-150">
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $category->id }}</td>
                        <td class="px-6 py-3 text-malba-gray-dark">{{ $category->name }}</td>
                        <td class="px-6 py-3 flex gap-2">
                            {{-- Editar --}}
                            <button
                                onclick="openEdit({{ $category->id }}, '{{ $category->name }}')"
                                class="bg-malba-rose-pale text-white px-3 py-1 rounded-lg hover:bg-malba-rose-dark text-sm shadow-elegant transition-colors">
                                Editar
                            </button>
                            {{-- Eliminar --}}
                            <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                onsubmit="return confirm('¿Eliminar esta categoría?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600 text-sm shadow-elegant transition-colors">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-malba-gray-medium">
                            No hay categorías registradas.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Modal editar --}}
        <div id="editModal" class="fixed inset-0 bg-malba-gray-dark/20 hidden items-center justify-center">
            <div class="bg-white rounded-lg shadow-elegant-lg border border-malba-gray-lighter p-6 w-96">
                <h3 class="text-lg font-semibold mb-4 text-malba-gray-dark">Editar Categoría</h3>
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="text" id="editName" name="name"
                        class="border-malba-gray-lighter rounded-lg px-3 py-2 w-full mb-4 focus:border-malba-rose-pale focus:ring-2 focus:ring-malba-rose-pale/20 shadow-elegant" required />
                    <div class="flex gap-2 justify-end">
                        <button type="button" onclick="closeEdit()"
                            class="bg-malba-gray-light text-malba-gray-dark px-4 py-2 rounded-lg hover:bg-malba-gray-lighter border border-malba-gray-lighter">
                            Cancelar
                        </button>
                        <button type="submit"
                            class="bg-malba-rose-pale text-white px-4 py-2 rounded-lg hover:bg-malba-rose-dark shadow-elegant">
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