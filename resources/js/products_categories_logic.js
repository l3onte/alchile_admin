import Swal from "sweetalert2";

const categoryForm = document.getElementById('products_categories-form');

if (categoryForm) {
    categoryForm.addEventListener('submit', function(e) {
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
            ProductCategorieModal.close();
            $('#products_categories-table').DataTable().ajax.reload();

            Swal.fire({
                icon: 'success',
                title: '¡Operacion exitosa!',
                text: 'La categoria ha sido guardad correctamente.',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            Swal.fire('Error', 'No se pudo guardar el producto.', 'error');
        })
    })
}

export const ProductCategorieModal = {
    modal: document.getElementById('products_categories-modal'),
    form: document.getElementById('products_categories-form'),
    title: document.getElementById('modal-title'),
    methodField: document.getElementById('method-field'),

    open(action = 'create', data = null) {
        this.modal.classList.remove('hidden');
        if (action === 'create') {
            this.title.innerText = 'Nueva Categoria';
            this.form.action = "/products_categories";
            this.methodField.value = 'POST';
            this.form.reset();
        } else {
            this.title.innerText = 'Editar Categoria';
            this.form.action = `/products_categories/${data.id}`;
            this.methodField.value = 'PUT';

            document.getElementById('category-name').value = data.name;
            document.getElementById('category-type').value = data.type;
        }
    },

    close() {
        this.modal.classList.add('hidden');
    }
}

export function deleteCategorie(id) {
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
            fetch(`/products_categories/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(() => {
                $('#products_categories-table').DataTable().ajax.reload();
                Swal.fire('¡Eliminado!', 'El producto ha sido borrado.', 'success');
            })
            .catch(() => Swal.fire('Error', 'No se pudo eliminar.', 'error'));
        }
    });
}