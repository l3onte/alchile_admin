import Swal from "sweetalert2";

const BranchForm = document.getElementById('branch-form');

if (BranchForm) {
    BranchForm.addEventListener('submit', function(e) {
        e.preventDefault();
    
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
            const data = await response.json(); 
            if (!response.ok) {
                console.error("Error del servidor:", data); 
                throw new Error(JSON.stringify(data.errors || data.message));
            }
            return data;
        })
        .then(data => {
            BranchModal.close();
            $('#branch-table').DataTable().ajax.reload();
            
            Swal.fire({
                icon: 'success',
                title: '¡Operación exitosa!',
                text: 'La sucursal ha sido guardado correctamente.',
                timer: 2000,
                showConfirmButton: false
            });
        })
        .catch(error => {
            Swal.fire('Error', 'No se pudo guardar la sucursal.', 'error');
        });
    });
}

export const BranchModal = {
    modal: document.getElementById('branch-modal'),
    form: document.getElementById('branch-form'),
    title: document.getElementById('modal-title'),
    methodField: document.getElementById('method-field'),

    open(action = 'create', data = null) {
        this.modal.classList.remove('hidden');
        if (action === 'create') {
            this.title.innerText = 'Nueva Sucursal';
            this.form.action = "/branch"; 
            this.methodField.value = 'POST';
            this.form.reset();
        } else {
            this.title.innerText = 'Editar Sucursal';
            this.form.action = `/branch/${data.id}`;
            this.methodField.value = 'PUT';
            
            document.getElementById('branch-admin_id').value = data.admin_id;
            document.getElementById('branch-name').value = data.name;
            document.getElementById('branch-phone').value = data.phone;
            document.getElementById('branch-address').value = data.address;
        }
    },

    close() {
        this.modal.classList.add('hidden');
    }
}

export function deleteBranch(id) {
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
            fetch(`/branch/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(() => {
                $('#branch-table').DataTable().ajax.reload();
                Swal.fire('¡Eliminado!', 'La sucursal ha sido borrado.', 'success');
            })
            .catch(() => Swal.fire('Error', 'No se pudo eliminar.', 'error'));
        }
    });
}