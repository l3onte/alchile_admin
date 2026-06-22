<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {
        $categories = ProductCategory::all();
        return view('products.index', compact('categories'));
    }

    public function store(ProductRequest $request) {
        Product::create($request->validated());
        return response()->json(['success' => 'Producto creado con éxito.']);
    }

    public function update(ProductRequest $request, Product $product) {
        $product->update($request->validated());
        return response()->json(['success' => 'Producto actualizado con éxito.']);
    }

    public function destroy(Product $product) {
        $product->delete();
        return response()->json(['success' => 'Producto eliminado con exito.']);
    }

    public function getData() {
        $products = Product::with('category')->get();
        return response()->json(['data' => $products]);
    }
}
