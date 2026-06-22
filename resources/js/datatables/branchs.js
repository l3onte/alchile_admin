export function initBranchTable(selector, ajaxUrl) {
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
            { data: 'user.name', name: 'user.name' },
            { data: 'name', name: 'name' },
            { data: 'phone', name: 'phone' },
            { data: 'address', name: 'address' },
            {
                data: null, 
                orderable: false, 
                searchable: false,
                render: (data, type, row) => {
                    const rowData = JSON.stringify(row).replace(/"/g, '&quot;');
                    
                    return `
                        <div class="flex justify-center items-center gap-2">
                            <button type="button" onclick="deleteBranch(${row.id})" 
                                class="px-3 py-1 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg">
                                Eliminar
                            </button>
                            <button type="button" onclick='BranchModal.open("edit", ${rowData})' 
                                class="px-3 py-1 text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg">
                                Editar
                            </button>
                        </div>
                    `;
                }
            }
        ],
        language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json" }
    })
}