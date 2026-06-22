document.getElementById('product-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Indicador de cargando
    Swal.fire({
        title: 'Procesando...',
        allowOutsideClick: false,
        didOpen: () => { Swal.showLoading(); }
    });

    let formData = new FormData(this);
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(async response => {
        const data = await response.json(); // Esperar el JSON
        if (!response.ok) {
            // AQUÍ VERÁS EL ERROR REAL SI EL SERVIDOR FALLA
            console.error("Error del servidor:", data); 
            throw new Error(JSON.stringify(data.errors || data.message));
        }
        return data;
    })
    .then(data => {
        ProductModal.close();
        $('#products-table').DataTable().ajax.reload();
        
        // Mensaje de éxito
        Swal.fire({
            icon: 'success',
            title: '¡Operación exitosa!',
            text: 'El producto ha sido guardado correctamente.',
            timer: 2000,
            showConfirmButton: false
        });
    })
    .catch(error => {
        Swal.fire('Error', 'No se pudo guardar el producto.', 'error');
    });
});

export const ProductModal = {
    modal: document.getElementById('product-modal'),
    form: document.getElementById('product-form'),
    title: document.getElementById('modal-title'),
    methodField: document.getElementById('method-field'),

    open(action = 'create', data = null) {
        this.modal.classList.remove('hidden');
        if (action === 'create') {
            this.title.innerText = 'Nuevo Producto';
            this.form.action = "/product"; 
            this.methodField.value = 'POST';
            this.form.reset();
        } else {
            this.title.innerText = 'Editar Producto';
            this.form.action = `/product/${data.id}`;
            this.methodField.value = 'PUT';
            
            document.getElementById('product-sku').value = data.sku;
            document.getElementById('product-category').value = data.id_category;
            document.getElementById('product-name').value = data.name;
            document.getElementById('product-precio_compra').value = data.purchase_price;
            document.getElementById('product-precio_venta').value = data.sell_price;
            document.getElementById('product-unidad').value = data.unit;
        }
    },

    close() {
        this.modal.classList.add('hidden');
    }
};

export function deleteProduct(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/product/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(() => {
                $('#products-table').DataTable().ajax.reload();
                Swal.fire('¡Eliminado!', 'El producto ha sido borrado.', 'success');
            })
            .catch(() => Swal.fire('Error', 'No se pudo eliminar.', 'error'));
        }
    });
}