<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex-justify-start mb-2">
                <button type="button" onclick="ProductStockModal.open('create')" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    + Agregar Stock
                </button>
            </div>
            <div class="bg-white p-6 shadow-sm sm:rounded-xl border border-gray-200">
                <table id="products_stock-table" class="w-full text-sm text-left text-gray-500 border-separate border-spacing-y-4">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Id</th>
                            <th class="px-4 py-3">Sucursal</th>
                            <th class="px-4 py-3">Producto</th>
                            <th class="px-4 py-3">Cantidad</th>
                            <th class="px-4 py-3">Precio Compra</th>
                            <th class="px-4 py-3">Expiracion</th>
                            <th class="px-4 py-3">Fecha de Ingreso</th>
                            <th class="px-4 py-3">Ultima Actualizacion</th>
                            <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div id="product_stock-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-60 backdrop-blur-sm">
        <div class="bg-white p-8 rounded-2xl shadow-2xl w-full max-w-lg border border-gray-100 transform transition-all">
            <h2 id="modal-title" class="text-2xl font-extrabold text-gray-800 mb-6 border-b pb-4">Agregar Stock</h2>
            
            <form id="product_stock-form" method="POST">
                @csrf
                <input type="hidden" id="method-field" name="_method" value="POST">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Sucursal</label>
                        <select name="branch_id" id="stock-branch_id" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 shadow-sm transition">
                            <option value="">Seleccione...</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Producto</label>
                        <select name="product_id" id="stock-product_id" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 shadow-sm transition">
                            <option value="">Seleccione...</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Cantidad</label>
                        <input type="number" name="quantity" id="stock-quantity" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 shadow-sm transition">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Precio de Compra</label>
                        <input type="number" name="purchase_price" id="stock-purchase_price" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 shadow-sm transition">
                    </div>

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">Expiracion</label>
                        <input type="date" name="expiration_date" id="stock-expiration" class="w-full border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500 shadow-sm transition">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t">
                    <button type="button" onclick="ProductStockModal.close()" class="px-5 py-2.5 text-gray-600 font-semibold hover:bg-gray-100 rounded-xl transition">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-2.5 rounded-xl shadow-lg shadow-red-200 transition active:scale-95">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function() {
                if (typeof window.initProductsStockTable === 'function') {
                    window.initProductsStockTable('#products_stock-table', "{{ route('products_stock.data') }}");
                } else {
                    console.error("La funcion initProductsCategoriesTable no esta definida.");
                }
            })
        </script>
    @endpush
</x-app-layout>