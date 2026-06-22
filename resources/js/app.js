import './bootstrap';

import Swal from 'sweetalert2';
import Alpine from 'alpinejs';
import { initProductTable } from './datatables/products';
import { ProductModal } from './productsLogic';
import { deleteProduct } from './productsLogic';

window.Alpine = Alpine;
window.initProductTable = initProductTable;
window.ProductModal = ProductModal;
window.deleteProduct = deleteProduct;
window.Swal = Swal;

Alpine.start();
