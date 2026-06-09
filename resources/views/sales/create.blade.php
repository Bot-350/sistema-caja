<x-app-layout>

    <div class="flex h-screen overflow-hidden" style="height: calc(100vh - 64px)">

        {{-- Columna izquierda --}}
        <div class="flex-1 flex flex-col overflow-hidden bg-gray-50 p-4">

            {{-- Buscador y cliente --}}
            <div class="flex gap-3 mb-4">
                <div class="flex-1 relative">
                    <input type="text" id="searchProduct"
                        placeholder="Buscar producto..."
                        class="border rounded-lg px-4 py-2 w-full pl-10 bg-white" />
                    <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                    </svg>
                </div>
                <select name="customer_id" id="customer_id" class="border rounded-lg px-3 py-2 bg-white w-48">
                    <option value="">Sin cliente</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer->id }}" data-birthday="{{ $customer->birthday ? $customer->birthday->format('Y-m-d') : '' }}">{{ $customer->name }}</option>
                    @endforeach
                </select>
            </div>

            <div id="birthdayAlert" class="hidden mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                🎂 Cliente con cumpleaños próximo. Considere aplicar una promoción.
            </div>

            {{-- Categorías --}}
            <div class="flex gap-2 mb-4 overflow-x-auto pb-1">
                <button type="button" onclick="filterCategory('all')"
                    class="category-btn active-cat px-4 py-2 rounded-lg border bg-white text-sm whitespace-nowrap font-medium">
                    Todos
                </button>
                @foreach($products->groupBy('category.name') as $catName => $catProducts)
                <button type="button" onclick="filterCategory('{{ strtolower($catName) }}')"
                    class="category-btn px-4 py-2 rounded-lg border bg-white text-sm whitespace-nowrap text-gray-600">
                    {{ $catName }}
                    <span class="text-gray-400 text-xs ml-1">{{ $catProducts->count() }}</span>
                </button>
                @endforeach
            </div>

            {{-- Grid de productos --}}
            <div id="productGrid" class="grid grid-cols-3 gap-3 overflow-y-auto flex-1">
                @foreach($products as $product)
                <div class="product-card bg-white border rounded-xl p-4 cursor-pointer hover:border-blue-400 hover:shadow-sm transition"
                    data-name="{{ strtolower($product->name) }}"
                    data-category="{{ strtolower($product->category->name) }}"
                    onclick="addProduct({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }})">
                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                        </svg>
                    </div>
                    <p class="font-medium text-sm text-gray-800">{{ $product->name }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $product->category->name }}</p>
                    <p class="text-blue-600 font-semibold text-sm mt-2">{{ number_format($product->price, 2) }} Bs</p>
                </div>
                @endforeach
            </div>

        </div>

        {{-- Columna derecha - Ticket --}}
        <div class="w-80 bg-white border-l flex flex-col">

            <form action="{{ route('sales.store') }}" method="POST" id="saleForm" class="flex flex-col h-full">
                @csrf
                <input type="hidden" name="customer_id" id="customer_id_input">

                {{-- Header ticket --}}
                <div class="p-4 border-b">
                    <h3 class="font-semibold text-gray-800">Ticket</h3>
                    <p id="customerName" class="text-xs text-gray-400 mt-1">Sin cliente</p>
                </div>

                {{-- Items del ticket --}}
                <div id="ticketItems" class="flex-1 overflow-y-auto p-4 space-y-3">
                    <p id="emptyTicket" class="text-gray-400 text-center text-sm py-8">
                        Agrega productos al ticket
                    </p>
                </div>

                {{-- Totales --}}
                <div class="border-t p-4">
                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                        <span>Subtotal</span>
                        <span id="subtotalAmount">0.00 Bs</span>
                    </div>
                    <div class="mb-3">
                        <label for="discount_percentage" class="block text-xs text-gray-500 mb-1 font-medium">Descuento (%)</label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="discount_percentage" id="discount_percentage"
                                value="0" min="0" max="100" step="1"
                                class="border rounded-lg px-3 py-2 w-full bg-white" />
                        </div>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                        <span>Descuento aplicado</span>
                        <span id="discountPercentageView">0%</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500 mb-1">
                        <span>Monto descontado</span>
                        <span id="discountAmountView">0.00 Bs</span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg text-gray-800 mb-4">
                        <span>Total final</span>
                        <span id="totalAmount">0.00 Bs</span>
                    </div>

                    {{-- Método de pago --}}
                    <p class="text-xs text-gray-500 mb-2 font-medium">Método de pago</p>
                    <div class="flex gap-2 mb-4">
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="payment_method" value="efectivo" class="sr-only peer" checked>
                            <div class="border-2 rounded-lg p-2 text-center text-sm peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 text-gray-500 transition">
                                💵 Efectivo
                            </div>
                        </label>
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="payment_method" value="qr" class="sr-only peer">
                            <div class="border-2 rounded-lg p-2 text-center text-sm peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:text-blue-600 text-gray-500 transition">
                                📱 QR
                            </div>
                        </label>
                    </div>

                    {{-- Botones --}}
                    <button type="submit"
                        class="bg-blue-600 text-white py-3 rounded-xl w-full font-semibold hover:bg-blue-700 transition mb-2">
                        Registrar Venta
                    </button>
                    <a href="{{ route('sales.index') }}"
                        class="block text-center text-gray-500 text-sm py-2 hover:text-gray-700">
                        Cancelar
                    </a>
                </div>

            </form>
        </div>

    </div>

    <style>
        .active-cat { border-color: #3b82f6; color: #3b82f6; background: #eff6ff; }
    </style>

    <script>
        let items = {};

        // Sincronizar cliente
        document.getElementById('customer_id').addEventListener('change', function() {
            document.getElementById('customer_id_input').value = this.value;
            const text = this.options[this.selectedIndex].text;
            document.getElementById('customerName').textContent = this.value ? text : 'Sin cliente';
        });

        // Buscar productos
        document.getElementById('searchProduct').addEventListener('input', function() {
            const search = this.value.toLowerCase();
            document.querySelectorAll('.product-card').forEach(card => {
                card.style.display = card.dataset.name.includes(search) ? 'block' : 'none';
            });
        });

        // Filtrar por categoría
        function filterCategory(cat) {
            document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active-cat'));
            event.target.classList.add('active-cat');
            document.querySelectorAll('.product-card').forEach(card => {
                card.style.display = (cat === 'all' || card.dataset.category === cat) ? 'block' : 'none';
            });
        }

        // Agregar producto
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
            container.innerHTML = '';

            if (Object.keys(items).length === 0) {
                const msg = document.createElement('p');
                msg.className = 'text-gray-400 text-center text-sm py-8';
                msg.textContent = 'Agrega productos al ticket';
                container.appendChild(msg);
                document.getElementById('totalAmount').textContent = '0.00 Bs';
                document.getElementById('subtotalAmount').textContent = '0.00 Bs';
                return;
            }

            Object.entries(items).forEach(([id, item], index) => {
                const div = document.createElement('div');
                div.className = 'flex items-center gap-2 py-2 border-b';
                div.innerHTML = `
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">${item.name}</p>
                        <p class="text-xs text-gray-400">${item.price.toFixed(2)} Bs c/u</p>
                        <input type="hidden" name="items[${index}][product_id]" value="${id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.quantity}">
                    </div>
                    <div class="flex items-center gap-1">
                        <button type="button" onclick="changeQty(${id}, -1)"
                            class="w-6 h-6 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm">−</button>
                        <span class="w-6 text-center text-sm font-medium">${item.quantity}</span>
                        <button type="button" onclick="changeQty(${id}, 1)"
                            class="w-6 h-6 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-gray-600 font-bold text-sm">+</button>
                    </div>
                    <div class="text-right min-w-14">
                        <p class="text-sm font-semibold text-gray-800">${(item.price * item.quantity).toFixed(2)} Bs</p>
                        <button type="button" onclick="removeItem(${id})" class="text-red-400 hover:text-red-600 text-xs">eliminar</button>
                    </div>
                `;
                container.appendChild(div);
            });

            updateTotal();
        }

        function changeQty(id, delta) {
            items[id].quantity += delta;
            if (items[id].quantity <= 0) delete items[id];
            renderTicket();
        }

        function removeItem(id) {
            delete items[id];
            renderTicket();
        }

        function updateTotal() {
            const subtotal = Object.values(items).reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const discountPercentage = Math.min(Math.max(parseFloat(document.getElementById('discount_percentage').value || '0'), 0), 100);
            const discountAmount = Math.max(subtotal * discountPercentage / 100, 0);
            const total = Math.max(subtotal - discountAmount, 0);

            document.getElementById('subtotalAmount').textContent = subtotal.toFixed(2) + ' Bs';
            document.getElementById('discountPercentageView').textContent = discountPercentage.toFixed(0) + '%';
            document.getElementById('discountAmountView').textContent = discountAmount.toFixed(2) + ' Bs';
            document.getElementById('totalAmount').textContent = total.toFixed(2) + ' Bs';
        }

        // Descuento
        function setDiscount(value) {
            const input = document.getElementById('discount_percentage');
            const parsed = Math.min(Math.max(parseFloat(value || '0'), 0), 100);
            input.value = parsed;
            updateTotal();
        }

        const discountField = document.getElementById('discount_percentage');
        discountField.addEventListener('input', function() {
            setDiscount(this.value);
        });

        // Aviso de cumpleaños próximo
        function updateBirthdayAlert() {
            const select = document.getElementById('customer_id');
            const option = select.options[select.selectedIndex];
            const birthdayValue = option ? option.dataset.birthday : '';
            const alertBox = document.getElementById('birthdayAlert');

            if (!birthdayValue) {
                alertBox.classList.add('hidden');
                return;
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const birthday = new Date(birthdayValue + 'T00:00:00');
            let nextBirthday = new Date(today.getFullYear(), birthday.getMonth(), birthday.getDate());
            if (nextBirthday < today) {
                nextBirthday.setFullYear(nextBirthday.getFullYear() + 1);
            }

            const diffDays = Math.round((nextBirthday - today) / (1000 * 60 * 60 * 24));
            const shouldShow = diffDays >= 0 && diffDays <= 7;
            alertBox.classList.toggle('hidden', !shouldShow);
        }

        document.getElementById('customer_id').addEventListener('change', function() {
            updateBirthdayAlert();
        });

        setDiscount(0);
        updateBirthdayAlert();
    </script>

</x-app-layout>