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

import { initBranchTable } from './datatables/branchs';
import { BranchModal } from './branchsLogic';
import { deleteBranch } from './branchsLogic';

window.initBranchTable = initBranchTable;
window.BranchModal = BranchModal;
window.deleteBranch = deleteBranch;

import { initProductsStockTable } from './datatables/products_stock';
import { ProductStockModal } from './products_stock_logic';
import { deleteProductStock } from './products_stock_logic';

window.initProductsStockTable = initProductsStockTable;
window.ProductStockModal = ProductStockModal;
window.deleteProductStock = deleteProductStock;

window.Alpine = Alpine;
window.Swal = Swal;

Alpine.start();
