export function initProductsStockTable(selector, ajaxUrl) {
        return $(selector).DataTable({
            processing: true,
            serverSide: false,
            ajax: ajaxUrl,
            dom: '<"flex justify-between items-center mb-4"lf>t<"flex justify-center items-center mt-4"p>',
            
            classes: {
                ssPageButton: "px-4 py-2 border border-gray-400 rounded-md mx-1 hover:bg-gray-200 text-sm text-gray-800 cursor-pointer",
                sPageButtonActive: "bg-black text-white border-black font-bold",
                sLengthSelect: "border border-gray-300 rounded-lg px-5 py-1",
                sFilterInput: "border border-gray-300 rounded-lg px-3 py-1 ml-2 focus:ring-2 focus:ring-red-500 outline-none"
            },
            columnDefs: [
                { className: "text-center", targets: "_all" }
            ],
            columns: [
                { data: 'id', name: 'id' },
                { data: 'branch.name', name: 'branch.name' },
                { data: 'product.name', name: 'product.name' },
                { 
                    data: 'quantity', 
                    name: 'quantity',
                    render: (data) => parseFloat(data).toFixed(2)
                },
                { 
                    data: 'purchase_price', 
                    name: 'purchase_price', 
                    render: (data) => 'C$' + parseFloat(data).toFixed(2)
                },
                {
                    data: 'expiration_date',
                    name: 'expiration_date',
                    render: function(data, type, row) {
                        if (!data) return '<span class="text-gray-400 italic">N/A</span>';
                        
                        const expDate = new Date(data);
                        const today = new Date();
                        const diffTime = expDate - today;
                        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                        let statusConfig = {
                            class: 'text-gray-500', 
                            text: diffDays + ' d'
                        };

                        if (diffDays < 0) {
                            statusConfig = { class: 'text-red-700 font-bold', text: 'Vencido' };
                        } else if (diffDays <= 3) { 
                            statusConfig = { class: 'text-red-600 font-bold', text: diffDays + ' d' }; 
                        } else if (diffDays <= 7) {
                            statusConfig = { class: 'text-orange-600 font-bold', text: diffDays + ' d' }; 
                        } else if (diffDays <= 30) {
                            statusConfig = { class: 'text-blue-600 font-medium', text: diffDays + ' d' };
                        } else {
                            statusConfig = { class: 'text-gray-500', text: diffDays + ' d' }; 
                        }

                        return `
                            <div class="flex items-center gap-2 whitespace-nowrap">
                                <span class="text-sm text-gray-700">${data}</span>
                                <span class="text-[11px] uppercase tracking-wide ${statusConfig.class}">
                                    • ${statusConfig.text}
                                </span>
                            </div>
                        `;
                    }
                },
                { 
                    data: 'created_at', 
                    name: 'created_at',
                    render: function(data) {
                        return new Date(data).toLocaleString(); 
                    }
                },
                { 
                    data: 'updated_at',
                    name: 'updated_at', 
                    render: function(data) {
                        return new Date(data).toLocaleString();
                    }
                },
                {
                    data: null, 
                    orderable: false, 
                    searchable: false,
                    render: (data, type, row) => {
                        const rowData = JSON.stringify(row).replace(/"/g, '&quot;');
                        return `
                            <div class="flex justify-center items-center gap-2">
                                <button type="button" onclick="deleteProductStock(${row.id})" 
                                    class="px-3 py-1 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition-all duration-200 active:scale-95">
                                    Eliminar
                                </button>
                                <button type="button" onclick='ProductStockModal.open("edit", ${rowData})' 
                                    class="px-3 py-1 text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition-all duration-200 active:scale-95">
                                    Editar
                                </button>
                            </div>
                        `;
                    }
                }
            ]
        });
}