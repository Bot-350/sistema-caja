<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nueva Venta
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto px-4">

        <form action="{{ route('sales.store') }}" method="POST" id="saleForm">
            @csrf

            <div class="grid grid-cols-2 gap-6">

                {{-- Columna izquierda --}}
                <div>

                    {{-- Cliente --}}
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Cliente</h3>
                        <select name="customer_id" class="border rounded px-3 py-2 w-full">
                            <option value="">Sin cliente</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Método de pago --}}
                    <div class="bg-white rounded-lg shadow p-6 mb-6">
                        <h3 class="text-lg font-semibold mb-4">Método de pago</h3>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="efectivo" checked />
                                Efectivo
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="payment_method" value="qr" />
                                QR
                            </label>
                        </div>
                    </div>

                    {{-- Búsqueda de productos --}}
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-4">Buscar Producto</h3>
                        <input type="text" id="searchProduct" placeholder="Escribir nombre del producto..."
                            class="border rounded px-3 py-2 w-full mb-4" />
                        <div id="productList" class="space-y-2 max-h-64 overflow-y-auto">
                            @foreach($products as $product)
                            <div class="product-item border rounded px-3 py-2 flex justify-between items-center hover:bg-gray-50 cursor-pointer"
                                data-name="{{ strtolower($product->name) }}"
                                onclick="addProduct({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">
                                <div>
                                    <span class="font-medium">{{ $product->name }}</span>
                                    <span class="text-gray-400 text-sm ml-2">{{ $product->category->name }}</span>
                                </div>
                                <span class="text-blue-600 font-medium">{{ number_format($product->price, 2) }} Bs</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- Columna derecha - Ticket --}}
                <div>
                    <div class="bg-white rounded-lg shadow p-6 sticky top-4">
                        <h3 class="text-lg font-semibold mb-4">Ticket</h3>

                        <div id="ticketItems" class="space-y-2 mb-4 min-h-32">
                            <p id="emptyTicket" class="text-gray-400 text-center py-8">
                                Agrega productos al ticket
                            </p>
                        </div>

                        <div class="border-t pt-4">
                            <div class="flex justify-between text-xl font-bold">
                                <span>Total:</span>
                                <span id="totalAmount">0.00 Bs</span>
                            </div>
                        </div>

                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-3 rounded w-full mt-4 hover:bg-blue-700 text-lg font-semibold">
                            Registrar Venta
                        </button>

                        <a href="{{ route('sales.index') }}"
                            class="block text-center bg-gray-200 px-4 py-3 rounded w-full mt-2 hover:bg-gray-300">
                            Cancelar
                        </a>
                    </div>
                </div>

            </div>

        </form>
    </div>

    <script>
        let items = {};

        // Buscar productos
        document.getElementById('searchProduct').addEventListener('input', function() {
            const search = this.value.toLowerCase();
            document.querySelectorAll('.product-item').forEach(item => {
                item.style.display = item.dataset.name.includes(search) ? 'flex' : 'none';
            });
        });

        // Agregar producto al ticket
        function addProduct(id, name, price) {
            if (items[id]) {
                items[id].quantity++;
            } else {
                items[id] = { name, price, quantity: 1 };
            }
            renderTicket();
        }

        // Renderizar ticket
        function renderTicket() {
            const container = document.getElementById('ticketItems');
            const empty = document.getElementById('emptyTicket');
            container.innerHTML = '';

            if (Object.keys(items).length === 0) {
                container.innerHTML = '';
                const emptyMsg = document.createElement('p');
                emptyMsg.className = 'text-gray-400 text-center py-8';
                emptyMsg.textContent = 'Agrega productos al ticket';
                container.appendChild(emptyMsg);
                document.getElementById('totalAmount').textContent = '0.00 Bs';
                return;
            }

            Object.entries(items).forEach(([id, item], index) => {
                const div = document.createElement('div');
                div.className = 'flex justify-between items-center border-b pb-2';
                div.innerHTML = `
                    <div class="flex-1">
                        <p class="font-medium text-sm">${item.name}</p>
                        <p class="text-gray-400 text-xs">${item.price.toFixed(2)} Bs c/u</p>
                        <input type="hidden" name="items[${index}][product_id]" value="${id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    </div>
                    <div class="flex items-center gap-2">
                        <button type="button" onclick="changeQty(${id}, -1)"
                            class="bg-gray-200 px-2 rounded hover:bg-gray-300">-</button>
                        <span class="w-6 text-center">${item.quantity}</span>
                        <button type="button" onclick="changeQty(${id}, 1)"
                            class="bg-gray-200 px-2 rounded hover:bg-gray-300">+</button>
                        <button type="button" onclick="removeItem(${id})"
                            class="text-red-500 hover:text-red-700 ml-2">✕</button>
                    </div>
                    <div class="ml-4 text-right">
                        <span class="font-medium">${(item.price * item.quantity).toFixed(2)} Bs</span>
                    </div>
                `;
                container.appendChild(div);
            });

            updateTotal();
        }

        // Cambiar cantidad
        function changeQty(id, delta) {
            items[id].quantity += delta;
            if (items[id].quantity <= 0) delete items[id];
            renderTicket();
        }

        // Eliminar item
        function removeItem(id) {
            delete items[id];
            renderTicket();
        }

        // Actualizar total
        function updateTotal() {
            const total = Object.values(items).reduce((sum, item) => sum + (item.price * item.quantity), 0);
            document.getElementById('totalAmount').textContent = total.toFixed(2) + ' Bs';
        }
    </script>

</x-app-layout>