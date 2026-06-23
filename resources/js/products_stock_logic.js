const productStockForm = document.getElementById('product_stock-form');

if (productStockForm) {
    productStockForm.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Procesando...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        })

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
            const data = await response.json();
            if (!response.ok) {
                console.error("Error del servidor:", data);
                throw new Error(JSON.stringify(data.errors || data.message));
            }
            return data;
        })
        .then(data => {
            ProductStockModal.close();
            $('#products_stock-table').DataTable().ajax.reload();

            Swal.fire({
                icon: 'success',
                title: '¡Operacion exitosa!',
                text: 'El producto a sigo registrado con exito.',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            Swal.fire('Error', 'No se pudo guardar el nuevo stock.', 'error');
        })
    });
}

export const ProductStockModal = {
    modal: document.getElementById('product_stock-modal'),
    form: document.getElementById('product_stock-form'),
    title: document.getElementById('modal-title'),
    methodField: document.getElementById('method-field'),

   open(action = 'create', data = null) {
        this.modal.classList.remove('hidden');
        if (action === 'create') {
            this.title.innerText = 'Agregar al Stock';
            this.form.action = "/products_stock";
            this.methodField.value = 'POST';
            this.form.reset();
        } else {
            this.title.innerText = 'Editar Categoria';
            this.form.action = `/products_stock/${data.id}`;
            this.methodField.value = 'PUT';

            document.getElementById('stock-branch_id').value = data.branch_id;
            document.getElementById('stock-product_id').value = data.product_id;
            document.getElementById('stock-quantity').value = data.quantity;
            document.getElementById('stock-purchase_price').value = data.purchase_price;
            document.getElementById('stock-expiration').value = data.expiration_date;
        }
    },

    close() {
        this.modal.classList.add('hidden');
    }
}

export function deleteProductStock(id) {
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
            fetch(`/products_stock/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(() => {
                $('#products_stock-table').DataTable().ajax.reload();
                Swal.fire('¡Eliminado!', 'El producto ha sido borrado.', 'success');
            })
            .catch(() => Swal.fire('Error', 'No se pudo eliminar.', 'error'));
        }
    });
}