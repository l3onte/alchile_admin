<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductsCategoriesRequest;
use App\Http\Requests\ProductStockRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class ProductStockController extends Controller
{
    public function index() {
       $branches = Branch::all();
       $products = Product::all(); 
       return view('products_stock.index', compact('branches', 'products'));
    }

    public function store(ProductStockRequest $request) {
        $stock = ProductStock::where('branch_id', $request->branch_id)
                               ->where('product_id', $request->product_id)
                               ->first();

        if ($stock) {
            $stock->quantity += $request->quantity;
            $stock->purchase_price = $request->purchase_price;
            $stock->save();
        } else {
            ProductStock::create($request->validated());
        }

        return response()->json(['success' => 'Se agrego el nuevo stock al inventario con exito.']);
    }

    public function update(ProductStockRequest $request, $id) {
        $productStock = ProductStock::findOrFail($id);
        $validate = $request->validated();
        $productStock->update($validate);
        return response()->json(['success' => 'La informacion del stock se actualizo con exito.']);
    }

    public function destroy($id) {
        $productStock = ProductStock::findOrFail($id);
        $productStock->delete();
        return response()->json(['succcess' => 'Se elimino el producto del inventario correctamente.']);
    }

    public function getData() {
        $productsStock = ProductStock::with(['branch', 'product'])->get();
        return response()->json(['data' => $productsStock]);
    }
}
