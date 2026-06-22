import './bootstrap';

import Swal from 'sweetalert2';
import Alpine from 'alpinejs';

import { initProductTable } from './datatables/products';
import { ProductModal } from './productsLogic';
import { deleteProduct } from './productsLogic';

window.initProductTable = initProductTable;
window.ProductModal = ProductModal;
window.deleteProduct = deleteProduct;

import { initProductsCategoriesTable } from './datatables/products_categories';
import { ProductCategorieModal } from './products_categories_logic';
import { deleteCategorie } from './products_categories_logic';

window.initProductsCategoriesTable = initProductsCategoriesTable;
window.ProductCategorieModal = ProductCategorieModal;
window.deleteCategorie = deleteCategorie;

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();
